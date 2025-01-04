<?php
include("../connection/Connection.php");

header('Content-Type: application/json');

if (isset($_POST['title']) && isset($_POST['description'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Replace \r\n, \n, and \r with spaces
    $description = str_replace(array("\r\n", "\n", "\r"), ' ', $description);

    // Insert sanitized data into the database
    $insert_query = "INSERT INTO announcements (Title, Date, Description) VALUES ('$title', NOW(), '$description')";

    if (mysqli_query($conn, $insert_query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete input']);
}

mysqli_close($conn);
?>
