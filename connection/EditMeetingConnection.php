<?php
include("../connection/Connection.php");

header('Content-Type: application/json');

if (isset($_POST['meeting_id'], $_POST['meeting_title'], $_POST['date_of_meeting'], $_POST['agenda'])) {

    $meeting_id = intval($_POST['meeting_id']);
    $title = mysqli_real_escape_string($conn, $_POST['meeting_title']);
    $date_of_meeting = mysqli_real_escape_string($conn, $_POST['date_of_meeting']);
    $agenda = mysqli_real_escape_string($conn, $_POST['agenda']);


    $update_query = "UPDATE meetings SET Title = ?, DateOfMeeting = ?, Agenda = ? WHERE MeetingID = ?";
    $stmt = $conn->prepare($update_query);
    
    if ($stmt) {
        $stmt->bind_param("sssi", $title, $date_of_meeting, $agenda, $meeting_id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Meeting updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute update']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare update statement']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete input']);
}

mysqli_close($conn);
