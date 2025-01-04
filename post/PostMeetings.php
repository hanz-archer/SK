<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Meeting Minutes</title>
    <link rel="stylesheet" href="../css/PostMeeting.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Post Meeting Minutes</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminMeetings.php" class="nav-item">Back</a>
            <a href="../admin/AdminHP.php" class="nav-item">Home</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Post New Meeting Minutes</h1>

        <form id="meeting-form" method="POST">
            <!-- Basic Meeting Information -->
            <label for="meeting_title">Meeting Title:</label>
            <input type="text" id="meeting_title" name="meeting_title" required>

            <label for="date_of_meeting">Date of Meeting:</label>
            <input type="date" id="date_of_meeting" name="date_of_meeting" required>

            <!-- Attendees Section -->
            <h3>Attendees</h3>
            <label for="num_present">Number of Present:</label>
            <input type="number" id="num_present" name="num_present" min="0" required>

            <div id="present-attendees">
                <!-- Present attendees fields will be added here -->
            </div>

            <label for="num_also_present">Number of Also Present:</label>
            <input type="number" id="num_also_present" name="num_also_present" min="0" required>

            <div id="also-present-attendees">
                <!-- Also present attendees fields will be added here -->
            </div>

            <label for="num_absent">Number of Absent:</label>
            <input type="number" id="num_absent" name="num_absent" min="0" required>

            <div id="absent-attendees">
                <!-- Absent attendees fields will be added here -->
            </div>

            <!-- Meeting Details -->
            <label for="call_to_order">Call to Order:</label>
            <textarea id="call_to_order" name="call_to_order"></textarea>

            <label for="invocation">Invocation:</label>
            <textarea id="invocation" name="invocation"></textarea>

            <label for="roll_call">Roll Call:</label>
            <textarea id="roll_call" name="roll_call"></textarea>

            <label for="reading_minutes">Reading Minutes:</label>
            <textarea id="reading_minutes" name="reading_minutes"></textarea>

            <label for="agenda">Agenda:</label>
            <textarea id="agenda" name="agenda"></textarea>

            <label for="calendar_of_business">Calendar of Business:</label>
            <textarea id="calendar_of_business" name="calendar_of_business"></textarea>

            <label for="adjournment">Adjournment:</label>
            <textarea id="adjournment" name="adjournment"></textarea>

            <!-- Signatures -->
            <label for="prepared_by_name">Prepared By (Name):</label>
            <input type="text" id="prepared_by_name" name="prepared_by_name" required>

            <label for="prepared_by_position">Prepared By (Position):</label>
            <select id="prepared_by_position" name="prepared_by_position" required>
                <option value="">Select Position</option>
                <option value="Chairperson">SK Chairperson</option>
                <option value="Councilor">SK Councilor</option>
                <option value="Secretary">SK Secretary</option>
                <option value="Treasurer">SK Treasurer</option>
            </select>

            <label for="attested_by_name">Attested By (Name):</label>
            <input type="text" id="attested_by_name" name="attested_by_name" required>

            <label for="attested_by_position">Attested By (Position):</label>
            <select id="attested_by_position" name="attested_by_position" required>
                <option value="">Select Position</option>
                <option value="Chairperson">SK Chairperson</option>
                <option value="Councilor">SK Councilor</option>
                <option value="Secretary">SK Secretary</option>
                <option value="Treasurer">SK Treasurer</option>
            </select>

            <center><button type="submit">Submit</button></center>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            function createAttendeeFields(num, prefix) {
                let fieldsHTML = '';
                for (let i = 1; i <= num; i++) {
                    fieldsHTML += `
                        <div class="attendee">
                            <label for="${prefix}_name_${i}">Name ${i}:</label>
                            <input type="text" id="${prefix}_name_${i}" name="${prefix}_name_${i}" required>

                            <label for="${prefix}_position_${i}">Position:</label>
                            <select id="${prefix}_position_${i}" name="${prefix}_position_${i}" required>
                                <option value="">Select Position</option>
                                <option value="SK Chairperson">SK Chairperson</option>
                                <option value="SK Councilor">SK Councilor</option>
                                <option value="SK Secretary">SK Secretary</option>
                                <option value="SK Treasurer">SK Treasurer</option>
                            </select>
                        </div>
                    `;
                }
                return fieldsHTML;
            }

            // When the number of presents changes
            $('#num_present').on('input', function() {
                let num = $(this).val();
                $('#present-attendees').html(createAttendeeFields(num, 'present'));
            });

            // When the number of also presents changes
            $('#num_also_present').on('input', function() {
                let num = $(this).val();
                $('#also-present-attendees').html(createAttendeeFields(num, 'also_present'));
            });

            // When the number of absents changes
            $('#num_absent').on('input', function() {
                let num = $(this).val();
                $('#absent-attendees').html(createAttendeeFields(num, 'absent'));
            });

            $('#meeting-form').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirm Submission',
                    text: "Are you sure you want to submit this meeting minutes?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../connection/PostMeetingConnection.php',
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
        });
    </script>
</body>
</html>
