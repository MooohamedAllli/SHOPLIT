<?php

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $category = $_GET['id'];
        $limit = $_POST['limit'];
        $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
        $stat = $pdo->exec("UPDATE price_category_limites SET [Max Price] = ".$limit." WHERE category='".$category."'");

        header("location: ../settings.php");
    }
?>
