<?php
require_once("Database.php");
$DB = new Database();

// Handles deletion of a judge
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $judgeId = intval($_GET['delete']);

    // Check if the judge has submitted any scores
    $checkScores = $DB->readFromdb("SELECT * FROM scores WHERE judge_id = $judgeId");

    if ($checkScores && count($checkScores) > 0) {
        // Redirect back with error flag
        header("Location: admin.php?error=has_scores");
        exit();
    } else {
        $DB->saveTodb("DELETE FROM judges WHERE id = $judgeId");
        header("Location: admin.php?success=deleted");
        exit();
    }
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $DB->escapeString($_POST['judge_name']);
    $uniqueID = $DB->escapeString($_POST['unique_ID']);

    if (!empty($name) && !empty($uniqueID)) {
        $query = "INSERT INTO judges (judge_name, unique_ID) VALUES ('$name', '$uniqueID')";
        $DB->saveTodb($query);
        
        // Redirect to this same page
        header("Location: admin.php");
        exit();
    }
}

// Fetch judges
$judges = $DB->readFromdb("SELECT * FROM judges");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreboardCom | admin</title>
    <!-- cdjs link to render the fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- css style document -->
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>
    <div class="max_width_wrapper">
        <header></header>
        <main>
            <div class="overal_records">
                <!-- Messages for when an error occured while deleting or successfull removal of a judge -->
                <?php if (isset($_GET['error']) && $_GET['error'] == 'has_scores'): ?>
                    <p style="color: red; font-weight: bold;">This judge has already submitted scores and cannot be deleted.</p>
                <?php elseif (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
                    <p style="color: green; font-weight: bold;">Judge removed successfully.</p>
                <?php endif; ?>

                <div class="centered_logo">
                    <div class = "div_logo">
                        <a href="index.php">
                            <img src="images/logo.jpg" alt="" class="image_logo smaller_width">
                        </a>
                    </div>
                </div>
                <div class="record_cards dynamic_flex">
                     <?php if (!$judges): ?>
                        <div class="record_card">
                            <p class="two_rem">NO JUDGES HAVE BEEN REGISTERED YET</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($judges as $judge): ?>
                            <div class="record_card">
                                <div class="dynamic_flex">
                                    <div class="static_flex">
                                        <div><p class="two_rem">Judges Name:</p></div>
                                        <div><p class="two_rem"><?= htmlspecialchars($judge['judge_name']) ?></p></div>
                                    </div>
                                    <div class="static_flex">
                                        <div><p class="two_rem">Judge ID:</p></div>
                                        <div><p class="two_rem"><?= htmlspecialchars($judge['unique_ID']) ?></p></div>
                                    </div>
                                </div>
                                <!--Remove Button -->
                                <form method="GET" onsubmit="return confirm('Are you sure you want to remove this judge?');">
                                    <input type="hidden" name="delete" value="<?= $judge['id'] ?>">
                                    <button type="submit" class="remove_judge_btn submit_btn">Remove Judge</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="accordion">
                    <button class="accordion_button"><p class = "two_rem">Go ahead and register judges<i class="fa-solid fa-caret-down"></i></p></button>
                    <div class="accordion_content">
                        <div class="record_div_form">
                            <form class = "record_form" method="POST">
                                <div class="dynamic_flex">
                                    <div class="static_flex">
                                        <div><label for="judge_name">Judge's Name:</label></div>
                                        <div><input type="text" name="judge_name" id="" required></div>
                                    </div>
                                    <div class="static_flex">
                                        <div><label for="judge_id">Judge's ID:</label></div>
                                        <div><input type="text" name="unique_ID" id="" required></div>
                                    </div>
                                </div>
                                <!-- submit button -->
                                <div class="dynamic_flex">
                                        <div class = centered_flex>
                                            <input type="submit" value="submit" class = "submit_btn">
                                        </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer></footer>
    </div>

    <!-- Javascript for the form to appear and disappear by a click of a button(accordion) -->
    <script>
        const accordionButtons = document.querySelectorAll(".accordion_button");

        accordionButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Toggle the active class to show/hide
            const content = button.nextElementSibling;

            // Close all other open sections (optional)
            document.querySelectorAll('.accordion_content').forEach((el) => {
            if (el !== content) el.style.display = "none";
            });

            // Toggle current one
            if (content.style.display === "block") {
            content.style.display = "none";
            } else {
            content.style.display = "block";
            }
        });
        });
    </script>

    <!-- Confirmation message for removing a jugde -->
    <script>
        function confirmDelete(judgeId) {
            if (confirm("Are you sure you want to delete this judge? This action cannot be undone.")) {
                window.location.href = "admin.php?delete=" + judgeId;
            }
        }
    </script>

</body>
</html>