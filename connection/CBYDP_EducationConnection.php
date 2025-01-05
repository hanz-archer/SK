<?php
include("../connection/Connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $youth_development_concern = $_POST['youth_development_concern'];
    $objective = $_POST['objective'];
    $performance_indicator = $_POST['performance_indicator'];
    $target_2024 = $_POST['target_2024'];
    $target_2025 = $_POST['target_2025'];
    $target_2026 = $_POST['target_2026'];
    $ppas = $_POST['ppas'];
    $budget = $_POST['budget'];
    $responsible_person = $_POST['responsible_person'];
    $prepared_by_name = $_POST['prepared_by_name'];
    $prepared_by_position = $_POST['prepared_by_position'];
    $approved_by_name = $_POST['approved_by_name'];
    $approved_by_position = $_POST['approved_by_position'];

    // Prepare SQL statement
    $sql = "INSERT INTO cbydp_pa_health (
        youth_development_concern, 
        objective, 
        performance_indicator, 
        target_2024,
        target_2025,
        target_2026,
        ppas,
        budget,
        responsible_person,
        prepared_by_name,
        prepared_by_position,
        approved_by_name,
        approved_by_position
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssdsssss", 
        $youth_development_concern,
        $objective,
        $performance_indicator,
        $target_2024,
        $target_2025,
        $target_2026,
        $ppas,
        $budget,
        $responsible_person,
        $prepared_by_name,
        $prepared_by_position,
        $approved_by_name,
        $approved_by_position
    );

    // Execute query and check result
    if ($stmt->execute()) {
        $response = array(
            'status' => 'success',
            'message' => 'Record added successfully!'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error: ' . $stmt->error
        );
    }

    // Close statement
    $stmt->close();
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close connection
$conn->close();
?>
