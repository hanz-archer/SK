<?php

require_once('../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get meeting details from POST request
    $meeting_title = $_POST['meeting_title'];
    $date_of_meeting = $_POST['date_of_meeting'];
    $call_to_order = $_POST['call_to_order'];
    $invocation = $_POST['invocation'];
    $roll_call = $_POST['roll_call'];
    $reading_minutes = $_POST['reading_minutes'];
    $agenda = $_POST['agenda'];
    $calendar_of_business = $_POST['calendar_of_business'];
    $adjournment = $_POST['adjournment'];
    $prepared_by_name = $_POST['prepared_by_name'];
    $prepared_by_position = $_POST['prepared_by_position'];
    $attested_by_name = $_POST['attested_by_name'];
    $attested_by_position = $_POST['attested_by_position'];

    // Insert the meeting data into the meetings table
    $sql = "INSERT INTO meetings 
            (meeting_title, date_of_meeting, call_to_order, invocation, roll_call, reading_minutes, agenda, calendar_of_business, adjournment, prepared_by_name, prepared_by_position, attested_by_name, attested_by_position) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $meeting_title, $date_of_meeting, $call_to_order, $invocation, $roll_call, $reading_minutes, $agenda, $calendar_of_business, $adjournment, $prepared_by_name, $prepared_by_position, $attested_by_name, $attested_by_position);
    $stmt->execute();

    // Get the last inserted meeting ID
    $meeting_id = $stmt->insert_id;

    // Insert Present Attendees
    $num_present = $_POST['num_present']; // Number of present attendees
    for ($i = 1; $i <= $num_present; $i++) {
        $present_name = $_POST['present_name_' . $i];
        $present_position = $_POST['present_position_' . $i];
        
        $sql = "INSERT INTO meeting_attendees (meeting_id, name, position, attendance_status) 
                VALUES (?, ?, ?, 'Present')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $meeting_id, $present_name, $present_position);
        $stmt->execute();
    }

    // Insert Also Present Attendees
    $num_also_present = $_POST['num_also_present']; // Number of also present attendees
    for ($i = 1; $i <= $num_also_present; $i++) {
        $also_present_name = $_POST['also_present_name_' . $i];
        $also_present_position = $_POST['also_present_position_' . $i];

        $sql = "INSERT INTO meeting_attendees (meeting_id, name, position, attendance_status) 
                VALUES (?, ?, ?, 'Also Present')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $meeting_id, $also_present_name, $also_present_position);
        $stmt->execute();
    }

    // Insert Absent Attendees
    $num_absent = $_POST['num_absent']; // Number of absent attendees
    for ($i = 1; $i <= $num_absent; $i++) {
        $absent_name = $_POST['absent_name_' . $i];
        $absent_position = $_POST['absent_position_' . $i];

        $sql = "INSERT INTO meeting_attendees (meeting_id, name, position, attendance_status) 
                VALUES (?, ?, ?, 'Absent')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $meeting_id, $absent_name, $absent_position);
        $stmt->execute();
    }

    // Close the statement
    $stmt->close();

    // Return a response
    echo json_encode([
        'status' => 'success',
        'message' => 'Meeting minutes saved successfully.'
    ]);
} else {
    // If not a POST request, return an error
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
