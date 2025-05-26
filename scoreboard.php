<?php
session_start();
require_once("Database.php");
$DB = new Database();

// 1. Handle player ID popup if redirected from registration
$player_ID = $_SESSION['new_player_id'] ?? null;
if ($player_ID) {
    unset($_SESSION['new_player_id']); // Only show once
}

// 2. Fetch all judges (to display their names as columns)
$judges = $DB->readFromdb("SELECT * FROM judges");
$judge_names = [];
$judge_ids = [];

if ($judges && is_array($judges)) {
    foreach ($judges as $judge) {
        $judge_names[] = $judge['judge_name'];
        $judge_ids[] = $judge['id'];
    }
}

// 3. Fetch all players with their total score and score breakdown
$players = $DB->readFromdb("SELECT * FROM players");
$searchQuery = $_GET['search'] ?? null;
$player_scores = [];

if ($players && is_array($players)) {
    foreach ($players as $player) {
        $player_id = $player['id'];
        $player_name = $player['player_name'];
        $player_code = $player['player_ID'];

        // Check if this player matches the search query
        $isMatch = false;
        if ($searchQuery) {
            if (stripos($player_code, $searchQuery) !== false) {
                $isMatch = true;
            } else {
                continue; // Skip non-matching players
            }
        }

        // Fetch all scores for this player
        $scores = $DB->readFromdb("SELECT judge_id, score FROM scores WHERE player_id = $player_id");

        // Map judge_id => score
        $score_map = [];
        $total = 0;
        if ($scores && is_array($scores)) {
            foreach ($scores as $score_row) {
                $jid = $score_row['judge_id'];
                $score = $score_row['score'];
                $score_map[$jid] = $score;
                $total += $score;
            }
        }

        $player_scores[] = [
            'name' => $player_name,
            'code' => $player_code,
            'total' => $total,
            'breakdown' => $score_map,
            'highlight' => $isMatch,
        ];
    }

    // Sort players by total score DESC
    if (!$searchQuery) {
        usort($player_scores, fn($a, $b) => $b['total'] <=> $a['total']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreboardCom | Scoreboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <!-- Auto refresh every 20s -->
    <meta http-equiv="refresh" content="20">
</head>
<body>
<div class="max_width_wrapper">
    <main>
        <div class="overal_records">
            <div class="centered_logo">
                <div class="div_logo">
                    <a href="index.php">
                        <img src="images/logo.jpg" alt="" class="image_logo smaller_width">
                    </a>
                </div>
            </div>
            <h6 style="font-size: 1.6rem;">LEADERBOARD</h6>
            <form method="GET" style="margin-bottom: 1rem; width: 70%; margin: 0 auto;">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Enter Player ID (e.g., PN123)" 
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
                    class="sign_inputs reg_inputs lesser_width"
                    required
                >
                <button type="submit" class="submit_btn">Search</button>
            </form>
            <div class="table_div">
                <?php if (!$player_scores): ?>
                    <p class="two_rem">No one has registered for the game yet.</p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th rowspan="2">Rank</th>
                            <th rowspan="2">Player Name</th>
                            <th rowspan="2">Player ID</th>
                            <th rowspan="2">Total Score</th>
                            <th colspan="<?= count($judge_names) ?>">Score Breakdown</th>
                        </tr>
                        <tr>
                            <?php foreach ($judge_names as $name): ?>
                                <th><?= htmlspecialchars($name) ?></th>
                            <?php endforeach; ?>
                        </tr>
                        <?php $rank = 1; ?>
                        <?php foreach ($player_scores as $player): ?>
                            <tr>
                                <td><?= $rank++ ?></td>
                                <td><?= htmlspecialchars($player['name']) ?></td>
                                <td><?= htmlspecialchars($player['code']) ?></td>
                                <td><?= $player['total'] ?></td>
                                <?php foreach ($judge_ids as $jid): ?>
                                    <td><?= $player['breakdown'][$jid] ?? '-' ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<!-- Player ID Popup -->
<?php if ($player_ID): ?>
    <script>
        alert("Registration successful! Your Player ID is: <?= $player_ID ?>");
    </script>
<?php endif; ?>
</body>
</html>
