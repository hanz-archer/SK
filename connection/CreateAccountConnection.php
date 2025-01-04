<?php
include 'Connection.php';

$SK_ID = $_POST['SK_ID'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$birth_date = $_POST['birthdate'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];
$password = $_POST['password'];


$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Check accounts table
$account_check_query = "SELECT * FROM accounts WHERE SK_ID = '$SK_ID'";
$account_check_result = mysqli_query($conn, $account_check_query);
if (mysqli_num_rows($account_check_result) > 0) {
    echo json_encode(['status' => 'exists']);
    exit;
}

// Check sk_members table
$member_check_query = "SELECT * FROM sk_members 
                       WHERE SK_ID = '$SK_ID' 
                         AND first_name = '$first_name' 
                         AND middle_name = '$middle_name' 
                         AND last_name = '$last_name'";
$member_check_result = mysqli_query($conn, $member_check_query);

if (mysqli_num_rows($member_check_result) == 0) {
    echo json_encode(['status' => 'not_member']);
    exit;
}

// insert data into accounts table
$insert_query = "INSERT INTO accounts (SK_ID, first_name, middle_name, last_name, birthdate, phone_number, email, password) 
                 VALUES ('$SK_ID', '$first_name', '$middle_name', '$last_name', '$birth_date', '$phone_number', '$email', '$hashed_password')";

if (mysqli_query($conn, $insert_query)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
