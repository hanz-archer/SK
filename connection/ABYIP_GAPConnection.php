<?php
include("../connection/Connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve POST data
    $calendar_year = mysqli_real_escape_string($conn, $_POST['calendar_year']);
    $reference_code = mysqli_real_escape_string($conn, $_POST['reference_code']);
    $ppas = mysqli_real_escape_string($conn, $_POST['ppas']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $expected_result = mysqli_real_escape_string($conn, $_POST['expected_result']);
    $performance_indicator = mysqli_real_escape_string($conn, $_POST['performance_indicator']);
    $period_of_implementation = mysqli_real_escape_string($conn, $_POST['period_of_implementation']);
    $mooe = mysqli_real_escape_string($conn, $_POST['mooe']);
    $co = mysqli_real_escape_string($conn, $_POST['co']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);
    $person_responsible = mysqli_real_escape_string($conn, $_POST['person_responsible']);
    $prepared_by_name = mysqli_real_escape_string($conn, $_POST['prepared_by_name']);
    $prepared_by_position = mysqli_real_escape_string($conn, $_POST['prepared_by_position']);
    $approved_by_name = mysqli_real_escape_string($conn, $_POST['approved_by_name']);
    $approved_by_position = mysqli_real_escape_string($conn, $_POST['approved_by_position']);

    // SQL Insert query
    $sql = "INSERT INTO abyip_gap (
        calendar_year, reference_code, ppas, description, expected_result, 
        performance_indicator, period_of_implementation, mooe, co, total, 
        person_responsible, prepared_by_name, prepared_by_position, 
        approved_by_name, approved_by_position
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssdddsssss", 
        $calendar_year, $reference_code, $ppas, $description, $expected_result,
        $performance_indicator, $period_of_implementation, $mooe, $co, $total,
        $person_responsible, $prepared_by_name, $prepared_by_position,
        $approved_by_name, $approved_by_position
    );

    if ($stmt->execute()) {
        // Generate PDF URL
        $pdf_url = "../connection/pdf_abyip_general.php?table=abyip_gap&year=" . urlencode($calendar_year) . "&month=" . urlencode($period_of_implementation);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Investment plan submitted successfully!',
            'pdf_url' => $pdf_url
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error submitting the investment plan: ' . $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();
}
?>
