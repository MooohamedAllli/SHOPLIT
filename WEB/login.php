<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <?php
        if(isset($_SESSION['message'])){
            echo "<h3'>".$_SESSION['message']."</h3>";
            unset($_SESSION['message']);
        }
    ?>
    <div class="MainBox">
        <div class="Logo-info">
            <div class="name">Welcome</div>
            <div class="photo" ><img src="img/logo.png" alt="Shoplit logo"></div>
        </div>
        <div class="form">
            <form action="controller/auth.php" method="POST">
                <input type="text" placeholder="Name" name="name">
                <input type="password" placeholder="Password" name="pass">
                <input type="submit" value="Login"> 
            </form>
        </div>
    </div>
</body>
</html>
