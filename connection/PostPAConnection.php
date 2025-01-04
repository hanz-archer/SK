<?php
include("../connection/Connection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $total_participants = $_POST['total_participants'];
    $description = $_POST['description'];


    $query = "INSERT INTO programs_and_activities (Title, Date, Total_Participants, Description) 
              VALUES (?, NOW(), ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sis", $title, $total_participants, $description);

    if ($stmt->execute()) {

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Program added successfully!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = "../html/programs.php";
                });
              </script>';
    } else {

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Failed to add program.",
                    text: "' . htmlspecialchars($stmt->error) . '",
                    confirmButtonText: "Try Again"
                }).then(function() {
                    window.history.back();
                });
              </script>';
    }


    $stmt->close();
}

// Close the database connection
$conn->close();
?>
