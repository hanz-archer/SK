<?php

include("../connection/Connection.php");


$award_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$award_query = "SELECT * FROM awards WHERE AwardID = $award_id";
$award_result = mysqli_query($conn, $award_query);
$award = mysqli_fetch_assoc($award_result);


mysqli_close($conn);


if (!$award) {
    echo "Award not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Award and Certificate</title>
    <link rel="stylesheet" href="../css/PostAwards.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header>
        <div class="logo">
            <a href="../html/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - Edit Awards and Certificates</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminAwards.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Edit Award & Certificate</h1>

        <form id="award-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="award_id" value="<?php echo htmlspecialchars($award['AwardID']); ?>">

            <label for="award_title">Award Title:</label>
            <input type="text" id="award_title" name="award_title" placeholder="Enter award title" value="<?php echo htmlspecialchars($award['Title']); ?>" required>

            <label for="award_date">Date of Award:</label>
            <input type="date" id="award_date" name="award_date" value="<?php echo htmlspecialchars($award['DateAwarded']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" placeholder="Enter description for the award or certificate" required><?php echo htmlspecialchars($award['Description']); ?></textarea>

            <button type="submit" name="update_award">Update Award</button>
        </form>
    </div>

    <script>

        $('#award-form').on('submit', function(e) {
            e.preventDefault(); 


            Swal.fire({
                title: "Do you want to update this award?",
                showDenyButton: true,
                confirmButtonText: "Update",
                denyButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData(this);


                    $.ajax({
                        url: '../connection/EditAwardConnection.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire("Updated!", "Award has been updated successfully!", "success")
                                .then(() => {

                                    window.location.href = '../admin/AdminAwards.php';
                                });
                            } else {
                                Swal.fire("Error", response.message || "Failed to update the award. Please try again.", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error", "An unexpected error occurred. Please try again.", "error");
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
