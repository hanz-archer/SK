<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$SK_ID = $_SESSION['user_id']; 

include("../connection/Connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $SF_ID = $_POST['SF_ID'];
    $Title = $_POST['Title'];
    $DateSubmitted = date('Y-m-d H:i:s');


    if ($_POST['FormType'] == 'Suggestion') {

        $suggestion = $_POST['suggestion'];
        $query = "INSERT INTO user_suggestions (SF_ID, Title, SK_ID, Suggestions, DateSubmitted) 
                  VALUES ('$SF_ID', '$Title', '$SK_ID', '$suggestion', '$DateSubmitted')";
        if (mysqli_query($conn, $query)) {
            echo "Success";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif ($_POST['FormType'] == 'Feedback') {


        $feedback = $_POST['feedback'];
        $rating = $_POST['rating'];
        $query = "INSERT INTO user_feedbacks (SF_ID, Title, SK_ID, Feedbacks, Rating, DateSubmitted) 
                  VALUES ('$SF_ID', '$Title', '$SK_ID', '$feedback', '$rating', '$DateSubmitted')";
        if (mysqli_query($conn, $query)) {
            echo "Success";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
