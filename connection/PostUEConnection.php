<?php 
include("../connection/Connection.php");

header('Content-Type: application/json');

if (isset($_POST['event_title']) && isset($_POST['event_date']) && isset($_POST['event_venue']) && isset($_POST['description'])) {

    $title = mysqli_real_escape_string($conn, $_POST['event_title']);
    $date_of_event = mysqli_real_escape_string($conn, $_POST['event_date']);
    $venue = mysqli_real_escape_string($conn, $_POST['event_venue']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $insert_query = "
        INSERT INTO upcoming_events (Title, Date_of_Event, DatePosted, Venue, Description) 
        VALUES ('$title', '$date_of_event', NOW(), '$venue', '$description')
    ";

    if (mysqli_query($conn, $insert_query)) {
        echo json_encode(['status' => 'success', 'message' => 'Event posted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete input']);
}

mysqli_close($conn);    
?>
