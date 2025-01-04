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
    <title>Admin Meeting Minutes</title>
    <link rel="stylesheet" href="../css/Meetings.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Meeting Minutes</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <!-- Main Content -->
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
                      <div class="action-buttons">
                          <a href="../edit/EditMeeting.php?meeting_id=' . urlencode($row['id']) . '" class="edit-btn">Edit</a>
                          <button class="hide-btn" onclick="confirmHide(' . htmlspecialchars($row['id']) . ')">' . $hide_button_text . '</button>
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

    <div class="plus-button">
        <a href="../post/PostMeetings.php">
            <img src="../images/plus_icon.png" alt="Plus Icon">
        </a>
    </div>


    <script>
        function confirmHide(meetingID) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to hide/unhide this meeting?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hide or unhide it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../connection/HideMeetingConnection.php',
                        type: 'GET',
                        data: { meeting_id: meetingID },
                        success: function(response) {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire(
                                    'Success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    res.message,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Failed to hide or unhide the meeting. Please try again later.',
                                'error'
                            );
                        }
                    });
                }
            })
        }
    </script>

</body>
</html>
