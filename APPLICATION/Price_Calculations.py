import math

def define_product_price_group(schema,price):
    if price >= schema[0][1] and price < schema[1][1]:
        group = 1
    elif price >= schema[1][1] and price < schema[2][1]:
        group = 2
    else:
        group = 3
    return group

def calc_actual_product_cost(price_after,rate):
    price_after_rate = math.ceil((price_after + 2)) * math.ceil((rate + 2))
    percentage = math.ceil(price_after_rate * 0.03)
    return math.ceil(price_after_rate + percentage) 

def calc_weight_cost(sub_cat_weight, shipping_cost):
    return math.ceil(sub_cat_weight * shipping_cost)

def calc_Profit(group_schema,dict_profit_group_profit,price,rate):
    profit_perc = dict_profit_group_profit[define_product_price_group(group_schema,price)]
    actual_product_cost = calc_actual_product_cost(price,rate)
    profit =  actual_product_cost * (profit_perc/100)
    return math.ceil(profit)

def calc_selling_price(x,y,z):
    total = x + y + z
    return math.ceil(total/10) * 10

