<?php
include("../connection/Connection.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['meeting_id'])) {
    $meeting_id = $_GET['meeting_id'];

    $query = "SELECT visibility FROM meetings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $meeting_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_visibility = $row['visibility'];

        $new_visibility = ($current_visibility == 1) ? 0 : 1;

        $update_query = "UPDATE meetings SET visibility = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $new_visibility, $meeting_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Meeting visibility updated successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update visibility. Please try again.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Meeting not found.'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No meeting ID provided.'
    ]);
}

$conn->close();
?>
