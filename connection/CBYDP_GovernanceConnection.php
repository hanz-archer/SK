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
        $calendar_year = isset($_POST['calendar_year']) ? $_POST['calendar_year'] : date('Y');

        // Prepare SQL statement
        $sql = "INSERT INTO cbydp_pa_governance (
            calendar_year,
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
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters - make sure the types match the number of parameters
            if (!$stmt->bind_param("isssssssdsssss", 
                $calendar_year,
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
            if ($stmt->execute()) {
                $pdf_url = "connection/pdf_cbydp_governance.php?year=" . urlencode($calendar_year) . 
                           "&prepared_by_name=" . urlencode($prepared_by_name) . 
                           "&prepared_by_position=" . urlencode($prepared_by_position) . 
                           "&approved_by_name=" . urlencode($approved_by_name) . 
                           "&approved_by_position=" . urlencode($approved_by_position);
                           
                error_log("Generated PDF URL: " . $pdf_url); // Debug log
                
                $response = array(
                    'status' => 'success',
                    'message' => 'Data saved successfully',
                    'pdf_url' => $pdf_url
                );
                echo json_encode($response);
                exit;
            } else {
                throw new Exception("Execution failed: " . $stmt->error);
            }

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
