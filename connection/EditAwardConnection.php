<?php
include("../connection/Connection.php");

header('Content-Type: application/json');

if (isset($_POST['award_id']) && isset($_POST['award_title']) && isset($_POST['award_date']) && isset($_POST['description'])) {

    $award_id = intval($_POST['award_id']);
    $title = mysqli_real_escape_string($conn, $_POST['award_title']);
    $date_awarded = mysqli_real_escape_string($conn, $_POST['award_date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update_query = "
        UPDATE awards 
        SET Title = '$title', DateAwarded = '$date_awarded', Description = '$description'
        WHERE AwardID = $award_id
    ";

    if (mysqli_query($conn, $update_query)) {
        echo json_encode(['status' => 'success', 'message' => 'Award updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete input']);
}

mysqli_close($conn);
?>
