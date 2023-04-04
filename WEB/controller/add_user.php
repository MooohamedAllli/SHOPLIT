<?php

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        $role = $_POST['Role'];

        $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
        $stat = $pdo->exec("INSERT INTO Users (user_name,password,role) VALUES ('".$name."','".$pass."','".$role."')");

        header("location: ../settings.php");
    }
?>