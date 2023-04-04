<?php

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $id = $_GET['id'];
        echo $id;
        
        $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
        $stat = $pdo->exec("DELETE FROM Users WHERE id = ".$id);

        header("location: ../settings.php");
    }
?>