from parsel import Selector
import requests
import sys, os
sys.path.append(os.getcwd()+'/APPLICATION')
import DB_Connectors
import Price_Calculations
import json


#GLOBAL VARIABLES
SHOP = 'Coach'
SUB_CATEGROY = '101'

# #INTIAL VARIABES FOR PRICE CALCULATION
RATE = DB_Connectors.get_rate_and_cost()['rate']
SHIPPING_COST = DB_Connectors.get_rate_and_cost()['cost']
dict_profit_group_profit = DB_Connectors.generate_price_group_profit()
group_schema = DB_Connectors.get_profit_schema()


URL = "https://www.coachoutlet.com/api/get-shop/bags/shoulder-bags-hobos?page=1"

def get_image(URL):
    text = requests.get(URL)
    sel = Selector(text=text.text)
    return sel.xpath('//img[@class="chakra-image css-119q2e7"]/@src').get()

def get_page_details(URL):
    text = requests.get(URL)
    text_data = json.loads(text.text)
    return text_data['pageData']['total'], text_data['pageData']['totalPages']

def couach(URL,SUB_CATEGROY):
    SHIPPING_COST_UNIT = DB_Connectors.get_unit_weight_cost(SUB_CATEGROY)
    products = []
    products_list = []

    for i in range(1,get_page_details(URL)[1]+1):
        URL = f"{URL[:-1]}{i}"
        text = requests.get(URL)    
        text_data = json.loads(text.text)
        products.append(text_data['pageData']['products'])

    for i in range(0,len(products)):
        for j in products[i]:
            product_refferernce = j['id']
            brand = SHOP
            sub_category_id = SUB_CATEGROY
            try:
                price_befor = j['prices']['regularPrice']
            except:
                price_befor = -1
            try:
                price_after = j['prices']['currentPrice']
            except:
                price_after = -1
            try:
                discount = j['prices']['discount']
            except:
                discount = -1
            description = ''
            url = 'https://www.coachoutlet.com' + j['url']
            title = j['name']
            actual_product_cost = float(Price_Calculations.calc_actual_product_cost(price_after,RATE))
            shipping_cost = Price_Calculations.calc_weight_cost(SHIPPING_COST_UNIT,SHIPPING_COST)
            profit = Price_Calculations.calc_Profit(group_schema,dict_profit_group_profit,price_after,RATE)
            sellng_price = Price_Calculations.calc_selling_price(actual_product_cost,shipping_cost,profit)
            shop = SHOP
            image = get_image(url)

            products_list.append({
                "product_refferernce" : product_refferernce, "brand": brand, "sub_category_id":sub_category_id, 
                "price_befor":price_befor, "price_after":price_after, "discount":discount, "description":description, 
                "url":url, "title":title, "actual_product_cost":actual_product_cost, "shipping_cost":shipping_cost, 
                "profit":profit, "sellng_price":sellng_price, "shop":shop, "image":image
            })
    
    return products_list

prods = couach(URL,101)

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
