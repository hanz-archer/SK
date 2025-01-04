<?php
include("../connection/Connection.php"); // Adjust the path as necessary

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
    $sql = "INSERT INTO pa_education (
        calendar_year, reference_code, ppas, description, expected_result, 
        performance_indicator, period_of_implementation, mooe, co, total, 
        person_responsible, prepared_by_name, prepared_by_position, 
        approved_by_name, approved_by_position
    ) VALUES (
        '$calendar_year', '$reference_code', '$ppas', '$description', '$expected_result',
        '$performance_indicator', '$period_of_implementation', '$mooe', '$co', '$total',
        '$person_responsible', '$prepared_by_name', '$prepared_by_position', 
        '$approved_by_name', '$approved_by_position'
    )";

    // Execute the query and check for success
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Investment plan submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting the investment plan. Please try again.']);
        die(mysqli_error($conn));  
    }

    // Close the connection
    mysqli_close($conn);
}
?>
