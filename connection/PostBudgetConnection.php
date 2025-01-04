<?php
include("../connection/Connection.php");

header('Content-Type: application/json'); 

if (isset($_POST['title']) && isset($_POST['total_budget']) && isset($_POST['description'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $total_budget = mysqli_real_escape_string($conn, $_POST['total_budget']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $current_date = date('Y-m-d');


    $insert_query = "INSERT INTO budget (Title, Date, Total_Budget, Description) VALUES ('$title', '$current_date', '$total_budget', '$description')";

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
