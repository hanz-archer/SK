<?php
$entered_password = 'admin123'; // Replace with the password you're entering
$hashed_password = '$2y$10$pZbNz.p4vsdA4KWLPUjpw.7iA4GlRdrJPqYMX737pa....'; // Replace with the hash from your database

if (password_verify($entered_password, $hashed_password)) {
    echo "Password is correct!";
} else {
    echo "Password is incorrect!";
}
?>
