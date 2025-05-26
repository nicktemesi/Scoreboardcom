<?php
require_once("Database.php");
$DB = new Database();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniqueID = $DB->escapeString($_POST['unique_ID']);

    $query = "SELECT * FROM judges WHERE unique_ID = '$uniqueID'";
    $result = $DB->readFromdb($query);

    if ($result && count($result) > 0) {
        // Store judge info in session 
        session_start();
        $_SESSION['unique_ID'] = $result[0]['unique_ID'];
        $_SESSION['judge_name'] = $result[0]['judge_name'];

        //Redirect to judges.php
        header("Location: judges.php");
        exit();
    } else {
        // Invalid ID
        $error = "Invalid Judge ID. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreboardCom | Judge verification</title>
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
                    <a href="index.php">
                        <img src="images/logo.jpg" alt="" class="image_logo smaller_width">
                    </a>
                </div>
            </div>
        </header>
        <main class = "reg_main">
            <form class = "reg_form" method = "POST">
                <p class = "two_rem">Go ahead and verify your position as a jugde</p>
                <div>
                    <input type = "text" name= "unique_ID" placeholder="Enter your ID*" class = "sign_inputs reg_inputs" required>
                    <input type="submit" class = "sign_inputs reg_inputs submit_btn" >
                </div>
            </form>
            <?php if (!empty($error)): ?>
            <p style="color: red; font-size: 1.5rem;"><?= $error ?></p>
        <?php endif; ?>
        </main>
        <footer></footer>
    </div>
</body>
</html>