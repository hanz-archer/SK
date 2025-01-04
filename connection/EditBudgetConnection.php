<?php
include("../connection/Connection.php");


if (isset($_POST['title'], $_POST['total_budget'], $_POST['budget_id'], $_POST['description'])) {

    $budget_id = $_POST['budget_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $total_budget = mysqli_real_escape_string($conn, $_POST['total_budget']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);


    $update_query = "UPDATE budget SET Title = ?, Total_Budget = ?, Description = ? WHERE Budget_ID = ?";
    
    $stmt = $conn->prepare($update_query);
    
    if ($stmt) {

        $stmt->bind_param("sssi", $title, $total_budget, $description, $budget_id);


        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating budget: ' . $stmt->error]);
        }


        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement: ' . $conn->error]);
    }


    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
