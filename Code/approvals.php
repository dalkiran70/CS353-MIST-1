<?php
    include("config.php");
    session_start();
    #//TODO: GAMESTE NASIL YAPTIYSA ÖYLE YAP
    if(empty($_SESSION['a_ID']) || $_SESSION['type'] !== "pub"){
        header("location: index.php");
        die("Redirecting to login.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1.0"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIST - Publisher</title>
    <link rel="stylesheet" type="text/css" id="applicationStylesheet" href="../Assets/css/index.css"/>
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
            <a href="publisherhome.php" class="nav-item nav-link">Home</a>
            <a class="nav-item nav-link active">Approvals</a>
            <a href="requests.php" class="nav-item nav-link">Requests</a>
        </div>
        <div  class="navbar-nav ml-auto">
            <a class="nav-item nav-link" href="logout.php">Logout</a>
        </div>
    </nav>
    <div style="font-family: Avenir; font-size: 48px; margin-bottom: 2%; margin-left: 2%; margin-top: 2%;">Approvals</div>
    <hr>
    <div class="main-div" style="width: 70%">
        <?php
            $query = "SELECT vg.g_name, vg.g_description, vg.g_image, vg.g_ID
                                                FROM about a, takes t, Video_Game vg, Request req
                                                WHERE t.state = 'Approved' AND vg.g_ID=a.g_ID
                                                             AND a.r_ID = req.r_ID AND t.r_ID = req.r_ID
                                                            AND t.a_ID=". $_SESSION['a_ID'] ." AND vg.g_ID NOT IN (SELECT p.g_ID FROM publish p);";

            $card_result = mysqli_query($db, $query);

            if (!$card_result) {
                printf("Error: %s\n", mysqli_error($db));
                exit();
            }
            if (mysqli_num_rows($card_result) > 0) {
                while ($cards_row = mysqli_fetch_assoc($card_result)) {
                    $game_name = $cards_row['g_name'];
                    $game_desc = $cards_row['g_description'];
                    $game_image = $cards_row['g_image'];
                    $g_ID = $cards_row['g_ID'];

                    echo "<div class='games-row2' style='display: flex; height: 300px; margin-top: 25px'>
                            <div class='game-image' style='width: 50%; height: 100%;
                                overflow: hidden;
                                text-align: center;
                                font-size: 30px;
                                margin-bottom: 10px;
                                border-style: solid;
                                border-color: rgba(112,112,112,1);
                                border-width: 2px;
                                margin-right: 100px;
                                margin-left: 100px;
                                border-radius: 20px;'>
                                <div style='width: 100%; height: 100%; position: relative; text-align: center'>
                            <img style=' height: 100%; width: 100%;' src='../Assets/images/game.jpg' alt=''>
                            </div>
                            </div>
                            <div class='game-description' style='display: table; overflow: hidden; width: 50%; height: 100%;'>
                                <div style='display: table-cell; vertical-align: middle; padding-left: 50px;'>
                                    <div>
                                        <span style='font-weight: bold'>Name: </span>
                                        <span>". $game_name ."</span>
                                    </div>
                                    <div>
                                        <span style='font-weight: bold'>Description: </span>
                                        <span>". $game_desc ."</span>
                                    </div>
                                    <br>
                                    <div>
                                        <a href='publishgame.php?g_ID=" . $g_ID . "'>
                                            <button type='button' class='btn btn-primary' class='btn btn-primary btn-lg' style='float:right; font-family: Avenir; width: 25%; background-color: rgba(93, 239, 132, 100); border-color: #ffffff; border-radius: 20px' data-toggle='modal' data-target='#exampleModalCenter3'>
                                                    Publish
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }
            }
            else {
                echo "        No recent approvals found, check the request tab!";
            }
        ?>
    </div>
    <div style="font-family: Avenir; font-size: 48px; margin-bottom: 2%; margin-left: 2%; margin-top: 2%;">Published</div>
    <hr>
    <div class="approved-div" style="width: 70%; margin-bottom: 10px;">
        <?php
            $query = "SELECT vg.g_name, vg.g_description, vg.g_image, p.date FROM Video_Game vg, publish p WHERE vg.g_ID = p.g_ID AND p.a_ID = " . $_SESSION["a_ID"] . ";";

            $card_result = mysqli_query($db, $query);

            if (!$card_result) {
                printf("Error: %s\n", mysqli_error($db));
                exit();
            }
            if (mysqli_num_rows($card_result) > 0) {
                while ($cards_row = mysqli_fetch_assoc($card_result)) {
                    $game_name = $cards_row['g_name'];
                    $game_desc = $cards_row['g_description'];
                    $publish_date = $cards_row['date'];
                    
                    echo "<div class='games-row2' style='display: flex; height: 300px; margin-top: 25px'>
                <div class='game-image' style='width: 50%; height: 100%;
                    
                    overflow: hidden;
                    text-align: center;
                    font-size: 30px;
                     margin-bottom: 10px;
                     border-style: solid;
                     border-color: rgba(112,112,112,1);
                     border-width: 2px;
                     margin-right: 100px;
                     margin-left: 100px;
                     border-radius: 20px;'>
                    <div style='width: 100%; height: 100%; position: relative; text-align: center'>
                <img style=' height: 100%; width: 100%;' src='../Assets/images/game.jpg' alt=''>
                </div>
                </div>
                <div class='game-description' style='display: table; overflow: hidden; width: 50%; height: 100%;'>
                    <div style='display: table-cell; vertical-align: middle; padding-left: 50px;'>
                        <div>
                            <span style='font-weight: bold'>Name: </span>
                            <span>". $game_name ."</span>
                        </div>
                        <div>
                            <span style='font-weight: bold'>Description: </span>
                            <span>". $game_desc ."</span>
                        </div>
                        <br>
                        <div>
                                    <button type='button' class='btn btn-primary' class='btn btn-primary btn-lg' style='float:right; font-family: Avenir; width: 25%; background-color: rgba(93, 239, 132, 100); border-color: #ffffff; border-radius: 20px' data-toggle='modal' data-target='#exampleModalCenter3'>
                                                Published:  " . $publish_date . "
                                    </button>
                                </div>
                    </div>
                </div>
            </div>";
                }
            }
            else {
                echo "        No games found as published, first accept requests then approve!";
            }
        ?>
    </div>
    <div style="margin-top: 50px;
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
        }
        else {
            let form = document.getElementById("login-form").submit();
        }
    }
</script>
</body>
</html>
