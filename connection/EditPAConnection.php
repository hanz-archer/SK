<?php
include("../connection/Connection.php");

if (isset($_POST['title']) && isset($_POST['total_participants']) && isset($_POST['description']) && isset($_POST['program_id'])) {
    $programID = $_POST['program_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $total_participants = intval($_POST['total_participants']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update_query = "UPDATE programs_and_activities SET Title = ?, Total_Participants = ?, Description = ? WHERE PA_ID = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sisi", $title, $total_participants, $description, $programID);

    if ($stmt->execute()) {

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating program: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
