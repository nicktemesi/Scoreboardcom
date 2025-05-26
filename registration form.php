<?php
require_once("Database.php");
$DB = new Database();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player_name = $DB->escapeString($_POST['player_name']);

    // Generate a unique player_ID (e.g. "PN" + random 3-digit number + timestamp last 3 digits)
    $randomNum = rand(100, 999);
    $timestamp = substr(time(), -3);
    $player_ID = "PN" . $randomNum . $timestamp;

    // Insert into the database
    $insertQuery = "INSERT INTO players (player_name, player_ID) VALUES ('$player_name', '$player_ID')";
    $saved = $DB->saveTodb($insertQuery);

    if ($saved) {
        $_SESSION['new_player_id'] = $player_ID; // Store to display in scoreboard.php
        header("Location: scoreboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreboardCom | registration</title>
    <!-- cdjs link to render the fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- css style document -->
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>
    <div class="max_width_wrapper">
        <header>
            <div class="centered_logo">
                <div class = "div_logo">
                    <a href="index.html">
                        <img src="images/logo.jpg" alt="" class="image_logo smaller_width">
                    </a>
                </div>
            </div>
        </header>
        <main class = "reg_main">
            <form class = "reg_form" method = "POST">
                <p class = "two_rem">Go ahead and register as a player</p>
                <div>
                    <input type = "text" name = "player_name" placeholder="Enter your name*" class = "sign_inputs reg_inputs" required>
                    <input type="submit" class = "sign_inputs reg_inputs submit_btn">
                </div>
            </form>
        </main>
        <footer></footer>
    </div>
</body>
</html>