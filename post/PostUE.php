<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Upcoming Event</title>
    <link rel="stylesheet" href="../css/PostUE.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - Post Upcoming Event</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminUE.php" class="nav-item">Back</a>
            <a href="../admin/AdminHP.php" class="nav-item">Home</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Post New Upcoming Event</h1>

        <form id="event-form" method="POST">
            <label for="event_title">Event Title:</label>
            <input type="text" id="event_title" name="event_title" placeholder="Enter event title" required>

            <label for="event_date">Date of Event:</label>
            <input type="date" id="event_date" name="event_date" required>

            <label for="event_venue">Venue:</label>
            <input type="text" id="event_venue" name="event_venue" placeholder="Enter event venue" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="10" placeholder="Enter description for the event" required></textarea>

            <button type="submit" name="post_event">Post Event</button>
        </form>
    </div>

    <script>
        $('#event-form').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Do you want to post this event?",
                showDenyButton: true,
                confirmButtonText: "Post",
                denyButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = $(this).serialize();

                    $.ajax({
                        url: '../connection/PostUEConnection.php',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire("Posted!", "Event has been posted successfully!", "success")
                                .then(() => {
                                    window.location.href = '../admin/AdminUE.php';
                                });
                            } else {
                                Swal.fire("Error", response.message || "Failed to post the event. Please try again.", "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Error", "An unexpected error occurred. Please try again.", "error");
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Post cancelled", "", "info");
                }
            });
        });
    </script>

</body>
</html>
