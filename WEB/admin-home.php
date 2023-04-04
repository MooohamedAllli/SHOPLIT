<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin-Home</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="header">
        <div class="logout">
            <form action="login.php">
                <input type="submit" value="Logout">
            </form>
            <form action="admin-home.php">
                <input type="submit" value="Home">
            </form>
        </div>
        <div class="logo"><img src="img/logo.png" width="60px" height="60px"></div>
    </div>    
    <br>
    <br>
    <div class="admin-cards">
        <a href="#">
        <div class="card">
            <div class="image"><img src="img/load.webp" width="120px" height="120px"></div>
            <div class="title">Load Products</div>
        </div></a>
        <a href="products.php">
        <div class="card">
            <div class="image"><img src="img/prods.png" width="120px" height="120px"></div>
            <div class="title">View Products</div>
        </div></a>
        <a href="orders.php">
        <div class="card">
            <div class="image"><img src="img/ord.png" width="120px" height="120px"></div>
            <div class="title">View Orders</div>
        </div></a>
        <a href="settings.php">
        <div class="card">
            <div class="image"><img src="img/settings.png" width="120px" height="120px"></div>
            <div class="title">Settings</div>
        </div></a>
        <a href="#">
        <div class="card">
            <div class="image"><img src="img/stats.png" width="120px" height="120px"></div>
            <div class="title">Statics</div>
        </div></a>
    </div>
    

</body>
</html>
