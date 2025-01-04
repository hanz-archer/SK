<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin Account Creation</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-form {
            background-color: white;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .register-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .register-form button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-form button:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

    <form class="register-form" action="../connection/RegisterAdminConnection.php" method="POST">
        <h2>Create Admin Account</h2>

        <label for="sk_id">SK ID</label>
        <input type="text" id="sk_id" name="SK_ID" required>

        <label for="admin_username">Admin Username</label>
        <input type="text" id="admin_username" name="AdminUsername" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Create Account</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const error = urlParams.get('error');


            if (status === 'success') {
                Swal.fire("Success", "New admin account created successfully!", "success");
            } else if (status === 'error') {
                if (error === 'empty_fields') {
                    Swal.fire("Error", "Please fill out all fields.", "error");
                } else {
                    Swal.fire("Error", "Error creating admin account. Please try again.", "error");
                }
            }
        });
    </script>

</body>
</html>
