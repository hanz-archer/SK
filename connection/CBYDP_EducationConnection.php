<?php
include("../connection/Connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug information array
    $debug_info = [];
    
    // Log received POST data
    $debug_info['received_data'] = $_POST;
    
    try {
        // Initialize variables with default values and check which fields are missing
        $required_fields = [
            'calendar_year' => 'Calendar Year',
            'youth_development_concern' => 'Youth Development Concern',
            'objective' => 'Objective',
            'performance_indicator' => 'Performance Indicator',
            'target_2024' => 'Target 2024',
            'target_2025' => 'Target 2025',
            'target_2026' => 'Target 2026',
            'ppas' => 'PPAs',
            'budget' => 'Budget',
            'responsible_person' => 'Responsible Person',
            'prepared_by_name' => 'Prepared By Name',
            'prepared_by_position' => 'Prepared By Position',
            'approved_by_name' => 'Approved By Name',
            'approved_by_position' => 'Approved By Position'
        ];
        
        $missing_fields = [];
        $data = [];
        
        // Check for missing or empty fields
        foreach ($required_fields as $field => $label) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $missing_fields[] = $label;
            }
            $data[$field] = isset($_POST[$field]) ? mysqli_real_escape_string($conn, trim($_POST[$field])) : '';
        }
        
        // If there are missing fields, return detailed error
        if (!empty($missing_fields)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'The following fields are required: ' . implode(', ', $missing_fields),
                'debug' => [
                    'missing_fields' => $missing_fields,
                    'received_data' => array_keys($_POST)
                ]
            ]);
            exit;
        }

        // SQL Insert query
        $sql = "INSERT INTO cbydp_pa_education (
            calendar_year, youth_development_concern, objective, performance_indicator,
            target_2024, target_2025, target_2026, ppas, budget,
            responsible_person, prepared_by_name, prepared_by_position,
            approved_by_name, approved_by_position
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("isssssssdsssss", 
            $data['calendar_year'],
            $data['youth_development_concern'],
            $data['objective'],
            $data['performance_indicator'],
            $data['target_2024'],
            $data['target_2025'],
            $data['target_2026'],
            $data['ppas'],
            $data['budget'],
            $data['responsible_person'],
            $data['prepared_by_name'],
            $data['prepared_by_position'],
            $data['approved_by_name'],
            $data['approved_by_position']
        );

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        // Generate PDF URL
        $pdf_url = "../connection/pdf_education.php?table=cbydp_pa_education&year=" . urlencode($data['calendar_year']);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Investment plan submitted successfully!',
            'pdf_url' => $pdf_url
        ]);

        $stmt->close();
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage(),
            'debug' => $debug_info
        ]);
    } finally {
        $conn->close();
    }
    
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Please use POST.',
        'debug' => ['method' => $_SERVER['REQUEST_METHOD']]
    ]);
}
?>
