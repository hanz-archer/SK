<?php
include("../connection/Connection.php");

if (isset($_GET['id'])) {
    $programID = $_GET['id'];
    $query = "SELECT * FROM programs_and_activities WHERE PA_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $programID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $program = $result->fetch_assoc();
    } else {
        echo '<script>alert("Program not found."); window.location.href = "AdminPA.php";</script>';
        exit;
    }
    $stmt->close();
} else {
    echo '<script>alert("No program ID provided."); window.location.href = "AdminPA.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Programs & Activities</title>
    <link rel="stylesheet" href="../css/PostPA.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - Edit Programs and Activities</span>
        </div>
        <nav class="nav-links">
             <a href="../admin/AdminPA.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="container">
        <h1>Edit Program & Activity</h1>

        <form id="programForm">
            <label for="title">Program Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($program['Title']); ?>" required>

            <label for="total_participants">Total Participants</label>
            <input type="number" id="total_participants" name="total_participants" value="<?php echo htmlspecialchars($program['Total_Participants']); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($program['Description']); ?></textarea>

            <input type="hidden" name="program_id" value="<?php echo $programID; ?>">
            <button type="submit" class="submit-btn">Update Program</button>
        </form>
    </div>

    <script>
    $('#programForm').on('submit', function(e) {
        e.preventDefault();

        if (!$('#title').val() || !$('#description').val()) {
            Swal.fire("Please fill all the fields completely");
            return;
        }

        Swal.fire({
            title: "Do you want to update the program?",
            showDenyButton: true,
            confirmButtonText: "Save",
            denyButtonText: "Don't save"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../connection/EditPAConnection.php', 
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire("Updated!", "Program updated successfully!", "success")
                            .then(() => {
                                window.location.href = '../admin/AdminPA.php';
                            });
                        } else {
                            Swal.fire("Error", response.message, "error");
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
