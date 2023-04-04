import sys, os
sys.path.append(os.getcwd()+'/APPLICATION')
from parsel import Selector
import requests
import DB_Connectors
import Price_Calculations


#GLOBAL VARIABLES
SUB_CATEGROY = 102
SHOP = 'OliviaBurton'

#INTIAL VARIABES FR PRICE CALCULATION
RATE = DB_Connectors.get_rate_and_cost()['rate']
SHIPPING_COST = DB_Connectors.get_rate_and_cost()['cost']
SHIPPING_COST_UNIT = DB_Connectors.get_unit_weight_cost(SUB_CATEGROY)
dict_profit_group_profit = DB_Connectors.generate_price_group_profit()
group_schema = DB_Connectors.get_profit_schema()

def get_page_size():
    url = "https://us.oliviaburton.com/on/demandware.store/Sites-OliviaBurtonUS-Site/en_US/Search-UpdateGrid?cgid=shop-all-watches&start=0&sz=1"
    _response = requests.get(url)
    _data_set = _response.text
    sel = Selector(text=_data_set)
    return sel.xpath("//p[@id='show-more-update-mobile']/@data-total-size").get()

_page_size = get_page_size()

def oliviaburton_parser():
    url = 'https://us.oliviaburton.com/on/demandware.store/Sites-OliviaBurtonUS-Site/en_US/Search-UpdateGrid?cgid=shop-all-watches&start=0&sz='+str(_page_size)+''
    _response = requests.get(url)
    sel = Selector(text=_response.text)
    products = sel.xpath('//div[@class="col-6 col-sm-4 col-lg-3 custom-col"]')

    products_list = []
    for item in products:
        product_refferernce = item.xpath('div[@class="product"]/@data-pid').get()
        brand = 'OliviaBurton'
        sub_category_id = SUB_CATEGROY
        try:
            price_befor = float(item.xpath('div[@class="product"]/div/div[@class="tile-body"]/div[@class="pricing-save"]/div/span[@class="price-pdp-mvmt"]/span/span/@content').get())
        except:
            price_befor = -1.0
        price_after = price_befor
        discount = ((price_befor - price_after) / price_befor)*100
        title = item.xpath('div[@class="product"]/div/div[@class="tile-body"]/div[@class="pdp-link"]/a/text()').get()
        url = 'https://us.oliviaburton.com' + item.xpath('div[@class="product"]/div/div[@class="tile-body"]/div[@class="pdp-link"]/a/@href').get()
        description = ''
        actual_product_cost = float(Price_Calculations.calc_actual_product_cost(price_after,RATE))
        shipping_cost = Price_Calculations.calc_weight_cost(SHIPPING_COST_UNIT,SHIPPING_COST)
        profit = Price_Calculations.calc_Profit(group_schema,dict_profit_group_profit,price_after,RATE)
        sellng_price = Price_Calculations.calc_selling_price(actual_product_cost,shipping_cost,profit)
        shop = SHOP
        image = item.xpath('div[@class="product"]/div/div[@class="image-container"]/a/picture/img[@class="tile-image gtm-product"]/@src').get()

            
        products_list.append({
            "product_refferernce" : product_refferernce, "brand": brand, "sub_category_id":sub_category_id, 
            "price_befor":price_befor, "price_after":price_after, "discount":discount, "description":description, 
            "url":url, "title":title, "actual_product_cost":actual_product_cost, "shipping_cost":shipping_cost, 
            "profit":profit, "sellng_price":sellng_price, "shop":shop, "image":image
        })

    return products_list 

prods = oliviaburton_parser()

sucess =0 
failed = 0

for i in range(0,len(prods)):
    try:
        DB_Connectors.insert_data(prods[i])
        sucess = sucess + 1
    except:
        failed = failed + 1

print("sucess percentage: ",sucess )
print("failure percentage: ",failed )
