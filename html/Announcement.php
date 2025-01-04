<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link rel="stylesheet" href="../css/Announcement.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Announcements</span>
        </div>
        <nav class="nav-links">
            <a href="../html/HomePage.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <main>
        <h1>ANNOUNCEMENTS</h1><br>

        <div class="bulletin-board">
            <?php

                $conn = new mysqli("localhost", "root", "", "skdb");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT AnnouncementID, Title, Date, Description 
                        FROM announcements 
                        ORDER BY Date DESC, AnnouncementID DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="announcement-card">';
                        echo '<h2>' . htmlspecialchars($row["Title"]) . '</h2>';
                        echo '<p class="announcement-date">Posted: ' . date("F j, Y, g:i A", strtotime($row["Date"])) . '</p>';
                        echo '<p class="announcement-details">' . htmlspecialchars($row["Description"]) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No announcements available at the moment.</p>";
                }

                $conn->close();
            ?>
        </div>

    </main>
</body>

</html>
