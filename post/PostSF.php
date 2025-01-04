<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Suggestion or Feedback</title>
    <link rel="stylesheet" href="../css/PostSF.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Post Suggestion or Feedback</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminSF.php" class="nav-item">Back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>  

    <div class="form-container">
        <center><h1>Post Suggestion or Feedback</h1></center>
        <br>

        <form id="suggestion-form" method="POST">

            <label for="form-type">Select Form Type:</label>
            <select id="form-type" name="form_type" required>
                <option value="" disabled selected>Select an option</option>
                <option value="Suggestion">For Suggestion</option>
                <option value="Feedback">For Feedback</option>
            </select>


            <div id="form-fields" style="display: none;">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Enter title" required>
            </div>

            <button type="submit">SUBMIT</button>
        </form>

    </div>


    <script>
            $(document).ready(function() {

            $('#form-type').on('change', function() {
                var selectedForm = $(this).val();

                if (selectedForm) {
                    $('#form-fields').show();


                    $('#title').prop('required', true);
                } else {
                    $('#form-fields').hide();
                    $('#title').prop('required', false);
                }
            });


            $('#suggestion-form').on('submit', function(e) {
                e.preventDefault();

                var formType = $('#form-type').val();
                var title = $('#title').val();

                if (!formType) {
                    Swal.fire("Please select a form type.");
                    return;
                }

                if (!title) {
                    Swal.fire("Please enter a title.");
                    return;
                }

                var confirmTitle = formType === 'Suggestion' ? "Do you want to submit the suggestion?" : "Do you want to submit the feedback?";

                Swal.fire({
                    title: confirmTitle,
                    showDenyButton: true,
                    confirmButtonText: "Submit",
                    denyButtonText: `Don't submit`
                }).then((result) => {
                    if (result.isConfirmed) {

                        var formData = $(this).serialize();

                        $.ajax({
                            url: '../connection/PostSFConnection.php',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    var successMessage = formType === 'Suggestion' ? "Your suggestion has been submitted successfully!" : "Your feedback has been submitted successfully!";
                                    Swal.fire("Submitted!", successMessage, "success")
                                    .then(() => {
                                        window.location.href = '../admin/AdminSF.php';
                                    });
                                } else {
                                    Swal.fire("Error", response.message || "Failed to submit. Please try again.", "error");
                                }
                            },
                            error: function() {
                                Swal.fire("Error", "An error occurred while submitting. Please try again.", "error");
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire("Submission cancelled", "", "info");
                    }
                });
            });
        });
    </script>
</body>
</html>
