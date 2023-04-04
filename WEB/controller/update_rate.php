<?php

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $cost = $_POST['rate'];

        $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
        $stat = $pdo->exec("UPDATE cost SET usd_rate = ".$cost);

        header("location: ../settings.php");
    }
?>