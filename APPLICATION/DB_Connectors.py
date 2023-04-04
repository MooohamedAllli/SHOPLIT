import sqlite3

def get_rate_and_cost():
    try:
        sqliteConnection = sqlite3.connect('DB/SHOPLIT.db')
        cursor = sqliteConnection.cursor()

        sqlite_select_Query = "SELECT * FROM cost"
        cursor.execute(sqlite_select_Query)
        record = cursor.fetchall()
        cursor.close()
        return ({
            'rate':record[0][1],
            'cost':record[0][2]
        })
        
    except sqlite3.Error as error:
        print("Error while connecting to sqlite cost", error)
        return error


def get_unit_weight_cost(sub_category):
    try:
        sqliteConnection = sqlite3.connect('DB/SHOPLIT.db')
        cursor = sqliteConnection.cursor()

        sqlite_select_Query = f"SELECT weight_unit FROM sub_category WHERE id = {sub_category}"
        cursor.execute(sqlite_select_Query)
        record = cursor.fetchall()
        cursor.close()
        return record[0][0]

    except sqlite3.Error as error:
        print("Error while connecting to sqlite sub_category", error)

def get_profit_schema():
    try:
        sqliteConnection = sqlite3.connect('DB/SHOPLIT.db')
        cursor = sqliteConnection.cursor()

        sqlite_select_Query = "SELECT * FROM profit_schem "
        cursor.execute(sqlite_select_Query)
        record = cursor.fetchall()
        cursor.close()
        return record

    except sqlite3.Error as error:
        print("Error while connecting to sqlite sub_category", error)

def generate_price_group_profit():
    try:
        sqliteConnection = sqlite3.connect('DB/SHOPLIT.db')
        cursor = sqliteConnection.cursor()

        sqlite_select_Query = "SELECT * FROM profit_schem "
        cursor.execute(sqlite_select_Query)
        record = cursor.fetchall()
        cursor.close()
        return ({
            1 : record[0][3],
            2 : record[1][3],
            3 : record[2][3]
        })

    except sqlite3.Error as error:
        print("Error while connecting to sqlite sub_category", error)

def insert_data(item):
    sqliteConnection = sqlite3.connect('DB/SHOPLIT.db', timeout=10)
    cursor = sqliteConnection.cursor()

    insert_qry = f"INSERT INTO products (product_refferernce, brand, sub_category_id, price_befor, price_after, discount, description, url, title, actual_product_cost, shipping_cost, profit, selling_price, shop, image) \
    VALUES ('{item['product_refferernce']}','{item['brand']}','{item['sub_category_id']}',\
        '{item['price_befor']}','{item['price_after']}','{item['discount']}',\
        '{item['description']}','{item['url']}','{item['title']}',\
        '{item['actual_product_cost']}','{item['shipping_cost']}','{item['profit']}',\
        '{item['sellng_price']}','{item['shop']}','{item['image']}')"


    cursor.execute(insert_qry)
    sqliteConnection.commit()
    print("Done")
