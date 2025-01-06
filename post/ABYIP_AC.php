<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annual Barangay Youth Investment Plan</title>
    <link rel="stylesheet" href="../css/ABYIP.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Post ABYIP Active Citizenship</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">Home</a>
            <a href="../admin/AdminPA.php" class="nav-item">Back</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>ABYIP - Active Citizenship</h1>

        <form id="investment-plan-form" method="POST">

            <label for="calendar_year">Calendar Year:</label>
            <input type="number" id="calendar_year" name="calendar_year" class="calendar_year" min="2000" max="2100" required>

            <label for="reference_code">Reference Code:</label>
            <input type="text" id="reference_code" name="reference_code">

            <label for="ppas">PPAs:</label>
            <input type="text" id="ppas" name="ppas" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="expected_result">Expected Result:</label>
            <textarea id="expected_result" name="expected_result" required></textarea>

            <label for="performance_indicator">Performance Indicator:</label>
            <textarea id="performance_indicator" name="performance_indicator" required></textarea>

            <label for="period_of_implementation">Period of Implementation:</label>
            <select id="period_of_implementation" name="period_of_implementation" required>
                <option value="">Select Month</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>

            <label for="mooe">MOOE:</label>
            <input type="number" id="mooe" name="mooe" class="mooe" required>

            <label for="co">CO:</label>
            <input type="number" id="co" name="co" class="co" required>

            <label for="total">Total:</label>
            <input type="number" id="total" name="total" class="total" required>

            <label for="person_responsible">Person Responsible:</label>
            <input type="text" id="person_responsible" name="person_responsible" required>

            <label for="prepared_by_name">Prepared By (Name):</label>
            <input type="text" id="prepared_by_name" name="prepared_by_name" required pattern="^[A-Z ]+$" title="Name must be capitalized">

            <label for="prepared_by_position">Prepared By (Position):</label>
            <select id="prepared_by_position" name="prepared_by_position" required>
                <option value="">Select Position</option>
                <option value="Chairperson">SK Chairperson</option>
                <option value="Councilor">SK Councilor</option>
                <option value="Secretary">SK Secretary</option>
                <option value="Treasurer">SK Treasurer</option>
            </select>

            <label for="approved_by_name">Approved By (Name):</label>
            <input type="text" id="approved_by_name" name="approved_by_name" required pattern="^[A-Z ]+$" title="Name must be capitalized">

            <label for="approved_by_position">Approved By (Position):</label>
            <select id="approved_by_position" name="approved_by_position" required>
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
            // Add input event listeners to MOOE and CO fields
            $('#mooe, #co').on('input', function() {
                calculateTotal();
            });

            function calculateTotal() {
                const mooe = parseFloat($('#mooe').val()) || 0;
                const co = parseFloat($('#co').val()) || 0;
                const total = mooe + co;
                $('#total').val(total);
            }

            // Existing form submission code...
            $('#investment-plan-form').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirm Submission',
                    text: "Are you sure you want to submit?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../connection/ABYIP_ACConnection.php',
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                        showCancelButton: true,
                                        confirmButtonText: 'Download PDF',
                                        cancelButtonText: 'Close'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Open PDF in new window
                                            window.open(response.pdf_url, '_blank');
                                        }
                                        // Redirect after a short delay
                                        setTimeout(() => {
                                            window.location.href = '../admin/AdminPA.php';
                                        }, 1000);
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
