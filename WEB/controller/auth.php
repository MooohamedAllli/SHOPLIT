<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$name = $_POST['name'];
		$pass = $_POST['pass'];
		
        $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
        $stat = $pdo->query("SELECT * FROM users where user_name = '".$name."'");
        $users = $stat->fetchAll();


        if($users[0]['user_name'] == $name && $users[0]['password'] == $pass ){
            if($users[0]['role'] == 'admin'){
                header("location: ../admin-home.php");
            }
            else if($users[0]['role'] == 'user')
                header("location: ../products.php");
            else{
                header("location: ../login.php");
                $_SESSION['message'] = "Error in username or password";
    
            }
        }
        else{
            header("location: ../login.php");
            $_SESSION['message'] = "Error in username or password";

        }
    }

?>
