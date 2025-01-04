<?php
session_start();

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); 
} else {
    $error_message = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sangguniang Kabataan Lamacan</title>
    <link rel="stylesheet" href="../css/Welcome.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <header>
        <nav class="nav-links">
            <a href="../html/AboutUs.php" class="nav-item">About Us</a>
        </nav>
    </header>


    <div class="container">
        <div class="welcome-section">
            <img src="../images/SK_Logo.png" alt="SK Logo" class="logo">
            <h1>SANGGUNIANG KABATAAN</h1>
            <h2>Barangay Sumaguan</h2>
        </div>

        <div class="login-section">
            <h3>LOG IN</h3>
            <form id="login-form" action="../connection/LoginConnection.php" method="post">
                <div class="form-group">
                    <label for="SK_ID">SK ID:</label>
                    <input type="text" id="SK_ID" name="SK_ID" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group buttons">
                    <button type="submit" id="submit-button" class="btn">Log in</button>
                </div>
                <p>Don't have an account yet? <a href="../html/CreateAccount.php">Create Account</a></p>
            </form>
        </div>
    </div>

    <?php if ($error_message): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: "<?php echo addslashes($error_message); ?>"
        });
    </script>
    <?php endif; ?>
    
</body>
</html>
