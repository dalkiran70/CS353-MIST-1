<?php
include("config.php");
session_start();

if (isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];

    $game_query = "SELECT * FROM Video_Game WHERE g_id = " . $game_id . ";";
    $game_query_result = mysqli_query($db, $game_query);
    if (!$game_query_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $game_row = mysqli_fetch_assoc($game_query_result);

    $g_id = $game_row['g_ID'];
    $g_name = $game_row['g_name'];
    $g_version = $game_row['g_version'];
    $g_description = $game_row['g_description'];
    $g_image = $game_row['g_image'];
    $g_price = $game_row['g_price'];
    $genre = $game_row['genre'];
    $g_requirements = $game_row['g_requirements'];

    $lele_query = "SELECT version_no, description FROM updates WHERE g_ID = ". $g_id .";";

    $result = mysqli_query($db, $lele_query);
    if (!$result) {
        printf("Error55534: %s\n", mysqli_error($db));
        exit();
    }
    $lele_row = mysqli_fetch_assoc($result);

    $upNo = $lele_row['version_no'];
    $upDesc = $lele_row['description'];
    echo "";
                
}

if (isset($_POST['rate_given_text'])) {
    $rew_given_text = trim($_POST["rate_given_text"]);
    $a_id = $_SESSION["a_ID"];
    $game_id = $_GET['game_id'];
    $date = date("Y/m/d");
    $insert_com_query = "INSERT INTO rates(a_ID, g_ID, value) VALUES ($a_id  , $game_id, $rew_given_text );";
    $insert_com_result = mysqli_query($db, $insert_com_query);
    if (!$insert_com_result) {
        printf("Error: %s\n", mysqli_error($db));
        printf("Error: 1");
        exit();
    }
    echo "<script LANGUAGE='JavaScript'>
                    window.alert('You Rated The Game');
                </script>";
}

if (isset($_POST['update'])) {
    $has_query = "SELECT vg.g_version AS g_ver FROM Video_Game vg WHERE vg.g_ID = " . $g_id . ";";
                            $has_query_result = mysqli_query($db, $has_query);

                            if (!$has_query_result) {
                                printf("Error: %s\n", mysqli_error($db));

                                exit();
                            }
                            $has_row = mysqli_fetch_assoc($has_query_result);
                            $vg_ver = $has_row['g_ver'];

    $update_game_query = "UPDATE install i SET i.version_no = ".$vg_ver." WHERE i.g_ID = ".$g_id." AND i.a_ID = " . $_SESSION['a_ID'] . ";";
    $update_game_query = mysqli_query($db, $update_game_query);
    if (!$update_game_query) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    echo "<script LANGUAGE='JavaScript'>
                window.alert('Your Game sucessfully updated');
            </script>";
}
if (isset($_POST['uninstall'])) {
    $delete_query = "DELETE FROM install WHERE a_ID=" . $_SESSION['a_ID'] . " AND g_ID=" . $g_id . ";";

    $delete_query_result = mysqli_query($db, $delete_query);
    if (!$delete_query_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    echo "<script LANGUAGE='JavaScript'>
                window.alert('You successfully uninstall  your Game...');
            </script>";
}
if (isset($_POST['install'])) {
    $insert_query = "SELECT g_version FROM Video_Game v WHERE v.g_ID =  " . $g_id . " ;";

    $delete_query_result = mysqli_query($db, $insert_query);
    if (!$delete_query_result) {
        printf("Error: %s\n", mysqli_error($db));


        exit();
    }
    $has_row = mysqli_fetch_assoc($delete_query_result);
    $has_count = $has_row['g_version'];


    $insert_query = "INSERT INTO install VALUES ( " . $_SESSION['a_ID'] . ",  " . $g_id . " , " . $has_count . " );";

    $delete_query_result = mysqli_query($db, $insert_query);
    if (!$delete_query_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    echo "<script LANGUAGE='JavaScript'>
                window.alert('You successfully install  the Video Game...');
            </script>";
}
if (isset($_POST['return'])) {
    $delete_query = "DELETE FROM buys WHERE a_ID=" . $_SESSION['a_ID'] . " AND g_ID=" . $g_id . ";";

    $delete_query_result = mysqli_query($db, $delete_query);
    if (!$delete_query_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    $update_wallet_query = "UPDATE Wallet w SET w.balance = w.balance + " . $g_price . " WHERE w.a_ID = " . $_SESSION['a_ID'] . ";";
    $update_wallet_result = mysqli_query($db, $update_wallet_query);
    if (!$update_wallet_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $a_id = $_SESSION["a_ID"];
    $game_id = $_GET['game_id'];
    $delete_query = "DELETE FROM comments_on WHERE a_ID=" . $a_id . " AND g_ID=" . $game_id . ";";

    $delete_query_result = mysqli_query($db, $delete_query);
    if (!$delete_query_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    echo "<script LANGUAGE='JavaScript'>
                window.alert('You successfully returned  the Video Game...');
            </script>";
    $que = "SELECT COUNT(*) AS cc FROM install WHERE a_ID=" . $_SESSION['a_ID'] . " AND g_ID=" . $g_id . ";";
    $delete_query_result = mysqli_query($db, $que);

    if (!$delete_query_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $has_row = mysqli_fetch_assoc($delete_query_result);
    $has_count = $has_row['cc'];
    if ($has_count > 0 ) {
        $delete_query = "DELETE FROM install WHERE a_ID=" . $_SESSION['a_ID'] . " AND g_ID=" . $g_id . ";";

        $delete_query_result = mysqli_query($db, $delete_query);
        if (!$delete_query_result) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }
        echo "<script LANGUAGE='JavaScript'>
                            window.alert('You successfully uninstall  the Video Game...');
                        </script>";
    }
} elseif (isset($_POST['buy'])) {
    $get_balance_query = "SELECT w.balance FROM Wallet w WHERE w.a_ID=" . $_SESSION['a_ID'] . ";";
    $get_balance_query_result = mysqli_query($db, $get_balance_query);
    if (!$get_balance_query_result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    $get_balance_row = mysqli_fetch_assoc($get_balance_query_result);
    $user_balance = $get_balance_row['balance'];
    if ($user_balance < $g_price) {
        echo "<script type='text/javascript'>alert('Your balance is not sufficient.');</script>";
    } else {


        $insert_query = "INSERT INTO buys VALUES (" . $_SESSION['a_ID'] . ", " . $g_id . ", now());";
        $insert_query_result = mysqli_query($db, $insert_query);
        if (!$insert_query_result) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }

        $update_wallet_query = "UPDATE Wallet w SET w.balance = w.balance - " . $g_price . " WHERE w.a_ID = " . $_SESSION['a_ID'] . ";";
        $update_wallet_result = mysqli_query($db, $update_wallet_query);
        if (!$update_wallet_result) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }
        echo "<script LANGUAGE='JavaScript'>
                window.alert('You successfully bought the video game...');
            </script>";
    }
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
        <div class="main-div" style="padding-left: 2%; padding-right: 2%; padding-top: 2%; padding-bottom: 1%">
            <div class="information-header" style="width: 100%">
                <div style="display: flex; justify-content: space-between">
                    <div style="font-family: Avenir; font-size: 48px;">Video Game</div>
                    <div style=" width: 420px; text-align: right; margin-top: 10px" ;>
                        <?php
                        $has_query = "SELECT COUNT(*) as has_count FROM buys b WHERE b.a_ID=" . $_SESSION['a_ID'] . " AND b.g_id = " . $g_id . ";";
                        $has_query_result = mysqli_query($db, $has_query);

                        if (!$has_query_result) {
                            printf("Error: %s\n", mysqli_error($db));

                            exit();
                        }
                        $has_row = mysqli_fetch_assoc($has_query_result);
                        $has_count = $has_row['has_count'];
                        $down = $has_count;
                        if ($down > 0) {
                            echo "<form method='post'>";
                            echo "<input type='submit' name='return' onclick='' class='btn btn-primary btn-lg' 
                            style='font-family: Avenir;
                             width: 100%; 
                             background-color: rgb(234, 124, 137); 
                             border-color: rgb(234, 124, 137); 
                             border-radius: 20px' value='Return'>";
                            echo "</form>";
                            $has_query = "SELECT COUNT(*) as has_count, i.version_no AS ver FROM install i WHERE i.a_ID=" . $_SESSION['a_ID'] . " AND i.g_id = " . $g_id . ";";
                            $has_query_result = mysqli_query($db, $has_query);

                            if (!$has_query_result) {
                                printf("Error: %s\n", mysqli_error($db));

                                exit();
                            }
                            $has_row = mysqli_fetch_assoc($has_query_result);
                            $has_count = $has_row['has_count'];
                            $ins_ver = $has_row['ver'];
                            $has_query = "SELECT vg.g_version AS g_ver FROM Video_Game vg WHERE vg.g_ID = " . $g_id . ";";
                            $has_query_result = mysqli_query($db, $has_query);

                            if (!$has_query_result) {
                                printf("Error: %s\n", mysqli_error($db));

                                exit();
                            }
                            $has_row = mysqli_fetch_assoc($has_query_result);
                            $vg_ver = $has_row['g_ver'];

                            if ($has_count > 0) {
                                if($vg_ver !== $ins_ver){
                                    echo "<form method='post'>";
                                echo "<button type='button' data-toggle='modal' data-target='#update-modal' name='update' onclick='' class='btn btn-primary btn-lg' 
                                style='font-family: Avenir; margin-top: 10px;
                                width: 100%; 
                                background-color: green; 
                                border-color: green; 
                                border-radius: 20px'> Update </button>";
                                echo "</form>";
                                }
                                else{
                                    echo "<form method='post'>";
                                    echo "<input type='submit' name='uninstall' onclick='' class='btn btn-primary btn-lg' 
                                style='font-family: Avenir; margin-top: 10px;
                                 width: 100%; 
                                 background-color: rgb(234, 124, 137); 
                                 border-color: rgb(234, 124, 137); 
                                 border-radius: 20px' value='Uninstall'>";
                                    echo "</form>";
                                }
                                
                            } else {
                                echo "<form method='post'>";
                                echo "<input type='submit' name='install' onclick='' class='btn btn-primary btn-lg' 
                            style='font-family: Avenir; margin-top: 10px;
                            width: 100%; background-color: rgb(93, 239, 132); 
                            border-color: rgb(93, 239, 132); 
                            border-radius: 20px' value='Install '>";
                                echo "</form>";
                            }
                        } else {
                            echo "<form method='post'>";
                            echo "<input type='submit' name='buy' onclick='' class='btn btn-primary btn-lg' 
                            style='font-family: Avenir; 
                            width: 100%; background-color: rgb(93, 239, 132); 
                            border-color: rgb(93, 239, 132); 
                            border-radius: 20px' value='Buy " . $g_price . "TL'>";
                            echo "</form>";
                        }

                        ?>
                    </div>
                </div>
                <hr style="margin-right: 60%">
            </div>
            <div class="package-details" style="width: 100%; display: flex;">
                <div class="package-details-p1" style="width: 50%">
                    <div style=" display: inline-block; float:none; position: relative; vertical-align: middle; margin-top: 10%">
                        <img src="../Assets/images/package.jpeg" />
                    </div>
                </div>
                <div class="game-details-p2" style="width: 50%; font-family: Avenir; font-size: 24px">
                    <?php
                    $has_query = "SELECT SUM(r.value) as has_count , COUNT(r.value) as com FROM rates r WHERE  r.g_ID = " . $g_id . ";";
                    $has_query_result = mysqli_query($db, $has_query);

                    if (!$has_query_result) {
                        printf("Error: %s\n", mysqli_error($db));

                        exit();
                    }
                    $has_row = mysqli_fetch_assoc($has_query_result);
                    $has_count = $has_row['has_count'];
                    $com = $has_row['com'];
                    if ($com == 0) {
                        $com = 1;
                    } else {
                        $com = $has_row['com'];
                    }
                    $has_count = $has_count / $com;
                    $has_query = "SELECT COUNT(*) as has_count FROM install i WHERE  i.g_id = " . $g_id . ";";
                    $has_query_result = mysqli_query($db, $has_query);

                    if (!$has_query_result) {
                        printf("Error: %s\n", mysqli_error($db));

                        exit();
                    }
                    $has_row = mysqli_fetch_assoc($has_query_result);
                    $down = $has_row['has_count'];

                    echo "<div class='game-name'; style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Game Name: </span> " . $g_name . "
                        </div>
                        <div class='game-description'; style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Game Description: </span> " . $g_description . "
                        </div>
                        <div class='game-genre'; style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Genre: </span> " . $genre . "
                        </div>
                        <div class='package-duration' style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Downloaded: </span> " . $down . "
                        </div>
                        <div class='package-duration' style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Rate: </span> " . $has_count . "
                             
                        </div>";
                    $a_id = $_SESSION["a_ID"];
                    $has_query = "SELECT COUNT(*) AS has_count FROM rates r WHERE r.a_ID = " . $a_id . " AND r.g_ID = " . $g_id . ";";
                    $has_query_result = mysqli_query($db, $has_query);

                    if (!$has_query_result) {
                        printf("Error: %s\n", mysqli_error($db));

                        exit();
                    }
                    $has_row = mysqli_fetch_assoc($has_query_result);
                    $co_rate = $has_row['has_count'];
                    $has_query = "SELECT COUNT(*) AS has_count FROM buys b WHERE b.a_ID = " . $a_id . " AND b.g_ID = " . $g_id . ";";
                    $has_query_result = mysqli_query($db, $has_query);

                    if (!$has_query_result) {
                        printf("Error: %s\n", mysqli_error($db));

                        exit();
                    }
                    $has_row = mysqli_fetch_assoc($has_query_result);
                    $is_buy = $has_row['has_count'];
                    if ( $is_buy > 0 && $co_rate < 1) {
                        echo "<form id='create-rate-form' method='post'>
                            <div class='input-group' >
                        <input id='rate_given_text' type='number' class='form-control' name='rate_given_text' placeholder='Rate' style='  margin-right: 80%;outline: none; font-size: 20px; border-style: solid; border-radius: 20px'>
                    </div>
                    <div class='form-group' style='text-align: left; margin-top: 10px'>
                        <input onclick='checkEmptyAndCreateRate()' type='button' class='btn btn-primary btn-lg' style='background-color: rgb(86, 188, 22); border-color: rgb(86, 188, 22); border-radius: 20px' value='     Rate     '>
                    </div>
                </form>
                            
                            ";
                    }

                    ?>
                </div>
            </div>
            <div style="justify-content:space-around; display: flex; margin:auto; margin-top: 20px;">
                <div style=" margin-right: 200px ;float: left; width: 420px; text-align: left" ;>
                    <div class="btn btn-primary btn-lg" style="width: 100%; 
                  background-color: rgb(126, 166, 234); 
                  border-color: rgb(126, 166, 234);
                  border-radius: 20px">
                        <?php
                        echo " <a href='videogame.php?game_id=" . $game_id . "'>
                        <div style='text-decoration:none;color: white '>
                        <span>Abouts</span>
                        </div>

                  
                  </a>";
                        ?>
                    </div>
                </div>
                <div style="  margin-left: 200px;  float: right; width: 420px; text-align: right" ;>
                    <div class="btn btn-primary btn-lg" style="width: 100%; 
                  background-color: rgb(256, 256, 256); 
                  border-color: rgba(112,112,112,0.3);
                  border-radius: 20px">
                        <?php
                        echo " <a href='commentsandreview.php?game_id=" . $game_id . "'>
                        <div style='text-decoration:none;color: black '>
                        <span>Comments & Reviews</span>
                        </div>

                  
                  </a>";
                        ?>
                    </div>
                </div>
                <div style="  margin-left: 200px;  float: right; width: 420px; text-align: right" ;>
                    <div class="btn btn-primary btn-lg" style="width: 100%; 
                  background-color: rgb(256, 256, 256); 
                  border-color: rgba(112,112,112,0.3);
                  border-radius: 20px">
                        <?php
                        echo " <a href='modsvideo.php?game_id=" . $game_id . "'>
                        <div style='text-decoration:none;color:black '>
                        <span>Mods</span>
                        </div>

                  
                  </a>";
                        ?>
                    </div>
                </div>

            </div>
            <?php
            $has_query = "SELECT c_name as developer_name FROM develops d , Company c WHERE d.a_ID=  c.a_ID  AND d.g_id = " . $g_id . ";";
            $has_query_result = mysqli_query($db, $has_query);


            if (!$has_query_result) {
                printf("Error: %s\n", mysqli_error($db));

                exit();
            }
            $has_row = mysqli_fetch_assoc($has_query_result);
            $dev_name = $has_row['developer_name'];

            $has_query = "SELECT c_name as publish_name FROM publish p , Company c WHERE p.a_ID=  c.a_ID  AND p.g_Id = " . $g_id . ";";
            $has_query_result = mysqli_query($db, $has_query);


            if (!$has_query_result) {
                printf("Error: %s\n", mysqli_error($db));

                exit();
            }
            $has_row = mysqli_fetch_assoc($has_query_result);
            $pub_name = $has_row['publish_name'];

            $has_query = "SELECT date as g_date FROM updates u  WHERE  u.g_Id = " . $g_id . ";";
            $has_query_result = mysqli_query($db, $has_query);


            if (!$has_query_result) {
                printf("Error: %s\n", mysqli_error($db));

                exit();
            }
            $has_row = mysqli_fetch_assoc($has_query_result);
            $update_date = $has_row['g_date'];


            ?>
            <div class="game-details-p3" style="width: 50%; font-family: Avenir; font-size: 24px">
                <?php
                echo "<div class='game-requirement'; style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Minimum System Requirement: </span> " . $g_requirements . "
                        </div>
                        <div class='game-description'; style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Developer: </span> " . $dev_name . "
                        </div>
                        <div class='game-genre'; style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Publisher: </span> " . $pub_name . "
                        </div>
                        <div class='package-duration' style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Version: </span> " . $g_version . "
                        </div>
                        <div class='package-duration' style='margin-top: 20px;'>
                            <span style='font-weight: bold'>Last Update On: </span> " . $update_date . "
                        </div>
                        ";
                ?>
            </div>
        </div>


        <div style="position: fixed;
                left: 0;
                bottom: 5px;
                width: 100%;
                text-align: center;
                font-size: 20px;
                color: rgba(112,112,112,1);">
            <p>A Game Distribution Service by Pluto++</p>
        </div>

        <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered" role="main" style="height: 400px; width: 800px;">
            <div class="modal-content" style="height: 300px; width: 800px; background-color: transparent; border: none; padding: 20px">
                <div class="modal-body" style="background-color: transparent; padding: 20px">
                    <div style="background-color: white; height: 300px; width: 600px; border-radius: 30px; border-color: rgba(112,112,112,1); border-style: solid; padding: 40px">
                        <div style="text-align: center; font-size: 32px; margin-top: 10px; margin-bottom: 20px">
                            Update Game
                        </div>
                        <div style="align-items: center;">
                           <?php
                                echo "<div>
                                    Update Version: " . $upNo . "
                                </div>";
                            ?>
                            <?php
                                echo "<div>
                                    Update Description: " . $upDesc . "
                                </div>";
                            ?>
                            <form method="POST" action="">
                                <?php
                                    echo "<input type='submit' name='update' onclick='' class='btn btn-primary btn-lg' 
                                    style='font-family: Avenir; margin-top: 10px;
                                    width: 100%; 
                                    background-color: green; 
                                    border-color: green; 
                                    border-radius: 20px' value='Update'>";
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

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

            function checkEmptyAndCreateRate() {
                let giv_int = document.getElementById("rate_given_text").value;
                
                if (!giv_int && giv_int > 5) {
                    alert("Make sure to fill all fields!");
                }
                 else if (giv_int > 5) {
                    alert("Rate should not be higher than 5");
                 }
                else if (giv_int < 0) {
                    alert("Rate should not be negative");
                }
                 else {
                    let form = document.getElementById("create-rate-form").submit();
                }
            }
        </script>
</body>

</html>