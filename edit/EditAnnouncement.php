<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement</title>
    <link rel="stylesheet" href="../css/PostAnnouncement.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header>
        <div class="logo">
            <a href="../html/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - Edit Announcement</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminAnnouncement.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="form-container">
        <center><h1>Edit Announcement</h1></center>
    
        <form id="announcement-form" method="POST">
            <?php

                include("../connection/Connection.php");


                if (isset($_GET['id'])) {
                    $announcement_id = intval($_GET['id']);


                    $sql = "SELECT Title, Description FROM announcements WHERE AnnouncementID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $announcement_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $title = htmlspecialchars($row['Title']);
                        $description = htmlspecialchars($row['Description']);
                    } else {
                        echo "<p>Announcement not found.</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p>Invalid Announcement ID.</p>";
                }
                $conn->close();
            ?>

            <label for="title">Announcement Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $title ?? ''; ?>" placeholder="Enter announcement title" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" placeholder="Enter announcement details here..." required><?php echo $description ?? ''; ?></textarea>

            <input type="hidden" name="announcement_id" value="<?php echo $announcement_id; ?>">
            <button type="submit">UPDATE ANNOUNCEMENT</button>
        </form>
    </div>

    <script>
    $('#announcement-form').on('submit', function(e) {
        e.preventDefault();

        if (!$('#title').val() || !$('#description').val()) {
            Swal.fire("Please fill all the fields completely");
            return;
        }

        Swal.fire({
            title: "Do you want to update the announcement?",
            showDenyButton: true,
            confirmButtonText: "Save",
            denyButtonText: "Don't save"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../connection/EditAnnouncementConnection.php', 
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire("Updated!", "Announcement updated successfully!", "success")
                            .then(() => {
                                window.location.href = '../admin/AdminAnnouncement.php';
                            });
                        } else {
                            Swal.fire("Error", "Failed to update the announcement. Please try again.", "error");
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Update cancelled", "", "info");
            }
        });
    });
    </script>

</body>
</html>
