<?php
include("../connection/Connection.php");

if (isset($_GET['meeting_id'])) {
    $meeting_id = intval($_GET['meeting_id']);
    
    $query = "SELECT * FROM meetings WHERE MeetingID = ?";
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
            <span class="logo-text">SK Lamacan - Edit Meeting Minutes</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminMeetings.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>  

    <div class="form-container">
        <h1>Edit Meeting Minutes</h1>

        <form id="edit-meeting-form" method="POST">
            <input type="hidden" id="meeting_id" name="meeting_id" value="<?php echo htmlspecialchars($meeting['MeetingID']); ?>" required>

            <label for="meeting_title">Meeting Title:</label>
            <input type="text" id="meeting_title" name="meeting_title" value="<?php echo htmlspecialchars($meeting['Title']); ?>" required>

            <label for="date_of_meeting">Date of Meeting:</label>
            <input type="date" id="date_of_meeting" name="date_of_meeting" value="<?php echo htmlspecialchars($meeting['DateOfMeeting']); ?>" required>

            <label for="agenda">Agenda:</label>
            <textarea id="agenda" name="agenda" rows="10" required><?php echo htmlspecialchars($meeting['Agenda']); ?></textarea>

            <button type="submit">Update Meeting</button>
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
                    const formData = $(this).serialize();
                    $.post('../connection/EditMeetingConnection.php', formData, function(response) {
                        Swal.fire(response.message).then(() => {
                            if (response.status === 'success') {
                                window.location.href = '../admin/AdminMeetings.php';
                            }
                        });
                    }, 'json');
                }
            });
        });
    </script>

</body>
</html>
