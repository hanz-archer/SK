<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include("../connection/Connection.php");


$dir = "C:/xampp/htdocs/SKPORTAL/photos/";


if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

if (isset($_FILES['image'])) {
    $image_names = $_FILES['image']['name'];
    $tmp_names = $_FILES['image']['tmp_name'];

    foreach ($tmp_names as $index => $tmp_name) {
        $name = $image_names[$index];


        $unique_name = time() . '_' . uniqid() . '_' . basename($name);
        $file_path = $dir . $unique_name;


        if (!empty($name)) {
            if (move_uploaded_file($tmp_name, $file_path)) {
                $upload_date = date('Y-m-d H:i:s');
                $query = "INSERT INTO `photos` (`image`, `upload_date`) VALUES ('$unique_name', '$upload_date')";

                if (mysqli_query($conn, $query)) {
                    echo "Uploaded and inserted: $unique_name\n";
                } else {
                    echo "Database insert failed: " . mysqli_error($conn) . "\n";
                }
            } else {
                echo "Failed to move uploaded file: $name\n";
            }
        } else {
            echo "File name is empty for index: $index\n";
        }
    }
} else {
    echo "No files uploaded.";
}


?>
