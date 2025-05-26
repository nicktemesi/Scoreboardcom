
<?php
require_once("Database.php");
$DB = new Database();

// Fetch all judges
$judges = $DB->readFromdb("SELECT * FROM judges");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreboardCom | Home</title>
    <!-- cdjs link to render the fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- css style document -->
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>
    <div class="wrapper">
        <header>
            <nav class = "nav">
                <!-- humburger navigation for mobile devies and small screens -->
                <ul class = "sidebar">
                    <li onclick = hideSidebar()><a><i class="fa-regular fa-circle-xmark fa-2x enlarge"></i></a></li>
                    <li><a href="admin.php"><div class = "card"><p>Admin</p></div></a></li>
                    <li class = "dropdown">
                        <div class = "card two_rem"><p>Judges<i class="fa-solid fa-chevron-down"></i></p></div>
                        <ul class="dropdown-content">
                            <?php if ($judges && is_array($judges)): ?>
                                <?php foreach ($judges as $judge): ?>
                                    <li><a href="judge validation form.php"><p><?= htmlspecialchars($judge['judge_name']) ?></p></a></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><p>No judges available</p></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li><a href="scoreboard.php"><div class = "card"><p>Scoreboard</p></div></a></li>
                    <li><a href="registration form.php"><div class = "card"><p>Register</p></div></a></li>
                </ul>
                <!-- navigation for desktops and large monitors -->
                <ul class = "nav-list">
                    <li>
                        <div class = "div_logo">
                            <a href="index.php">
                                <img src="images/logo.jpg" alt="" class="image_logo">
                            </a>
                        </div>
                    </li>
                    <li class = "hide_on_mobile"><a href="admin.php"><div class = "card"><p>Admin</p></div></a></li>
                    <li class = "hide_on_mobile dropdown">
                        <div class = "card two_rem"><p>Judges<i class="fa-solid fa-chevron-down"></i></p></div>
                        <ul class="dropdown-content">
                            <?php if ($judges && is_array($judges)): ?>
                                <?php foreach ($judges as $judge): ?>
                                    <li><a href="judge validation form.php"><p><?= htmlspecialchars($judge['judge_name']) ?></p></a></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><p>No judges available</p></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class = "hide_on_mobile"><a href="scoreboard.php"><div class = "card"><p>Scoreboard</p></div></a></li>
                    <li class = "hide_on_mobile"><a href="registration form.php"><div class = "card"><p>Register</p></div></a></li>
                    <li onclick = showSidebar() class = "hide_on_desktop"><a><i class="fa-solid fa-bars fa-7x enlarge"></i></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="trophy_background">
                <div class="index_div">
                    <div class="index_div_center">
                        <h1 class = "centered_h1 larger_h1">ScoreboardCom</h1>
                        <h1 class =  "larger_h1">Free & Fair Games with real time scores tracking...</h1>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="footer_cont">
                <div class = footer_desc>
                    <h5>ScoreboardCom</h5><br>
                    <p>With score board it doesn't really matter which game you are playing. 
                        No matter the game, score can be tracked real time prevent rigging. 
                        This provides equal chance for everyone who plays.
                    </p>
                </div>
                <div class="socialmedia_icons">
                    <a href=""><i class="fa-brands fa-reddit"></i></a>
                    <a href=""><i class="fa-brands fa-instagram"></i></a>
                    <a href=""><i class="fa-brands fa-facebook"></i></a>
                    <a href=""><i class="fa-brands fa-youtube"></i></a>
                </div>
                <!-- Developer Credit Section -->
                <div class="trademark_div">
                    <p>Designed and Developed by Nick Temesi</p>
                    <p>&copy; 2025 ScoreboardCom. All rights reserved</p>
                </div>
                <div class="centerred_footer_part">
                    <div class = "extra_links">
                        <a href="">Privacy Policy</a>
                        <a href="">Terms and conditions</a>
                        <a href="">About</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- javascript for controlling the navigation in different screen sizes -->
    <script>
        function showSidebar(){
            const sidebar = document.querySelector(".sidebar")
            sidebar.style.display = "flex" 
        }
        function hideSidebar(){
            const sidebar = document.querySelector(".sidebar")
            sidebar.style.display = "none" 
        }
    </script>
</body>
</html>