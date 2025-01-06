<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprehensive Barangay Youth Development Plan - Governance</title>
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
            <span class="logo-text">SK Sumaguan - Post CBYDP Governance</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">Home</a>
            <a href="../admin/AdminPA.php" class="nav-item">Back</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>CBYDP - Governance</h1>

        <form id="investment-plan-form" method="POST">
        <label for="calendar_year">Calendar Year:</label>
        <input type="number" id="calendar_year" name="calendar_year" class="calendar_year" min="2000" max="2100" required>            <label for="youth_development_concern">Youth Development Concern:</label>
            <textarea id="youth_development_concern" name="youth_development_concern" required></textarea>

            <label for="objective">Objective:</label>
            <textarea id="objective" name="objective" required></textarea>

            <label for="performance_indicator">Performance Indicator:</label>
            <textarea id="performance_indicator" name="performance_indicator" required></textarea>

            <label>Target:</label>
            <div class="target-inputs">
                <div>
                    <label for="target_2024">2024:</label>
                    <input type="text" id="target_2024" name="target_2024" required>
                </div>
                <div>
                    <label for="target_2025">2025:</label>
                    <input type="text" id="target_2025" name="target_2025" required>
                </div>
                <div>
                    <label for="target_2026">2026:</label>
                    <input type="text" id="target_2026" name="target_2026" required>
                </div>
            </div>

            <label for="ppas">PPAs:</label>
            <input type="text" id="ppas" name="ppas" required>

            <label for="budget">Budget:</label>
            <input type="number" id="budget" name="budget" required>

            <label for="responsible_person">Responsible Person:</label>
            <input type="text" id="responsible_person" name="responsible_person" required>

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
            $('#investment-plan-form').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: '../connection/CBYDP_GovernanceConnection.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Get parameters for PDF generation
                            const prepared_by_name = $('#prepared_by_name').val();
                            const prepared_by_position = $('#prepared_by_position').val();
                            const approved_by_name = $('#approved_by_name').val();
                            const approved_by_position = $('#approved_by_position').val();

                            // Construct PDF URL
                            const pdfUrl = '../connection/pdf_cbydp_governance.php?' + 
                                'year=' + encodeURIComponent(new Date().getFullYear()) +
                                '&prepared_by_name=' + encodeURIComponent(prepared_by_name) +
                                '&prepared_by_position=' + encodeURIComponent(prepared_by_position) +
                                '&approved_by_name=' + encodeURIComponent(approved_by_name) +
                                '&approved_by_position=' + encodeURIComponent(approved_by_position);

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showCancelButton: true,
                                confirmButtonText: 'Download PDF',
                                cancelButtonText: 'Close'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.open(pdfUrl, '_blank');
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                                footer: response.debug ? JSON.stringify(response.debug) : ''
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Something went wrong while submitting the form.';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMessage = response.message || errorMessage;
                        } catch (e) {
                            console.error('Error parsing response:', xhr.responseText);
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            footer: `Status: ${status}, Error: ${error}, Response: ${xhr.responseText}`,
                            didOpen: () => {
                                console.log('Full error details:', {
                                    status: status,
                                    error: error,
                                    response: xhr.responseText,
                                    xhr: xhr
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