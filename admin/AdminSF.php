<?php
include("../connection/Connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SF_ID']) && isset($_POST['title'])) {
    $sf_id = intval($_POST['SF_ID']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $update_sql = "UPDATE suggestion_and_feedback SET Title = '$title' WHERE SF_ID = $sf_id";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && isset($_POST['SF_ID'])) {
    $sf_id = intval($_POST['SF_ID']);
    
    if ($_POST['action'] == 'hide') {
        // Update the visibility for users
        $update_sql = "UPDATE suggestion_and_feedback SET IsVisibleToUsers = FALSE WHERE SF_ID = $sf_id";
    } else {
        $update_sql = "UPDATE suggestion_and_feedback SET IsVisibleToUsers = TRUE WHERE SF_ID = $sf_id";
    }
    
    if ($conn->query($update_sql) === TRUE) {
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Suggestions & Feedback</title>
    <link rel="stylesheet" href="../css/SuggestFeedback.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Suggestions and Feedbacks</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="bulletin-container">
        <!-- Left Section for Suggestions -->
        <div class="left-section">
            <h2>Suggestions</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM suggestion_and_feedback WHERE FormType = 'Suggestion' ORDER BY SF_ID DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $formattedDate = date("F j, Y", strtotime($row['DateTime']));
                            $hideText = ($row['IsVisibleToUsers'] == 0) ? 'Already Hidden' : 'Hide in Users'; // If hidden, change button text

                            echo "<tr id='row-{$row['SF_ID']}'>
                                    <td>{$row['Title']}</td>
                                    <td>{$formattedDate}</td>
                                    <td>
                                        <a href='javascript:void(0)' onclick='openModal({$row['SF_ID']}, \"{$row['Title']}\")' class='button edit-button'>EDIT</a>
                                        <a href='ViewUserSubmissions.php?SF_ID={$row['SF_ID']}' class='button view-button'>VIEW</a>
                                        <a href='javascript:void(0)' onclick='hidePost({$row['SF_ID']}, \"{$row['Title']}\")' class='button hide-button'>{$hideText}</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No suggestions found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Right Section for Feedbacks -->
        <div class="right-section">
            <h2>Feedbacks</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM suggestion_and_feedback WHERE FormType = 'Feedback' ORDER BY SF_ID DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $formattedDate = date("F j, Y", strtotime($row['DateTime']));
                            $hideText = ($row['IsVisibleToUsers'] == 0) ? 'Already Hidden' : 'Hide in Users'; // If hidden, change button text

                            echo "<tr id='row-{$row['SF_ID']}'>
                                    <td>{$row['Title']}</td>
                                    <td>{$formattedDate}</td>
                                    <td>
                                        <a href='javascript:void(0)' onclick='openModal({$row['SF_ID']}, \"{$row['Title']}\")' class='button edit-button'>EDIT</a>
                                        <a href='ViewUserSubmissions.php?SF_ID={$row['SF_ID']}' class='button view-button'>VIEW</a>
                                        <a href='javascript:void(0)' onclick='hidePost({$row['SF_ID']}, \"{$row['Title']}\")' class='button hide-button'>{$hideText}</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No feedbacks found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="plus-button" onclick="toggleUploadMenu()">
            <a href="../post/PostSF.php">
                <img src="../images/plus_icon.png" alt="Plus Icon">
            </a>
        </div>

    <script>
        function hidePost(SF_ID, title) {
            const formData = new FormData();
            formData.append('SF_ID', SF_ID);
            formData.append('action', 'hide');  // action to hide the post

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../admin/AdminSF.php', true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response === "Success") {
                        Swal.fire({
                            title: 'Success!',
                            text: 'The post has been hidden for users.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Update button text dynamically
                            const row = document.getElementById('row-' + SF_ID);
                            const hideButton = row.querySelector('.hide-button');
                            hideButton.innerHTML = 'Already Hidden';  // Change button text
                            hideButton.disabled = true;  // Disable the button to prevent re-clicking
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an issue hiding the post. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            };

            xhr.onerror = function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred during the AJAX request.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            };

            xhr.send(formData);  // Send the request
        }
    </script>
</body>
</html>
