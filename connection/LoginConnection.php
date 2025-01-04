<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection/Connection.php';

// Ensure connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sk_id = $_POST['SK_ID'];
    $password = $_POST['password'];

    if (!empty($sk_id) && !empty($password)) {
        // Check users table
        $stmt = $conn->prepare("SELECT first_name, password FROM accounts WHERE SK_ID = ?");
        if ($stmt === false) {
            die('Prepare() failed for accounts table: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("s", $sk_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($first_name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $sk_id;
                $_SESSION['first_name'] = $first_name;
                header("Location: ../html/HomePage.php");
                exit();
            }
        }
        $stmt->close();

        // Check sk_admin table
        $stmt = $conn->prepare("SELECT AdminUsername, password FROM sk_admin WHERE SK_ID = ?");
        if ($stmt === false) {
            die('Prepare() failed for sk_admin table: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("s", $sk_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($adminUsername, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['admin_id'] = $sk_id;
                $_SESSION['AdminUsername'] = $adminUsername;
                header("Location: ../admin/AdminHP.php");
                exit();
            } else {
                header("Location: ../html/Welcome.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "SK ID not found. Create an account.";
            header("Location: ../html/Welcome.php");
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Please fill out all fields.";
        header("Location: ../html/Welcome.php");
        exit();
    }

    $conn->close();
}
?>
