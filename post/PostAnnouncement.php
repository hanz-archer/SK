<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Announcement</title>
    <link rel="stylesheet" href="../css/PostAnnouncement.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Post Announcements</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminAnnouncement.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>   

    <div class="form-container">
        <center><h1>Post New Announcement</h1></center>
        <br>
    
        <form id="announcement-form" method="POST">
            <label for="title">Announcement Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter announcement title" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="11" placeholder="Enter announcement details here..." required></textarea>

            <button type="submit">POST ANNOUNCEMENT</button>
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
            title: "Do you want to post the announcement?",
            showDenyButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
        }).then((result) => {
            if (result.isConfirmed) {
 
                $.ajax({
                    url: '../connection/PostAnnouncementConnection.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire("Saved!", "Announcement posted successfully!", "success")
                            .then(() => {
                                
                                window.location.href = '../admin/AdminAnnouncement.php';
                            });
                        } else {
                            Swal.fire("Error", "Failed to post the announcement. Please try again.", "error");
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Post cancelled", "", "info");
            }
        });
    });
</script>


</body>
</html>
