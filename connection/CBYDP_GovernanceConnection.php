<?php
include("Connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
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
        $sql = "INSERT INTO cbydp_pa_governance (
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

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            if (!$stmt->bind_param("sssssssdsssss", 
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
            )) {
                throw new Exception("Binding parameters failed: " . $stmt->error);
            }

            // Execute query
            if (!$stmt->execute()) {
                throw new Exception("Execution failed: " . $stmt->error);
            }

            $response = array(
                'status' => 'success',
                'message' => 'Record added successfully!'
            );

            $stmt->close();
        } else {
            throw new Exception("Prepare failed: " . $conn->error);
        }
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage(),
            'debug' => array(
                'received_data' => $_POST
            )
        );
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close connection
$conn->close();
?> 