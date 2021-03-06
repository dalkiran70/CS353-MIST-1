<?php
include("config.php");
session_start();
$flag = 0;
$min_p = 0;
$max_p = PHP_INT_MAX;

if (isset($_POST['no_filter'])) {
    $flag = 0;
}
if (isset($_POST['dewn_dcs'])) {
    $flag = 1;
}
if (isset($_POST['dewn_arc'])) {
    $flag = 2;
}
if (isset($_POST['price_arc'])) {
    $flag = 4;
}
if (isset($_POST['price_desc'])) {
    $flag = 3;
}
if (isset($_POST['top_5'])) {
    $flag = 5;
}
if (isset($_POST['min_p'] )) {
    $min_p = trim($_POST["min_p"]);
    $flag = 6;

}
if (isset($_POST['max_p'] )) {
    $max_p = trim($_POST["max_p"]);
    $flag = 6;
}
if(isset($_POST['search-val']) ){

    $search_val = trim($_POST["search-val"]);
    echo "<script LANGUAGE='JavaScript'>
    window.location.href = 'searchgames.php?searchVal=". $search_val ."';
</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIST - Sign Up</title>
    <link rel="stylesheet" type="text/css" id="applicationStylesheet" href="../Assets/css/index.css" />
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script id="applicationScript" type="text/javascript" src="index.js"></script>
</head>

<body>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" style="font-weight: bold; font-size: xx-large; font-family: Avenir">MIST</a>
            <div class="navbar-nav">
                <?php
                if ($_SESSION['type'] === "user") {
                    echo "<a href='userhome.php' class='nav-item nav-link'>Home</a>";
                } else {
                    echo "<a href='curatorhome.php' class='nav-item nav-link'>Home</a>";
                }
                ?>
                <a class="nav-item nav-link active">Store</a>
                <a href="library.php" class="nav-item nav-link">Library</a>
                <a href="modes.php" class="nav-item nav-link">Modes</a>
                <a href="friends.php" class="nav-item nav-link">Friends</a>
            </div>
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link" href="logout.php">Logout</a>
            </div>
        </nav>
        <div class="main-div"
            style=" padding-left: 2%; padding-right: 2%; padding-top: 2%; padding-bottom: 1%">
            <div style="font-family: Avenir; font-size: 48px;">Store</div>

                <hr>
            <div style="display: table-cell; vertical-align: middle; 
                     border-radius: 20px; 
                    border-color: rgba(112,112,112,1);
                     border-width: 2px;
                     margin-right: 100px;
                     margin-left: 100px;
                     text-align: center;">
                 <div class="search-value">
                     <form id="search-form" method="post">
                         <div style="display: flex">
                             <div class="input-group" style="margin-top: 20px; margin-left: 1000px; margin-right: 30px; text-align: center">
                                 <input id="search-val" type="text" class="form-control" name="search-val" placeholder="Search Game By Name" style=" outline: none; font-size: 20px; border-radius: 20px">
                             </div>
                             <div class="form-group" style="margin-top: 20px; margin-right: 30px; text-align: center">
                             <input onclick="checkEmptyAndSearch()" type="button" class="btn btn-primary btn-lg" style="background-color: gray; font-size: 20px; border-color: gray; border-radius: 20px" value="    Search    ">
                         </div>
                        </div>
                    </form>
                </div>
            </div>
        <div class="main-div" style="display: flex; padding-left: 2%; padding-right: 2%; padding-top: 2%; padding-bottom: 1%">
            <div class="information-header" style="width: 100%">
                
                <div style="width: 100%; display: flex;">
                    <div style=" width: 420px; text-align: right; margin-top: 0.1px">
                        <?php
                        echo "<form method='post'>";
                        echo "<input type='submit' name='no_filter' onclick='' class='btn btn-primary btn-lg' 
             style='font-family: Avenir; margin-top: 10px;
              width: 100%; 
              background-color: rgb(0,206,209); 
              border-color: rgb(0,206,209); 
              border-radius: 20px' value='No Filter'>";
                        echo "</form>";
                        echo "<form method='post'>";
                        echo "<input type='submit' name='dewn_dcs' onclick='' class='btn btn-primary btn-lg' 
             style='margin-top: 10px;font-family: Avenir; margin-top: 10px;
              width: 100%; 
              background-color: rgb(0,206,209); 
              border-color: rgb(0,206,209); 
              border-radius: 20px' value='Download Descending'>";
                        echo "</form>";
                        ?>
                    </div>
                    <div style=" width: 420px; text-align: right; margin-top: 0.1px; margin-left: 10px">
                        <?php
                        echo "<form method='post'>";
                        echo "<input type='submit' name='dewn_arc' onclick='' class='btn btn-primary btn-lg' 
             style='font-family: Avenir; margin-top: 10px;
              width: 100%; 
              background-color: rgb(0,206,209); 
              border-color: rgb(0,206,209);
              border-radius: 20px' value='Download Ascending'>";
                        echo "</form>";
                        echo "<form method='post'>";
                        echo "<input type='submit' name='price_desc' onclick='' class='btn btn-primary btn-lg' 
             style='margin-top: 10px;font-family: Avenir; margin-top: 10px;
              width: 100%; 
              background-color: rgb(0,206,209); 
              border-color: rgb(0,206,209);
              border-radius: 20px' value='Price Descending'>";
                        echo "</form>";
                        ?>
                    </div>
                    <div style=" width: 420px; text-align: right; margin-top: 0.1px; margin-left: 10px">
                        <?php
                        echo "<form method='post'>";
                        echo "<input type='submit' name='price_arc' onclick='' class='btn btn-primary btn-lg' 
             style='font-family: Avenir; margin-top: 10px;
              width: 100%; 
              background-color: rgb(0,206,209); 
              border-color: rgb(0,206,209);
              border-radius: 20px' value='Price Ascending'>";
                        echo "</form>";
                        echo "<form method='post'>";
                        echo "<input type='submit' name='top_5' onclick='' class='btn btn-primary btn-lg' 
             style='margin-top: 10px;font-family: Avenir; margin-top: 10px;
              width: 100%; 
              background-color: rgb(0,206,209); 
              border-color: rgb(0,206,209);
              border-radius: 20px' value='Top 5 (By Rate)'>";
                        echo "</form>";
                        ?>
                    </div>
                    <div style=" width: 420px; text-align: right; margin-top: 0.1px; margin-left: 10px">
                        <?php
                        echo "<form id='create-price-form' method='post'>
                        <div class='input-group' >
                        <div style= 'display: flex '>
                        <input id='min_p' type='number' class='form-control' name='min_p' placeholder='Min Price' style='  margin-right: 10px;outline: none; font-size: 20px; border-style: solid; border-radius: 20px'>
                        <input id='max_p' type='number' class='form-control' name='max_p' placeholder='Max Price' style='  margin-right: 10px;outline: none; font-size: 20px; border-style: solid; border-radius: 20px'>
                    
                        </div>
                       </div>
                <div class='form-group' style='text-align: left; margin-top: 10px'>
                    <input onclick='checkEmptyAndCreatePrice()' type='button' class='btn btn-primary btn-lg' style='background-color: rgb(86, 188, 22); border-color: rgb(86, 188, 22); border-radius: 20px' value='     By Price Range     '>
                </div>
            </form>
                        
                        ";
                       
                        ?>
                    </div>
                </div>


                <div style="font-family: Avenir; font-size: 32px; margin-bottom:10px">Subscription Packages</div>
                <div class="sub-package">
                    <div style=" overflow-x: scroll; white-space: nowrap;">
                        <?php

                        if ($flag == 0) {
                            $packages_query = "SELECT * FROM Subscription_Package;";
                            
                        }
                        else if($flag == 1){
                            $packages_query = "SELECT *, COUNT(*) as count_pack FROM Subscription_Package sp, subscribes s  WHERE s.package_ID = sp.package_ID GROUP BY s.package_ID ORDER BY count_pack DESC ;";
                        
                        }
                        else if($flag == 2){
                            $packages_query = "SELECT *, COUNT(*) as count_pack FROM Subscription_Package sp, subscribes s  WHERE s.package_ID = sp.package_ID GROUP BY s.package_ID ORDER BY count_pack ASC ;";
                        }
                        else if($flag == 3){
                            $packages_query = "SELECT * FROM Subscription_Package sp ORDER BY price DESC ;";

                            
                        }
                        else if($flag == 4){
                            $packages_query = "SELECT * FROM Subscription_Package sp ORDER BY price ASC ;";

                            
                        }
                        else if($flag == 5){
                            $packages_query = "SELECT * FROM Subscription_Package;";

                            
                        }
                        else if($flag == 6){
                            $packages_query = "SELECT * FROM Subscription_Package sp WHERE sp.price <= ".$max_p." AND sp.price >= ".$min_p." ORDER BY sp.price DESC ;";

                            
                        }
                        $packages_query_result = mysqli_query($db, $packages_query);
                        if (!$packages_query_result) {
                            printf("Error: %s\n", mysqli_error($db));
                            exit();
                        }
                        if (mysqli_num_rows($packages_query_result) > 0) {
                            while ($packages_row = mysqli_fetch_assoc($packages_query_result)) {
                                $package_id = $packages_row['package_ID'];
                                $package_name = $packages_row['package_name'];
                                $package_price = $packages_row['price'];

                                echo "<a href='subscriptionpackage.php?package_id=" . $package_id . "'>
                                <div style='display: inline-block; float:none; position: relative'>
                                    <img src='../Assets/images/package.jpeg'/>
                                    <h3 style='font-weight: lighter; font-family: Avenir; font-size: 24px; color: white ; padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; position: absolute; background-color: rgb(90,90,90); border-style: solid; border-radius: 30px; border-color: rgb(90,90,90); bottom: 8px; left: 16px;'>" . $package_name . "</h3>
                                    <h3 style='font-weight: lighter; font-family: Avenir; font-size: 24px; color: white ; padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; position: absolute; bottom: 8px; right: 16px; background-color: rgb(90,90,90); border-style: solid; border-radius: 30px; border-color: rgb(90,90,90);'>" . $package_price . "TL</h3>
                                </div>
                            </a>";
                            }
                        } else {
                            echo "no results";
                        }
                        ?>

                    </div>
                </div>
                <div style="font-family: Avenir; font-size: 32px; margin-top: 30px; margin-bottom: 10px">Games</div>
                <div class="games-display">
                    <div style=" overflow-x: scroll; white-space: nowrap;">
                        <?php
                        if ($flag == 0) {
                        $games_query = "SELECT * FROM Published_Games vg;";
                        
                        }
                        else if ($flag == 1) {
                            $games_query = "SELECT *, COUNT(*) as count_game FROM Published_Games vg, install i  WHERE i.g_ID = vg.g_ID GROUP BY i.g_ID ORDER BY count_game DESC ;";
                            
                        }
                        else if($flag == 2){
                            $games_query = "SELECT *, COUNT(*) as count_game FROM Published_Games vg, install i  WHERE i.g_ID = vg.g_ID GROUP BY i.g_ID ORDER BY count_game ASC ;";


                        }
                        else if($flag == 3){

                            $games_query = "SELECT * FROM Published_Games  ORDER BY g_price DESC;";

                        }
                        else if($flag == 4){
                            $games_query = "SELECT * FROM Published_Games  ORDER BY g_price ASC;";
                            
                        }
                        else if($flag == 5){
                            $games_query = "SELECT *, SUM(r.value)/5 as count_game FROM Published_Games vg, rates r  WHERE r.g_ID = vg.g_ID GROUP BY r.g_ID ORDER BY count_game DESC Limit 5 ;";
                            
                        }
                        else if($flag == 6){
                            $games_query = "SELECT * FROM Published_Games vg WHERE vg.g_price <= ".$max_p." AND vg.g_price >= ".$min_p." ORDER BY vg.g_price DESC ;";

                        }
                        $games_query_result = mysqli_query($db, $games_query);
                        if (!$games_query_result) {
                            printf("Error: %s\n", mysqli_error($db));
                            exit();
                        }
                        if (mysqli_num_rows($games_query_result) > 0) {
                            while ($games_row = mysqli_fetch_assoc($games_query_result)) {
                                $game_id = $games_row['g_ID'];
                                $game_name = $games_row['g_name'];
                                $game_price = $games_row['g_price'];
                                echo $g_ID;
                                echo "<a href='videogame.php?game_id=" . $game_id . "'>
                                <div style='display: inline-block; float:none; position: relative'>
                                    <img src='../Assets/images/package.jpeg'/>
                                    <h3 style='font-weight: lighter; font-family: Avenir; font-size: 24px; color: white ; padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; position: absolute; background-color: rgb(90,90,90); border-style: solid; border-radius: 30px; border-color: rgb(90,90,90); bottom: 8px; left: 16px;'>" . $game_name . "</h3>
                                    <h3 style='font-weight: lighter; font-family: Avenir; font-size: 24px; color: white ; padding-left: 20px; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; position: absolute; bottom: 8px; right: 16px; background-color: rgb(90,90,90); border-style: solid; border-radius: 30px; border-color: rgb(90,90,90);'>" . $game_price . "TL</h3>
                                </div>
                            </a>";
                            }
                        } else {
                            echo "no results";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div style="
                width: 100%;
                text-align: center;
                font-size: 20px;
                color: rgba(112,112,112,1);">
            <p>A Game Distribution Service by Pluto++</p>
        </div>
    </div>
    <script type="text/javascript">
        function checkEmptyAndLogin() {
            let fullNameVal = document.getElementById("full-name").value;
            let nickNameVal = document.getElementById("nick-name").value;
            let emailVal = document.getElementById("email").value;
            let passwordVal = document.getElementById("password").value;
            let phoneNumberVal = document.getElementById("phone-number").value;
            if (fullNameVal === "" || passwordVal === "" || nickNameVal === "" || emailVal === "" | phoneNumberVal === "") {
                alert("Make sure to fill all fields!");
            } else {
                let form = document.getElementById("login-form").submit();
            }
        }
        function checkEmptyAndCreatePrice() {
                let min_pi = document.getElementById("min_p").value;
                let max_pi = document.getElementById("max_p").value;

                if (min_pi ==="" || max_pi ===""  ) {
                    alert("Make sure to fill all fields!");
                } 

                else if(min_pi > max_pi ){
                    alert("Minimum price cannot be greater than maximum price!");

                }
                else if(min_pi <= max_pi){
                    let form = document.getElementById("create-price-form").submit();
                }
                
            }
    </script>
    <script type="text/javascript">
    function checkEmptyAndSearch() {
        let searchVal = document.getElementById("search-val").value;
        if (searchVal === "" ) {
            alert("Make sure to fill the search field!");
        } else {
            let form = document.getElementById("search-form").submit();      
        }
    }
    </script>
</body>

</html>