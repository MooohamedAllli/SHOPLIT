<?php

//default variable for insertion
$order_id = date('ymdhis');
$order_date = date('Y-m-d h:i:s');
$order_status = 'Booked';
$order_cost = 0.0;

if (!empty($_POST)){

    // intite object hold order table data
    $object = array();
    $data = array();

    foreach($_POST AS $d)
        array_push($data,$d);
    
    // create object hold order table data
    $arr_len = (count($data)-4)/6;
    for($i=0 ; $i< $arr_len; $i++){
        $access = 6 * $i;
        $object[$i]['product_id'] = $data[$access];
        $object[$i]['Shop'] = $data[$access+1];
        $object[$i]['Price'] = $data[$access+2];
        $object[$i]['Name'] = $data[$access+3];
        $object[$i]['URL'] = $data[$access+4];
        $object[$i]['Quantity'] = $data[$access+5];
    }

    //create object for customer info
    $cus_Addr = ($data[count($data)-1]);
    $cus_name = ($data[count($data)-4]);
    $cus_phon = ($data[count($data)-3]);
    $cus_mail = ($data[count($data)-2]);

    //calculate order cost
    foreach ($object as $obj)
        $order_cost += $obj['Price'] * $obj['Quantity'];
    
    
    //open data base connection for insertion start;
    $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');

    //insert order products details
    foreach ($object as $obj)
        $stmt = $pdo->exec("INSERT INTO orders_products (order_id,product_id,Shop,Price,name,url,Quantity) 
        VALUES ('".$order_id."','".$obj['product_id']."','".$obj['Shop']."','".$obj['Price']."','".$obj['Name']."','".$obj['URL']."','".$obj['Quantity']."')");
    
    //insert order details    
        $stmt = $pdo->exec("INSERT INTO orders (id, customer_phone, customer_name, customer_mail, customer_add, order_cost, order_date,status) VALUES 
        ('".$order_id."','".$cus_phon."','".$cus_name."','".$cus_mail."','".$cus_Addr."','".$order_cost."','".$order_date."','".$order_status."')");

    //Delete Bag    
        $stat = $pdo->exec("DELETE FROM orders_products_temp");

    header("location: ../products.php");
}
else{
    echo "Post data is empty. No value is passed from HTML to the server";
}

?>