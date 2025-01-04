<?php
include("../connection/Connection.php");

header('Content-Type: application/json');


if (isset($_POST['UE_ID'], $_POST['event_title'], $_POST['event_date'], $_POST['event_venue'], $_POST['description'])) {

    $UE_ID = mysqli_real_escape_string($conn, $_POST['UE_ID']);
    $title = mysqli_real_escape_string($conn, $_POST['event_title']);
    $date_of_event = mysqli_real_escape_string($conn, $_POST['event_date']);
    $venue = mysqli_real_escape_string($conn, $_POST['event_venue']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);


    $update_query = "
        UPDATE upcoming_events 
        SET Title = '$title', Date_of_Event = '$date_of_event', Venue = '$venue', Description = '$description', DatePosted = NOW()
        WHERE UE_ID = $UE_ID
    ";

    if (mysqli_query($conn, $update_query)) {
        echo json_encode(['status' => 'success', 'message' => 'Event updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete input']);
}

mysqli_close($conn);
?>
