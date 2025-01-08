<?php
// Prevent any output before JSON response
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json');

try {
    include("Connection.php");

    if (!isset($_GET['type']) || !isset($_GET['category']) || !isset($_GET['year'])) {
        throw new Exception("Missing required parameters");
    }

    $type = $_GET['type'];
    $category = $_GET['category'];
    $year = $_GET['year'];

    // Create separate mappings for CBYDP and ABYIP
    $cbydpMapping = [
        'social_inclusion_and_equity' => 'social',
        'peace_building_and_security' => 'peace',
        'active_citizenship' => 'citizenship',
        'economic_empowerment' => 'economic',
        'sports_development' => 'sports',
        'general_administration' => 'general',
        'education' => 'education',
        'health' => 'health',
        'environment' => 'environment',
        'agriculture' => 'agriculture'
    ];

    $abyipMapping = [
        'social_inclusion_and_equity' => 'sie',
        'peace_building_and_security' => 'pbs',
        'active_citizenship' => 'ac',
        'economic_empowerment' => 'ee',
        'sports_development' => 'sports',
        'general_administration' => 'gap',
        'education' => 'education',
        'health' => 'health',
        'environment' => 'environment',
        'agriculture' => 'agriculture'
    ];

    // Use appropriate mapping based on type
    if ($type === 'cbydp') {
        $tableName = $cbydpMapping[$category] ?? $category;
    } else {
        $tableName = $abyipMapping[$category] ?? $category;
    }

    // Different table name format for CBYDP and ABYIP
    if ($type === 'cbydp') {
        $table = "cbydp_pa_{$tableName}";
    } else {
        $table = "abyip_{$tableName}";
    }

    error_log("Querying table: " . $table); // Debug log
    
    $sql = "SELECT prepared_by_name, prepared_by_position, approved_by_name, approved_by_position 
            FROM {$table} 
            WHERE calendar_year = ? 
            LIMIT 1";
            
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("i", $year);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute query: " . $stmt->error);
    }

    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'status' => 'success',
            'data' => $row
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => "No signatories found for year {$year} in table {$table}"
        ]);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    error_log("Error in get_signatories.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?> 