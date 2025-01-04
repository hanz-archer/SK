<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Awards and Certificates</title>
    <link rel="stylesheet" href="../css/PostAwards.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header>
        <div class="logo">
            <a href="./html/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Post Awards and Certificates</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminAwards.php" class="nav-item">Back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Post Awards & Certificates</h1>

        <form id="award-form" method="POST" enctype="multipart/form-data">
            <label for="award_title">Award Title:</label>
            <input type="text" id="award_title" name="award_title" placeholder="Enter award title" required>

            <label for="award_date">Date of Award:</label>
            <input type="date" id="award_date" name="award_date" required>

            <label for="award_image">Upload Certificate/Award Image:</label>
            <input type="file" id="award_image" name="award_image" accept="image/*" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" placeholder="Enter description for the award or certificate" required></textarea>

            <button type="submit" name="post_award">Post Award</button>
        </form>
    </div>

    <script>
        $('#award-form').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Do you want to post this award?",
                showDenyButton: true,
                confirmButtonText: "Post",
                denyButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(this);

                    $.ajax({
                        url: '../connection/PostAwardConnection.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire("Posted!", "Award has been posted successfully!", "success")
                                    .then(() => {
                                        window.location.href = '../admin/AdminAwards.php';
                                    });
                            } else {
                                Swal.fire("Error", response.message || "Failed to post the award. Please try again.", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error", "An unexpected error occurred. Please try again.", "error");
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
