<?php
    $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
    $stat = $pdo->query("SELECT * FROM users");
    $users = $stat->fetchAll();

    $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
    $stat = $pdo->query("SELECT * FROM cost ");
    $cost = $stat->fetchAll();

    $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
    $stat = $pdo->query("SELECT * FROM price_category_limites ");
    $limits = $stat->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin-Settings</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/settings.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script>
        function myalert() {
            alert("Confirm delete item data ?");
        }
    </script>

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

    <div class="SettingCard">
        <div class="SettingTitle">
            <h6>Update Users</h6>
        </div>
        <div class="SettingBox">
                <table class="table table-borderless">
                    <th>Username</th>
                    <th>Role</th>
                    <th>New Role</th>
                    <th>Action</th>
                    <th></th>
                    <?php foreach($users as $user){?>
                    <tr>
                        <td><?php echo $user['user_name'];?></td>
                        <td><?php echo $user['role'];?></td>
                        <form action="controller/update_user.php?id=<?php echo $user['id'];?>" method="POST">
                            <td>
                                <select name="Role" id="Role" style="border: none; padding: 5px; width: 100px;">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </td>
                            <td>
                                <input type="submit" value="Update" style="background-color: rgb(24, 130, 145);">
                            </td>
                        </form>
                        <td>
                            <form action="controller/delete_user.php?id=<?php echo $user['id'];?>" method="POST" onclick="myalert()">
                                <input type="submit" value="Delete" style="background-color: brown;">
                            </form>
                        </td>
                    </tr>
                    <?php }?>
                </table>
                <form action="controller/add_user.php" method="POST">
                    <div class="form-data" style="padding:10px">
                        <label style="font-weight:bold;"> New user data: </label><br>
                        <input type="text" name="name" placeholder="Username">
                        <input type="text" name="pass" placeholder="password">
                        <select name="Role" style="border: none; padding: 5px; width: 100px;">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <input type="submit" value="Add New User">
                </form>
        </div>
    </div>

    <div class="SettingCard">
        <div class="SettingTitle">
            <h6>Update Shipping Cost</h6>
        </div>
        <div class="SettingBox">
            <form action="controller/update_cost.php" method="post">
                <table class="table table-borderless">
                    <th>Shipping Cost</th>
                    <th>New Value</th>
                    <tr>
                        <td><?php echo ($cost[0]['shipping_cost']) ;?></td>
                        <td><input type="text" placeholder="New Value..." name = 'shipping_cost'></td>
                    </tr>
                </table>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>

    <div class="SettingCard">
        <div class="SettingTitle">
            <h6>Update $ price</h6>
        </div>
        <div class="SettingBox">
            <form action="controller/update_rate.php" method="post">
                <table class="table table-borderless">
                    <th>rate price $</th>
                    <th>New Value</th>
                    <tr>
                        <td><?php echo ($cost[0]['usd_rate']) ;?></td>
                        <td><input type="text" placeholder="New Value..." name = 'rate'></td>
                    </tr>
                </table>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>

    <div class="SettingCard">
        <div class="SettingTitle">
            <h6>Update Category Limites</h6>
        </div>
        <div class="SettingBox">
            <table class="table table-borderless">
                <th>Category</th>
                <th>Price Limit</th>
                <th>New Value</th>
                <th>Action</th>
                <?php foreach($limits as $limit){ ?>
                    <tr>
                        <td><?php echo $limit['category'];?></td>
                        <td><?php echo $limit['Max Price'].' $';?></td>
                        <form action="controller/update_limit.php?id=<?php echo $limit['category'];?>" method="POST">
                            <td>
                                <input type="text" placeholder="New Values..." name='limit'>
                            </td>
                            <td>
                                <input type="submit" value="Update" style="background-color: rgb(24, 130, 145);">
                            </td>
                        </form>
                    </tr>
                <?php }?>
            </table>
            <input type="submit" value="Add New Limit">
        </div>        
    </div>

    <div class="SettingCard">
        <div class="SettingTitle">
            <h6>Update Profit Schema</h6>
        </div>

        <div class="SettingBox">
            <form action="#">
                <table class="table table-borderless">
                    <th>Price Range Group ($)</th>
                    <th>Profit</th>
                    <th>New Value</th>
                    <tr>
                        <td>0 - 25</td>
                        <td>25%</td>
                        <td><input type="text" placeholder="New Values..."></td>
                    </tr>
                    <tr>
                        <td>25 - 50</td>
                        <td>20%</td>
                        <td><input type="text" placeholder="New Values..."></td>
                    </tr>
                    <tr>
                        <td>> 50</td>
                        <td>15%</td>
                        <td><input type="text" placeholder="New Values..."></td>
                    </tr>
                </table>
                <input type="submit" value="Update">
            </form>
        </div>

        
    </body>
<html>


