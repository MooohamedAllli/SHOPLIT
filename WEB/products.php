<?php
    include('constants.php');

    $queryStr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($queryStr, $queryParams);
    $shop = (isset($queryParams['shop'])) ? $queryParams['shop'] : 'all';
    $category = (isset($queryParams['catgeory'])) ? $queryParams['catgeory'] : 'all';
    $subcategory = (isset($queryParams['subcategory'])) ? $queryParams['subcategory'] : 'all';

    function Category(){
        $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
        $stat = $pdo->query("SELECT * FROM category ")->fetchAll();
        return $stat;
    }

    function subCategory($categoryName){

        if($categoryName != 'all'){
            $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
            $stat = $pdo->query("SELECT id FROM category WHERE description = '$categoryName'")->fetchAll()[0]['id'];
            $cats = $pdo->query("SELECT * FROM sub_category WHERE category_id = '".$stat."' ")->fetchAll();
    
            return $cats;
        }
    }

    $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
    $prods = $pdo->query("SELECT * FROM products")->fetchAll();

    $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
    $bagCount = $pdo->query("SELECT count(*) as bag_count FROM orders_products_temp")->fetchAll();

    $categories = Category();
    $cats = subCategory($category);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/products.css">


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

    <div class="ShopsHeader">
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=all">All</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=10">Casio</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=20">Olivia Burton</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=30">Guess</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=40">Coach</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=50">Calvin Klein</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=60">Polo</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=70">Michel Kors</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=80">Kate Spade</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=90">Tory Burch</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=100">Mango</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=110">Nine West</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=120">Macys</a></div>
        <div class="shop"><a href="<?= $BASE_URL;?>/products.php?shop=130">6pm</a></div>
    </div>

    <div class="Body">
        <div class="Menu">
            <div class="Category">
                <p style="color: #476e5f; font-weight: 700;">Category</p>
                <ul>
                    <?php
                    foreach ($categories as $categ){
                        echo '<a href="'.$BASE_URL.'/products.php?shop='.$shop.'&catgeory='.$categ['description'].'">'.$categ['description'].'</a><br>';
                        if($category==$categ['description']){
                            foreach($cats as $cat){
                                echo
                                '<ul id="subCategory">
                                <a href="'.$BASE_URL.'/products.php?shop='.$shop.'&catgeory='.$category.'&subcategory='.$cat['id'].'"><li>'.$cat['description'].'</li></a>
                                </ul>';
                            }    
                        }
                    }
                    ?>
            </div>
        </div>
        <div class="ProductsList">
            <div class="minHeader">
                <div class="searchBar">
                    <form action="search.php" method="POST" class="searchForm">
                        <input type="text" name="search" placeholder="search product...">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <div class="orderBar">
                    <a href="order-bag.php"><label>Bags Order (<?=$bagCount[0]['bag_count'];?>)</label></<a>
                    <img src="img/orders.png" style="width: 30px; height:30px;">
                </div>
            </div>
            <br>
            <div class="Products">
                <?php foreach($prods as $prod) {
                echo '<div class="Product">
                    <div class="image">
                        <img src="'.$prod['image'].'">
                    </div>
                    <div class="details">
                        <div class="id" style="font-weight:bold; font-size:10px">Product ID#'.$prod['product_id'].'</div>
                        <div class="title">'.$prod['title'].'</div>
                        <div class="price" style="font-weight:bold; text-align:center; font-size:12px">'.$prod['selling_price'].' EGP</div>
                    </div>
                    <div class="buttons" style="display: flex; justify-content: space-around;">
                        <form action="Show-prod.php?id='.$prod['product_id'].'" method="POST">
                            <input type="submit" value="Show">
                        </form>
                        <form action="controller/add_order.php?id='.$prod['product_id'].'" method="POST">
                            <input type="submit" value="Order">
                        </form>
                    </div>
                </div>';}
                ?>
            </div>
        </div>
        
    </div>
</body>
</html>
