import sys, os
sys.path.append(os.getcwd()+'/APPLICATION')
import requests
import json
import DB_Connectors
import Price_Calculations

#GLOBAL VARIABLES
SUB_CATEGROY = 101
SHOP = 'CASIO'

#INTIAL VARIABES FR PRICE CALCULATION
RATE = DB_Connectors.get_rate_and_cost()['rate']
SHIPPING_COST = DB_Connectors.get_rate_and_cost()['cost']
SHIPPING_COST_UNIT = DB_Connectors.get_unit_weight_cost(SUB_CATEGROY)
dict_profit_group_profit = DB_Connectors.generate_price_group_profit()
group_schema = DB_Connectors.get_profit_schema()

#Function Take SKU and return price list
def get_product_price(sku):
    headers = {
        'authority':'www.casio.com', 'method':'GET', 'accept': 'application/json', 'accept-encoding':'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9', 'content-type':'application/json', 'store':'us_store_view',
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36 Edg/107.0.1418.56',
        'x-kl-ajax-request':'Ajax_Request',
    }
    url = 'https://www.casio.com/us/graphql?query={products(filter:+{sku:+{in:[%22'+sku+'%22]}},sort:{name:+ASC},pageSize:+40){items+{sku+casio_members_only_flg+casio_sales_type+stock_status+casio_can_purchase+casio_sales_start_date+casio_sales_end_date+casio_pre_order_start_date+casio_pre_order_end_date+casio_stock_alert+casio_catalog_price_rule_description+lottery_url+casio_dealer_product_search+casio_hide_bag_button+store_inventory_search+shop_inventory{shopcode+shopname+shopurl+status+quantity}price_range{minimum_price{regular_price{value+currency}final_price{value+currency}discount{amount_off+percent_off}}maximum_price{regular_price{value+currency}final_price{value+currency}discount{amount_off+percent_off}}}...+on+BundleProduct{items{option_id+option_type_id+options{id+price+is_default+product{sku+stock_status}}}}...+on+CustomizableProductInterface{options{option_id+title+required+sort_order...+on+CustomizableFieldOption{field_option:value{sku}}}}}}}'

    _response = requests.get(url, headers=headers , timeout=50)
    _data_set = json.loads(_response.content)['data']['products']['items']
    try:
        price_befor = _data_set[0]['price_range']['maximum_price']['regular_price']['value']
        price_after = _data_set[0]['price_range']['maximum_price']['final_price']['value']
        discount = _data_set[0]['price_range']['maximum_price']['discount']['percent_off']
    except:
        price_befor = -1.0
        price_after = -1.0
        discount = -1.0

    return({
        'price_befor':price_befor,
        'price_after':price_after,
        'discount':discount
    })


#Scrap all Watches products once (Notice: contains url to get images and also contains one the main img)
url = "https://www.casio.com/content/casio/locales/us/en/products/watches/jcr:content/root/responsivegrid/container/product_panel_list_f.products.json"
_response = requests.get(url)
_data_set = json.loads(_response.content)


products_list = []
for item in range(0,len(_data_set['data'])-1):
#for item in range(500,510):
    product_refferernce = _data_set['data'][item]['sku']
    brand = _data_set['data'][item]['brandDisp']
    sub_category_id = SUB_CATEGROY
    pricelist = get_product_price(_data_set['data'][item]['sku'])
    price_befor = pricelist['price_befor']
    price_after = pricelist['price_after']
    discount = pricelist['discount']
    description = ''
    url = _data_set['data'][item]['url']
    title = _data_set['data'][item]['brandDisp'] + ' - ' + _data_set['data'][item]['productName']
    actual_product_cost = float(Price_Calculations.calc_actual_product_cost(price_after,RATE))
    shipping_cost = Price_Calculations.calc_weight_cost(SHIPPING_COST_UNIT,SHIPPING_COST)
    profit = Price_Calculations.calc_Profit(group_schema,dict_profit_group_profit,price_after,RATE)
    sellng_price = Price_Calculations.calc_selling_price(actual_product_cost,shipping_cost,profit)
    shop = SHOP
    image = ''
    
    products_list.append({
        "product_refferernce" : product_refferernce, "brand": brand, "sub_category_id":sub_category_id, 
        "price_befor":price_befor, "price_after":price_after, "discount":discount, "description":description, 
        "url":url, "title":title, "actual_product_cost":actual_product_cost, "shipping_cost":shipping_cost, 
        "profit":profit, "sellng_price":sellng_price, "shop":shop
    })

for i in range(len(products_list)):
    print(products_list[i])
