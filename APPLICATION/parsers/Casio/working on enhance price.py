import json
import requests


def get_product_price(sku):
    url = "https://www.casio.com/content/casio/locales/us/en/products/watches/jcr:content/root/responsivegrid/container/product_panel_list_f.products.json"
    _response = requests.get(url)
    _data_set = json.loads(_response.content)['data']

    SKUs = ''
    for i in range(0,len(_data_set)):
        SKU = '%22'+ _data_set[i]['sku']+'%22'
        SKUs =  SKUs + ',' + SKU
    SKUs = SKUs[1:len(SKUs)]

    headers = {
        'authority':'www.casio.com', 'method':'GET', 'accept': 'application/json', 'accept-encoding':'gzip, deflate, br',
        'accept-language': 'en-US,en;q=0.9', 'content-type':'application/json', 'store':'us_store_view',
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36 Edg/107.0.1418.56',
        'x-kl-ajax-request':'Ajax_Request',
    }
    url = 'https://www.casio.com/us/graphql?query={products(filter:+{sku:+{in:['+SKUs+']}},sort:{name:+ASC},pageSize:+820){items+{sku+casio_members_only_flg+casio_sales_type+stock_status+casio_can_purchase+casio_sales_start_date+casio_sales_end_date+casio_pre_order_start_date+casio_pre_order_end_date+casio_stock_alert+casio_catalog_price_rule_description+lottery_url+casio_dealer_product_search+casio_hide_bag_button+store_inventory_search+shop_inventory{shopcode+shopname+shopurl+status+quantity}price_range{minimum_price{regular_price{value+currency}final_price{value+currency}discount{amount_off+percent_off}}maximum_price{regular_price{value+currency}final_price{value+currency}discount{amount_off+percent_off}}}...+on+BundleProduct{items{option_id+option_type_id+options{id+price+is_default+product{sku+stock_status}}}}...+on+CustomizableProductInterface{options{option_id+title+required+sort_order...+on+CustomizableFieldOption{field_option:value{sku}}}}}}}'

    _response = requests.get(url, headers=headers , timeout=100)
    _data_set = json.loads(_response.content)['data']['products']['items']
    try:
        price_befor = _data_set[800]['price_range']['maximum_price']['regular_price']['value']
        price_after = _data_set[800]['price_range']['maximum_price']['final_price']['value']
        discount = _data_set[800]['price_range']['maximum_price']['discount']['percent_off']
    except:
        price_befor, price_after, discount = -1.0

    return({
        'price_befor':price_befor,
        'price_after':price_after,
        'discount':discount
    })
    return SKUs

print(get_product_price(2))
