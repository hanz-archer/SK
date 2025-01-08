<?php
include("../connection/Connection.php");

if (isset($_GET['meeting_id'])) {
    $meeting_id = intval($_GET['meeting_id']);
    
    $query = "SELECT * FROM meetings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $meeting_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $meeting = $result->fetch_assoc();
    } else {
        echo "Meeting not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Helper function to safely get meeting data
function getMeetingValue($meeting, $key, $default = '') {
    return isset($meeting[$key]) ? htmlspecialchars($meeting[$key]) : $default;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Meeting Minutes</title>
    <link rel="stylesheet" href="../css/EditMeeting.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Edit Meeting Minutes</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminMeetings.php" class="nav-item">Back</a>
            <a href="../admin/AdminHP.php" class="nav-item">Home</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Edit Meeting Minutes</h1>

        <form id="edit-meeting-form" method="POST">
            <input type="hidden" id="meeting_id" name="meeting_id" value="<?php echo getMeetingValue($meeting, 'id'); ?>" required>

            <!-- Basic Meeting Information -->
            <label for="meeting_title">Meeting Title:</label>
            <input type="text" id="meeting_title" name="meeting_title" 
                   value="<?php echo getMeetingValue($meeting, 'meeting_title'); ?>" required>

            <label for="date_of_meeting">Date of Meeting:</label>
            <input type="date" id="date_of_meeting" name="date_of_meeting" 
                   value="<?php echo getMeetingValue($meeting, 'date_of_meeting'); ?>" required>

            <!-- Meeting Details -->
            <label for="call_to_order">Call to Order:</label>
            <textarea id="call_to_order" name="call_to_order"><?php echo getMeetingValue($meeting, 'call_to_order'); ?></textarea>

            <label for="invocation">Invocation:</label>
            <textarea id="invocation" name="invocation"><?php echo getMeetingValue($meeting, 'invocation'); ?></textarea>

            <label for="roll_call">Roll Call:</label>
            <textarea id="roll_call" name="roll_call"><?php echo getMeetingValue($meeting, 'roll_call'); ?></textarea>

            <label for="reading_minutes">Reading Minutes:</label>
            <textarea id="reading_minutes" name="reading_minutes"><?php echo getMeetingValue($meeting, 'reading_minutes'); ?></textarea>

            <label for="agenda">Agenda:</label>
            <textarea id="agenda" name="agenda"><?php echo getMeetingValue($meeting, 'agenda'); ?></textarea>

            <label for="calendar_of_business">Calendar of Business:</label>
            <textarea id="calendar_of_business" name="calendar_of_business"><?php echo getMeetingValue($meeting, 'calendar_of_business'); ?></textarea>

            <label for="adjournment">Adjournment:</label>
            <textarea id="adjournment" name="adjournment"><?php echo getMeetingValue($meeting, 'adjournment'); ?></textarea>

            <!-- Signatures -->
            <label for="prepared_by_name">Prepared By (Name):</label>
            <input type="text" id="prepared_by_name" name="prepared_by_name" 
                   value="<?php echo getMeetingValue($meeting, 'prepared_by_name'); ?>" required>

            <label for="prepared_by_position">Prepared By (Position):</label>
            <select id="prepared_by_position" name="prepared_by_position" required>
                <option value="">Select Position</option>
                <option value="Chairperson" <?php echo (getMeetingValue($meeting, 'prepared_by_position') == 'Chairperson') ? 'selected' : ''; ?>>SK Chairperson</option>
                <option value="Councilor" <?php echo (getMeetingValue($meeting, 'prepared_by_position') == 'Councilor') ? 'selected' : ''; ?>>SK Councilor</option>
                <option value="Secretary" <?php echo (getMeetingValue($meeting, 'prepared_by_position') == 'Secretary') ? 'selected' : ''; ?>>SK Secretary</option>
                <option value="Treasurer" <?php echo (getMeetingValue($meeting, 'prepared_by_position') == 'Treasurer') ? 'selected' : ''; ?>>SK Treasurer</option>
            </select>

            <label for="attested_by_name">Attested By (Name):</label>
            <input type="text" id="attested_by_name" name="attested_by_name" 
                   value="<?php echo getMeetingValue($meeting, 'attested_by_name'); ?>" required>

            <label for="attested_by_position">Attested By (Position):</label>
            <select id="attested_by_position" name="attested_by_position" required>
                <option value="">Select Position</option>
                <option value="Chairperson" <?php echo (getMeetingValue($meeting, 'attested_by_position') == 'Chairperson') ? 'selected' : ''; ?>>SK Chairperson</option>
                <option value="Councilor" <?php echo (getMeetingValue($meeting, 'attested_by_position') == 'Councilor') ? 'selected' : ''; ?>>SK Councilor</option>
                <option value="Secretary" <?php echo (getMeetingValue($meeting, 'attested_by_position') == 'Secretary') ? 'selected' : ''; ?>>SK Secretary</option>
                <option value="Treasurer" <?php echo (getMeetingValue($meeting, 'attested_by_position') == 'Treasurer') ? 'selected' : ''; ?>>SK Treasurer</option>
            </select>

            <center><button type="submit">Update Meeting</button></center>
        </form>
    </div>

    <script>
        $('#edit-meeting-form').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Confirm Update',
                text: "Are you sure you want to update this meeting?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../connection/EditMeetingConnection.php',
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if(response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message
                                }).then(() => {
                                    window.location.href = '../admin/AdminMeetings.php';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong. Please try again.'
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
