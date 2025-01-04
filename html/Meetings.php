<?php
include("../connection/Connection.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT id, meeting_title, date_of_meeting, agenda, created_at, visibility FROM meetings ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Minutes</title>
    <link rel="stylesheet" href="../css/Meetings.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <header>
        <div class="logo">
            <a href="../html/HomePage.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Meeting Minutes</span>
        </div>
        <nav class="nav-links">
            <a href="../html/HomePage.php" class="nav-item">HOME</a>
        </nav>
    </header>


    <main>
        <h1>MEETING MINUTES</h1>

        <div class="meetings-board">
          <?php

          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $hide_button_text = $row['visibility'] == 1 ? 'Hide' : 'Unhide'; 
                  echo '
                  <div class="meeting-post">
                      <div class="meeting-summary">
                          <a href="../connection/GeneratePDF.php?meeting_id=' . urlencode($row['id']) . '" target="_blank" class="meeting-title">
                              ' . htmlspecialchars($row['meeting_title']) . '
                          </a>
                          <span class="meeting-date">Posted: ' . htmlspecialchars(date("F j, Y, g:i a", strtotime($row['created_at']))) . '</span>
                      </div>
                  </div>';
              }
          } else {
              echo '<p>No meetings available.</p>';
          }
          $conn->close();
          ?>
      </div>
    </main>


</body>
</html>
