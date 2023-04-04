<?php


$URL_REF = $_SERVER['HTTP_REFERER'];

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $id = $_GET['id'];


        $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
        $data = $pdo->exec("INSERT INTO orders_products_temp (product_id) VALUES (".$id.")");

        header("location: ".$URL_REF);
    }
?>