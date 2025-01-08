<?php
include("../connection/Connection.php");

header('Content-Type: application/json');

if (isset($_POST['meeting_id'])) {
    $meeting_id = intval($_POST['meeting_id']);
    
    // Prepare all the fields
    $meeting_title = mysqli_real_escape_string($conn, $_POST['meeting_title']);
    $date_of_meeting = mysqli_real_escape_string($conn, $_POST['date_of_meeting']);
    $call_to_order = mysqli_real_escape_string($conn, $_POST['call_to_order']);
    $invocation = mysqli_real_escape_string($conn, $_POST['invocation']);
    $roll_call = mysqli_real_escape_string($conn, $_POST['roll_call']);
    $reading_minutes = mysqli_real_escape_string($conn, $_POST['reading_minutes']);
    $agenda = mysqli_real_escape_string($conn, $_POST['agenda']);
    $calendar_of_business = mysqli_real_escape_string($conn, $_POST['calendar_of_business']);
    $adjournment = mysqli_real_escape_string($conn, $_POST['adjournment']);
    $prepared_by_name = mysqli_real_escape_string($conn, $_POST['prepared_by_name']);
    $prepared_by_position = mysqli_real_escape_string($conn, $_POST['prepared_by_position']);
    $attested_by_name = mysqli_real_escape_string($conn, $_POST['attested_by_name']);
    $attested_by_position = mysqli_real_escape_string($conn, $_POST['attested_by_position']);

    $update_query = "UPDATE meetings SET 
        meeting_title = ?, 
        date_of_meeting = ?, 
        call_to_order = ?,
        invocation = ?,
        roll_call = ?,
        reading_minutes = ?,
        agenda = ?,
        calendar_of_business = ?,
        adjournment = ?,
        prepared_by_name = ?,
        prepared_by_position = ?,
        attested_by_name = ?,
        attested_by_position = ?
        WHERE id = ?";

    $stmt = $conn->prepare($update_query);
    
    if ($stmt) {
        $stmt->bind_param("sssssssssssssi", 
            $meeting_title, 
            $date_of_meeting, 
            $call_to_order,
            $invocation,
            $roll_call,
            $reading_minutes,
            $agenda,
            $calendar_of_business,
            $adjournment,
            $prepared_by_name,
            $prepared_by_position,
            $attested_by_name,
            $attested_by_position,
            $meeting_id
        );

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Meeting updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute update: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare update statement: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Meeting ID not provided']);
}

mysqli_close($conn);
