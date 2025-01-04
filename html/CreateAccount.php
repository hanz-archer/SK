<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Lamacan - Create Account</title>
    <link rel="stylesheet" href="../css/CreateAccount.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>


    <div class="container">
        <h2>Create Account</h2>
        <form id="account-form"  method="POST">
            <div class="column">
                <div class="form-group">
                    <label for="SK_ID">SK ID:</label>
                    <input type="text" id="SK_ID" name="SK_ID" required>
                </div>
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name:</label>
                    <input type="text" id="middle_name" name="middle_name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
            </div>

            <div class="column">
                <div class="form-group">
                    <label for="birth_date">Birth Date:</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Active Phone Number:</label>
                    <input type="tel" id="phone_number" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>

            <div class="column">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
            </div>
            <div class="form-group buttons">
                <button type="submit" id="submit-button" class="btn">Sign Up</button>
            </div>
        </form>
        <p>Already have an account?<a href="../html/Welcome.php">Log In</a></p>
    </div>



    
</body>

<script>
    $('#account-form').on('submit', function (e) {
        e.preventDefault();
        
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();

        if (password !== confirmPassword) {
            Swal.fire("Passwords do not match. Please try again.");
            return;
        }

        $.ajax({
            url: '../connection/CreateAccountConnection.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success'){
                    Swal.fire("Account created successfully!", "", "success")
                        .then(() => { window.location.href = "../html/Welcome.php"; });
                } else if (response.status === 'exists') {
                    Swal.fire("SK ID or Account already created. Proceed to Log in.");
                } else if (response.status === 'not_member') {
                    Swal.fire("Not a member in Barangay Lamacan. Your info does not match, kindly check and try again.");
                } else {
                    Swal.fire("An error occurred. Please try again.");
                }
            }
        });
    });
</script>


</html>
