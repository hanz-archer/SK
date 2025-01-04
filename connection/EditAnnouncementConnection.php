<?php
include("../connection/Connection.php");

if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['announcement_id'])) {
    $announcement_id = $_POST['announcement_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $update_query = "UPDATE announcements SET Title = ?, Description = ? WHERE AnnouncementID = ?";

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssi", $title, $description, $announcement_id);

    if ($stmt->execute()) {
 
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating announcement: ' . $conn->error]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
