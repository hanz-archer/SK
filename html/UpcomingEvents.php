<?php
include("../connection/Connection.php");


$query = "SELECT * FROM upcoming_events ORDER BY UE_ID DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <link rel="stylesheet" href="../css/UE.css">
</head>
<body>

    <header>
        <div class="logo">
            <a href="../html/HomePage.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - Upcoming Events</span>
        </div>
        <nav class="nav-links">
            <a href="../html/HomePage.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <main>
        <h1>UPCOMING EVENTS</h1><br>

        <div class="events-board">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="event-card">';
                    echo '<h2>' . htmlspecialchars($row['Title']) . '</h2>';
                    $date = new DateTime($row['Date_of_Event']);
                    echo '<p class="event-date">Date of Event: ' . $date->format('F j, Y') . '</p>';
                    echo '<p class="event-venue">Venue: ' . htmlspecialchars($row['Venue']) . '</p>';
                    echo '<p class="event-details">' . htmlspecialchars($row['Description']) . '</p>';
                    
                    echo '</div>';
                }
            } else {
                echo '<p>No upcoming events available.</p>';
            }
            ?>
        </div>
    </main>


</body>
</html>
