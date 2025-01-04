<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Programs & Activities</title>
    <link rel="stylesheet" href="../css/PostPA.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Post Programs and Activities</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminPA.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="container">
        <h1>Post Programs & Activities</h1>


        <form id="programForm" action="PostPA.php" method="POST">
            <label for="title">Program Title</label>
            <input type="text" id="title" name="title" required>

            <label for="total_participants">Total Participants</label>
            <input type="number" id="total_participants" name="total_participants" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="10" required></textarea>

            <button type="button" class="submit-btn" onclick="confirmPost()">POST PROGRAM</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include("../connection/Connection.php");

        $title = $_POST['title'];
        $total_participants = $_POST['total_participants'];
        $description = $_POST['description'];


        $query = "INSERT INTO programs_and_activities (Title, Date, Total_Participants, Description) 
                  VALUES (?, NOW(), ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sis", $title, $total_participants, $description);

        if ($stmt->execute()) {
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Program added successfully!",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = "../admin/AdminPA.php";  // Redirect on success
                    });
                  </script>';
        } else {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Failed to add program.",
                        text: "' . htmlspecialchars($stmt->error) . '",
                        confirmButtonText: "Try Again"
                    });
                  </script>';
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <script>

        function confirmPost() {
            Swal.fire({
                title: "Are you sure you want to post this program?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, post it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("programForm").submit();  
                }
            });
        }
    </script>
</body>
</html>
