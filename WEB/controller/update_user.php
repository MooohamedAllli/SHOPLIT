<?php

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $role = $_POST['Role'];
        $id = $_GET['id'];
        
        $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
        $stat = $pdo->exec("UPDATE Users SET role ='".$role."'where id = ".$id);

        header("location: ../settings.php");
    }
?>