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
    <title>Admin Upcoming Events</title>
    <link rel="stylesheet" href="../css/UE.css">
</head>

<body>

    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - Upcoming Events</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <main>
        <h1>UPCOMING EVENTS</h1><br>

        <div class="events-board">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="event-card">';
                    // Include image if available
                    if (!empty($row['ImageURL'])) {
                        echo '<img src="' . htmlspecialchars($row['ImageURL']) . '" alt="Event Image" class="event-image">';
                    }
                    echo '<h2>' . htmlspecialchars($row['Title']) . '</h2>';
                    $date = new DateTime($row['Date_of_Event']);
                    echo '<p class="event-date">Date of Event: ' . $date->format('F j, Y') . '</p>';
                    echo '<p class="event-venue">Venue: ' . htmlspecialchars($row['Venue']) . '</p>';
                    echo '<p class="event-details">' . nl2br(htmlspecialchars($row['Description'])) . '</p>';
                    echo '<div class="action-buttons">';
                    echo '<a href="../edit/EditUE.php?UE_ID=' . $row['UE_ID'] . '" class="edit-btn">Edit</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No upcoming events available.</p>';
            }
            ?>
        </div>
    </main>

    <div class="plus-button" onclick="window.location.href='../post/PostUE.php'">
        <img src="../images/plus_icon.png" alt="Plus Icon">
    </div>

</body>

</html>
