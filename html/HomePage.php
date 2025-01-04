<?php
session_start();
include('../connection/LoginConnection.php'); 


if (isset($_SESSION['first_name'])) {
    $userName = $_SESSION['first_name'];
} else {

    header("Location: ../html/Welcome.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sangguniang Kabataan - Barangay Sumaguan</title>
    <link rel="stylesheet" href="../css/HomePage.css">

</head>
<body>

    <header>
        <div class="logo">
            <img src="../images/SK_Logo.png" alt="SK Logo">
        </div>
        
        <nav class="header-container">
            <div class="profile" onclick="toggleProfileMenu()">
                <span class="profile-text">Hi, <?php echo htmlspecialchars($userName); ?> &#x25BC;</span>
                <div class="profile-dropdown" id="profileMenu">
                    <a href="../html/Welcome.php">Log Out</a>
                </div>
            </div>
        </nav>
        
        <div class="header-title">
            <h1>SANGGUNIANG KABATAAN</h1>
            <h2>Barangay Sumaguan<h2>
        </div>
    </header>

    <section class="grid-container">
        <a href="../html/Announcement.php" class="grid-item">
            <img src="../images/announce_icon.png" alt="Announcement">
            <h2>Announcement</h2>
        </a>
        <a href="../html/ProgramsActivities.php" class="grid-item">
            <img src="../images/P&A_icon.png" alt="Programs & Activities">
            <h2>Programs & Activities</h2>
        </a>
       
        <a href="../html/Meetings.php" class="grid-item">
            <img src="../images/M&M_icon.png" alt="Meetings & Minutes">
            <h2>Meetings & Minutes</h2>
        </a>

        <a href="Photos.php" class="grid-item">
            <img src="../images/photos_icon.png" alt="Photos">
            <h2>Photos</h2>
        </a>

        <!-- <a href="../html/BudgetAllocation.php" class="grid-item">
            <img src="../images/budget_icon.png" alt="Budget Allocation">
            <h2>Budget Allocation</h2>
        </a> -->
        <a href="../html/Awards.php" class="grid-item">
            <img src="../images/certificate_icon.png" alt="Awards & Certifications">
            <h2>Awards & Certifications</h2>
        </a>
        <a href="../html/SuggestionFeedbacks.php" class="grid-item">
            <img src="../images/suggestions_icon.png" alt="Suggestions & Feedback">
            <h2>Suggestions & Feedback</h2>
        </a>

    </section>

    <script>
        function toggleProfileMenu() {
            const profileMenu = document.getElementById('profileMenu');
            profileMenu.classList.toggle('show');
        }

        window.onclick = function(event) {
            if (!event.target.matches('.profile-text')) {
                var dropdowns = document.getElementsByClassName("profile-dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>

</body>
</html>
