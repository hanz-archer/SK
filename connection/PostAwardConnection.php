<?php
include("../connection/Connection.php");

header('Content-Type: application/json');

if (
    isset($_POST['award_title']) &&
    isset($_POST['award_date']) &&
    isset($_POST['description']) &&
    isset($_FILES['award_image'])
) {
    // Sanitize input data
    $title = mysqli_real_escape_string($conn, $_POST['award_title']);
    $date_awarded = mysqli_real_escape_string($conn, $_POST['award_date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle the image upload
    $upload_dir = "../photos/awards/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image = $_FILES['award_image'];
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_error = $image['error'];

    if ($image_error === 0) {
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array(strtolower($image_ext), $allowed_ext)) {
            // Prevent overwriting by generating a unique filename
            $unique_image_name = time() . '_' . uniqid() . '.' . $image_ext;
            $image_path = $upload_dir . $unique_image_name;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($image_tmp, $image_path)) {
                // Insert award data into the database, including image filename
                $insert_query = "
                    INSERT INTO awards (Title, DatePosted, DateAwarded, Description, Image) 
                    VALUES ('$title', NOW(), '$date_awarded', '$description', '$unique_image_name')
                ";

                if (mysqli_query($conn, $insert_query)) {
                    echo json_encode(['status' => 'success', 'message' => 'Award posted successfully']);
                } else {
                    // If database insert fails, delete the uploaded image to maintain consistency
                    unlink($image_path);
                    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload the image.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error uploading the image.']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete input.']);
}

mysqli_close($conn);
?>
