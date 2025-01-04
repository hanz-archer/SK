<?php

include("../connection/Connection.php");

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form_type']) && isset($_POST['title'])) {
        $formType = $_POST['form_type'];
        $title = $_POST['title'];

        $formType = mysqli_real_escape_string($conn, $formType);
        $title = mysqli_real_escape_string($conn, $title);

        $dateTime = date('Y-m-d H:i:s');

        $insert_query = "INSERT INTO suggestion_and_feedback (Title, FormType, DateTime) VALUES ('$title', '$formType', '$dateTime')";

        if (mysqli_query($conn, $insert_query)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incomplete input']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>
