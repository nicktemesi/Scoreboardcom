<?php
session_start();
require_once("Database.php");
$DB = new Database();

// Make sure judge is verified
if (!isset($_SESSION['unique_ID'])) {
    header("Location: judge validation form.php");
    exit();
}

$uniqueID = $_SESSION['unique_ID'];
$judge_name = $_SESSION['judge_name'] ?? "Unknown Judge";

// Get judge ID from DB using the unique_ID (we need the numeric ID for scores table)
$judgeData = $DB->readFromdb("SELECT * FROM judges WHERE unique_ID = '$uniqueID'");
if (!$judgeData) {
    die("Judge not found.");
}
$judge_id = $judgeData[0]['id'];

// Handle vote submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $player_id = $_POST['player_id'];
    $score = $_POST['vote'];

    if ($score >= 0 && $score <= 1000) {
        // Check if this judge already scored this player
        $checkQuery = "SELECT * FROM scores WHERE judge_id = $judge_id AND player_id = $player_id";
        $checkResult = $DB->readFromdb($checkQuery);

        if (!$checkResult) {
            $insertQuery = "INSERT INTO scores (judge_id, player_id, score) VALUES ($judge_id, $player_id, $score)";
            $DB->saveTodb($insertQuery);

            // Prevent resubmission on refresh
            header("Location: judges.php");
            exit();
        }
    }
}

// Get all players from DB
$players = $DB->readFromdb("SELECT * FROM players");

// Get players already voted on by this judge
$voted = $DB->readFromdb("SELECT player_id FROM scores WHERE judge_id = $judge_id");
$voted_ids = is_array($voted) ? array_column($voted, 'player_id') : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreboardCom | Judge</title>
    <!-- cdjs link to render the fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- css style document -->
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>
    <div class="max_width_wrapper">
        <header class = "centered_nav">
            <div>
                <ul class = "nav-list margin_style gap">
                    <li ><div class = "card"><p class = "two_rem">Judge: <?= htmlspecialchars($judge_name) ?></p></div></li>
                    <li><a href="scoreboard.php"><div class = "card"><p class = "two_rem">View scoreboard</p></div></a></li>
                    <li><a href="logout.php"><div class = "card"><p class = "two_rem">Log Out</p></div></a></li>
                </ul>
            </div>
        </header>
        <main>
            <div class="overal_records">
                <div class="centered_logo">
                    <div class = "div_logo">
                        <a href="index.php">
                            <img src="images/logo.jpg" alt="" class="image_logo smaller_width">
                        </a>
                    </div>
                </div>                
                <h6 style = " font-size: 1.6rem;">PLAYERS</h6>
                <div class="table_div">
                    <?php if (!$players): ?>
                        <p class="two_rem">No players have registered yet.</p>
                    <?php else: ?>
                    <table >
                        <tr>
                            <th>Player Name</th>
                            <th>Player ID</th>
                            <th>Vote</th>
                            <th >Status</th>
                        </tr>
                        <?php foreach ($players as $player): ?>
                            <?php
                                $hasVoted = in_array($player['id'], $voted_ids);
                            ?>
                            <tr>
                                <form action="" method="POST">
                                    <td><?= htmlspecialchars($player['player_name']) ?></td>
                                    <td><?= htmlspecialchars($player['player_ID']) ?></td>
                                    <td>
                                        <?php if ($hasVoted): ?>
                                                    <input type="number" name="vote" disabled placeholder="Voted" />
                                                <?php else: ?>
                                                    <input type="number" name="vote" min="0" max="1000" required>
                                                <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                                                <button type="submit" class="submit_btn" <?= $hasVoted ? "disabled" : "" ?>>
                                                    <?= $hasVoted ? "Submitted" : "Submit" ?>
                                                </button>
                                    </td>
                                </form>
                            </tr>    
                        <?php endforeach; ?>        
                    </table>
                    <?php endif; ?>
                </div>               
            </div>
        </main>
        <footer></footer>
    </div>

</body>
</html>