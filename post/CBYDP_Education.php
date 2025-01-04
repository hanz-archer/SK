<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprehensive Barangay Youth Development Plan</title>
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
            <span class="logo-text">SK Sumaguan - Post CBYDP Education</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">Home</a>
            <a href="../admin/AdminPA.php" class="nav-item">Back</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>CBYDP - Education</h1>

        <form id="investment-plan-form" method="POST">
            <div class="form-group">
                <label for="calendar_year">Calendar Year:</label>
                <input type="number" 
                    id="calendar_year" 
                    name="calendar_year" 
                    class="calendar_year" 
                    min="2000" 
                    max="2100" 
                    required>
            </div>

            <label for="youth_development_concern">Youth Development Concern:</label>
            <textarea id="youth_development_concern" name="youth_development_concern" required></textarea>

            <label for="objective">Objective:</label>
            <textarea id="objective" name="objective" required></textarea>

            <label for="performance_indicator">Performance Indicator:</label>
            <textarea id="performance_indicator" name="performance_indicator" required></textarea>

            <label>Target:</label>
            <div class="target-inputs">
                <!-- Target inputs will be generated here -->
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
            // Set default calendar year to current year
            const currentYear = new Date().getFullYear();
            $('#calendar_year').val(currentYear);

            // Function to update target inputs with fixed years
            function updateTargetInputs() {
                const targetInputsContainer = $('.target-inputs');
                targetInputsContainer.empty();

                // Always create inputs for 2024, 2025, and 2026
                const years = [2024, 2025, 2026];
                
                years.forEach(year => {
                    const div = $('<div>');
                    const label = $('<label>')
                        .attr('for', `target_${year}`)
                        .text(`${year}:`);

                    const input = $('<input>')
                        .attr({
                            'type': 'text',
                            'id': `target_${year}`,
                            'name': `target_${year}`,
                            'required': true
                        });

                    div.append(label, input);
                    targetInputsContainer.append(div);
                });
            }

            // Initialize target inputs
            updateTargetInputs();

            // Form submission handler
            $('#investment-plan-form').on('submit', function(e) {
                e.preventDefault();
                
                // Create formData object from the form
                const formData = $(this).serialize();
                
                // Log form data for debugging
                console.log('Form Data:', formData);

                $.ajax({
                    url: '../connection/CBYDP_EducationConnection.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        console.log('Server Response:', response);
                        
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showCancelButton: true,
                                confirmButtonText: 'Download PDF',
                                cancelButtonText: 'Close'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.open(response.pdf_url, '_blank');
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                                footer: response.debug ? `Debug Info: ${JSON.stringify(response.debug)}` : '',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong while submitting the form.',
                            footer: `Technical Details: ${status} - ${error}`,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Calendar year input validation
            $('#calendar_year').on('input', function() {
                const value = $(this).val();
                const min = parseInt($(this).attr('min'));
                const max = parseInt($(this).attr('max'));
                
                if (value < min || value > max) {
                    $(this).addClass('invalid');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Year',
                        text: `Please enter a year between ${min} and ${max}`,
                        confirmButtonText: 'OK'
                    });
                } else {
                    $(this).removeClass('invalid');
                }
            });
        });
    </script>
</body>
</html>