<?php
require '../connection/Connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sk_id = $_POST['SK_ID'];
    $admin_username = $_POST['AdminUsername'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    if (empty($sk_id) || empty($admin_username) || empty($password) || empty($confirm_password)) {

        header("Location: ../admin/AdminRegister.php?status=error&error=empty_fields");
        exit();
    }


    $member_check_query = "SELECT * FROM sk_members WHERE SK_ID = ?";
    $stmt = $conn->prepare($member_check_query);
    $stmt->bind_param("s", $sk_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {

        header("Location: ../admin/AdminRegister.php?status=error&error=sk_id_not_found");
        exit();
    }


    $admin_check_query = "SELECT * FROM sk_admin WHERE SK_ID = ?";
    $stmt = $conn->prepare($admin_check_query);
    $stmt->bind_param("s", $sk_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        header("Location: ../admin/AdminRegister.php?status=error&error=admin_exists");
        exit();
    }


    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $insert_query = "INSERT INTO sk_admin (SK_ID, AdminUsername, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sss", $sk_id, $admin_username, $hashed_password);

        if ($stmt->execute()) {

            header("Location: ../admin/AdminRegister.php?status=success");
        } else {

            header("Location: ../admin/AdminRegister.php?status=error&error=insert_failed");
        }
    } else {

        header("Location: ../admin/AdminRegister.php?status=error&error=password_mismatch");
    }

    $stmt->close();
}
$conn->close();
