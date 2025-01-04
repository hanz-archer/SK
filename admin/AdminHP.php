<?php
session_start(); 

if (!isset($_SESSION['admin_id'])) {
    header("Location: Welcome.php?error=unauthorized_access");
    exit();
}

$adminName = $_SESSION['AdminUsername'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sangguniang Kabataan - Barangay Sumaguan</title>
    <link rel="stylesheet" href="../css/AdminHP.css">
    <style>
        .profile-text {
            font-size: 1.5em;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../images/SK_Logo.png" alt="SK Logo">
            <span class="logo-text">SK Barangay Sumaguan - Admin</span>
        </div>

        <nav class="header-container">
            <div class="profile" onclick="toggleProfileMenu()">
                <span class="profile-text">Hi, <?php echo htmlspecialchars($adminName); ?> &#x25BC;</span>
                <div class="profile-dropdown" id="profileMenu">
                    <a href="../html/Welcome.php">Log Out</a>
                </div>
            </div>
        </nav>

        <div class="header-title">
            <h1>SANGGUNIANG KABATAAN</h1>
            <h2>Barangay Sumaguan</h2>
        </div>
    </header>

    
    <section class="grid-container">
        <a href="../admin/AdminAnnouncement.php" class="grid-item">
            <img src="../images/announce_icon.png" alt="Announcement">
            <h2>Announcement</h2>
        </a>
        <a href="../admin/AdminPA.php" class="grid-item">
            <img src="../images/P&A_icon.png" alt="Programs & Activities">
            <h2>Programs-Activities and Budget Allocation</h2>
        </a>

        <a href="../admin/AdminMeetings.php" class="grid-item">
            <img src="../images/M&M_icon.png" alt="Meetings & Minutes">
            <h2>Meetings & Minutes</h2>
        </a>

        <a href="AdminPhotos.php" class="grid-item">
            <img src="../images/photos_icon.png" alt="Photos">
            <h2>Photos</h2>
        </a>

        <!-- <a href="../admin/AdminBudget.php" class="grid-item">
            <img src="../images/budget_icon.png" alt="Budget Allocation">
            <h2>Budget Allocation</h2>
        </a> -->
        <a href="../admin/AdminAwards.php" class="grid-item">
            <img src="../images/certificate_icon.png" alt="Awards & Certifications">
            <h2>Awards & Certifications</h2>
        </a>
        <a href="../admin/AdminSF.php" class="grid-item">
            <img src="../images/suggestions_icon.png" alt="Suggestions & Feedback">
            <h2>Suggestions & Feedback</h2>
        </a>

    </section>

    <script>
        function toggleProfileMenu() {
            const profileMenu = document.getElementById("profileMenu");
            profileMenu.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.profile-text')) {
                const profileMenu = document.getElementById("profileMenu");
                if (profileMenu.classList.contains('show')) {
                    profileMenu.classList.remove('show');
                }
            }
        }

        function logout() {
            fetch('../connection/LogoutConnection.php', {
                method: 'GET',
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '../html/Welcome.php';
                } else {
                    console.error('Logout failed');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        window.onload = function() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        }
    </script>
</body>
</html>
