import sys, os
sys.path.append(os.getcwd()+'/APPLICATION')
from parsel import Selector
from selenium import webdriver
import DB_Connectors
import Price_Calculations


#GLOBAL VARIABLES
SHOP = 'GUESS'


# #INTIAL VARIABES FOR PRICE CALCULATION
RATE = DB_Connectors.get_rate_and_cost()['rate']
SHIPPING_COST = DB_Connectors.get_rate_and_cost()['cost']
dict_profit_group_profit = DB_Connectors.generate_price_group_profit()
group_schema = DB_Connectors.get_profit_schema()


def get_page_size(URL):
    dr = webdriver.Edge()
    dr.get(URL)
    sel = Selector(text=dr.page_source)
    return int (sel.xpath("//span[@class='refinements__trigger-results-count']/text()").get().split(" ")[0].replace('(',''))


def guess_parser(URL, SUB_CATEGROY, test=''):
    
    SHIPPING_COST_UNIT = DB_Connectors.get_unit_weight_cost(SUB_CATEGROY)

    _page_size = get_page_size(URL)
    
    _update_url = URL + '?start=0&sz=' + str(_page_size)
    dr = webdriver.Edge()
    dr.get(_update_url)
    sel = Selector(text=dr.page_source)
    products = sel.xpath("//div[@class='row product-grid ']/div[@class='product-grid__column']")

    products_list = []
    for item in products:
        product_refferernce = item.xpath('div[@class="product"]/@data-pid').get()
        brand = 'Guess'
        sub_category_id = SUB_CATEGROY
        try:
            price_after = float(item.xpath('div[@class="product"]/@data-price').get().strip())
        except:
            price_after = -1.0
        try:
            price_befor = float(item.xpath('div[@class="product"]/div[@class="product-tile js-gtm-list"]/div[@class="product-tile__tile-body"]/a/div[@class="price"] \
        /span[@class="starting"]/span[@class="price__strike-through"]/text()').get().split('$')[1].strip())
        except:
            price_befor = price_after
        discount = ((price_befor - price_after) / price_befor)*100
        title = item.xpath('div[@class="product"]/div[@class="product-tile js-gtm-list"]/div[@class="product-tile__tile-body"]/h3/a/text()').get().strip()
        url = item.xpath('div[@class="product"]/div[@class="product-tile js-gtm-list"]/div[@class="product-tile__tile-body"]/h3/a/@href').get().strip()
        description = ''
        actual_product_cost = float(Price_Calculations.calc_actual_product_cost(price_after,RATE))
        shipping_cost = Price_Calculations.calc_weight_cost(SHIPPING_COST_UNIT,SHIPPING_COST)
        profit = Price_Calculations.calc_Profit(group_schema,dict_profit_group_profit,price_after,RATE)
        sellng_price = Price_Calculations.calc_selling_price(actual_product_cost,shipping_cost,profit)
        shop = SHOP

        if test in title:
            products_list.append({
                "product_refferernce" : product_refferernce, "brand": brand, "sub_category_id":sub_category_id, 
                "price_befor":price_befor, "price_after":price_after, 
                "discount":round(discount), "description":description, 
                "url":url, "title":title, "actual_product_cost":actual_product_cost, "shipping_cost":shipping_cost, 
                "profit":profit, "sellng_price":sellng_price, "shop":shop
            })

    return products_list
