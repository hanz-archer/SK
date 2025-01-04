<?php
include("../connection/Connection.php");

if (isset($_GET['UE_ID'])) {
    $UE_ID = $_GET['UE_ID'];

    $query = "SELECT * FROM upcoming_events WHERE UE_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $UE_ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();

        $event_title = $event['Title'];
        $event_date = $event['Date_of_Event'];
        $event_venue = $event['Venue'];
        $description = $event['Description'];
    } else {
        echo '<script>alert("Event not found."); window.location.href = "../admin/AdminUE.php";</script>';
        exit;
    }

    $stmt->close();
} else {
    echo '<script>alert("No event ID provided."); window.location.href = "../admin/AdminUE.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Upcoming Event</title>
    <link rel="stylesheet" href="../css/EditUE.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - Edit Upcoming Event</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminUE.php" class="nav-item">Back</a>
            <a href="../admin/AdminHP.php" class="nav-item">Home</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Edit Event</h1>

        <form id="event-form" method="POST">
            <input type="hidden" id="UE_ID" name="UE_ID" value="<?php echo $UE_ID; ?>">
            <label for="event_title">Event Title:</label>
            <input type="text" id="event_title" name="event_title" placeholder="Enter event title" value="<?php echo htmlspecialchars($event_title); ?>" required>

            <label for="event_date">Date of Event:</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo htmlspecialchars($event_date); ?>" required>

            <label for="event_venue">Venue:</label>
            <input type="text" id="event_venue" name="event_venue" placeholder="Enter event venue" value="<?php echo htmlspecialchars($event_venue); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="10" placeholder="Enter description for the event" required><?php echo htmlspecialchars($description); ?></textarea>

            <button type="submit" name="update_event">Update Event</button>
        </form>
    </div>

    <script>
        $('#event-form').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Do you want to update this event?",
                showDenyButton: true,
                confirmButtonText: "Update",
                denyButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = $(this).serialize();

                    $.ajax({
                        url: '../connection/EditUEConnection.php',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire("Updated!", "Event has been updated successfully!", "success")
                                .then(() => {
                                    window.location.href = '../admin/AdminUE.php';
                                });
                            } else {
                                Swal.fire("Error", response.message || "Failed to update the event. Please try again.", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error", "An unexpected error occurred. Please try again.", "error");
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Update cancelled", "", "info");
                }
            });
        });
    </script>

</body>
</html>
