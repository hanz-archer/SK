<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Announcements</title>
    <link rel="stylesheet" href="../css/Announcement.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Admin Announcements</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
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

                $sql = "SELECT AnnouncementID, Title, Date, Description FROM announcements ORDER BY Date DESC, AnnouncementID DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $description = str_replace(array("\r\n", "\n", "\r"), "<br>", htmlspecialchars($row["Description"]));
                        
                        echo '<div class="announcement-card">';
                        echo '<h2>' . htmlspecialchars($row["Title"]) . '</h2>';
                        echo '<p class="announcement-date">Posted: ' . date("F j, Y, g:i A", strtotime($row["Date"])) . '</p>';
                        echo '<p class="announcement-details">' . $description . '</p>';
                        echo '<div class="action-buttons">';
                        echo '<a href="../edit/EditAnnouncement.php?id=' . $row["AnnouncementID"] . '" class="edit-btn">Edit</a>';
                        echo '<button class="archive-btn" onclick="archiveAnnouncement(' . $row["AnnouncementID"] . ')">Archive</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No announcements available at the moment.</p>";
                }

                $conn->close();
            ?>
        </div>

        <div class="archive-button" onclick="window.location.href='../admin/ArchiveAnnouncements.php'">
            <img src="../images/archive_icon.png" alt="Archive Icon">
        </div>

        <div class="plus-button" onclick="toggleUploadMenu()">
            <a href="../post/PostAnnouncement.php">
                <img src="../images/plus_icon.png" alt="Plus Icon">
            </a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function archiveAnnouncement(id) {
        Swal.fire({
            title: 'Are you sure you want to archive this announcement?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, archive it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the PHP file that handles the archive process
                window.location.href = '../connection/ArchiveAnnouncementConnection.php?id=' + id;
            }
        });
    }
    </script>

</body>
</html>
