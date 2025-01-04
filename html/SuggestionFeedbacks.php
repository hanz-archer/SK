<?php 
include("../connection/Connection.php");

// Updated query to only get visible posts for users
$query = "SELECT * FROM suggestion_and_feedback WHERE IsVisibleToUsers = TRUE";

// Execute query and check if it's successful
$result = mysqli_query($conn, $query);

if (!$result) {
    // If the query fails, display an error message and stop further execution
    die("Query failed: " . mysqli_error($conn));
}

function formatDate($datetime) {
    return date("F j, Y - g:i A", strtotime($datetime));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestions & Feedback</title>
    <link rel="stylesheet" href="../css/SuggestFeedback.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleContent(id, event) {
            if (event.target.closest('.feedback-content, .star, textarea, input[type="submit"]')) {
                return;
            }
            var allContents = document.querySelectorAll('.feedback-content');
            allContents.forEach(function(content) {
                content.style.display = 'none';
            });

            var content = document.getElementById(id);
            content.style.display = content.style.display === 'block' ? 'none' : 'block';
        }

        function selectStar(rating) {
            var stars = document.querySelectorAll('.star');
            var ratingInput = document.querySelector('input[name="rating"]');
            ratingInput.value = rating;

            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }

        function submitForm(event, form) {
            event.preventDefault(); 

            var rating = document.querySelector('input[name="rating"]').value;
            if (!rating && form.querySelector('input[name="FormType"]').value == 'Feedback') {
                Swal.fire('Error!', 'Please select a rating before submitting.', 'error');
                return; 
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit this form?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(form);
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", form.action, true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            Swal.fire('Success!', 'Your response has been submitted.', 'success')
                                .then(() => window.location.reload()); 
                        } else {
                            Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                        }
                    };
                    xhr.send(formData);
                }
            });
        }
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../html/HomePage.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Suggestions and Feedback</span>
        </div>
        <nav class="nav-links">
            <a href="../html/HomePage.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="feedback-container">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="feedback-box" onclick="toggleContent('content-<?php echo $row['SF_ID']; ?>', event)">
                <h3><?php echo $row['Title']; ?> (<?php echo $row['FormType']; ?> Form)</h3>
                <div id="content-<?php echo $row['SF_ID']; ?>" class="feedback-content" style="display:none;">
                    <?php if ($row['FormType'] == 'Suggestion'): ?>
                        <div class="left-form">
                            <form method="POST" action="../connection/SubmitSFConnection.php" onsubmit="submitForm(event, this)">
                                <input type="hidden" name="FormType" value="Suggestion">
                                <br><label for="rating">Suggestion:</label>
                                <textarea name="suggestion" placeholder="Your suggestion here..."></textarea><br>
                                <input type="hidden" name="SF_ID" value="<?php echo $row['SF_ID']; ?>">
                                <input type="hidden" name="Title" value="<?php echo $row['Title']; ?>">
                                <input type="submit" value="Submit Suggestion">
                            </form>
                        </div>
                    <?php elseif ($row['FormType'] == 'Feedback'): ?>
                        <div class="right-form">
                            <form method="POST" action="../connection/SubmitSFConnection.php" onsubmit="submitForm(event, this)">
                                <input type="hidden" name="FormType" value="Feedback">
                                <br><label for="rating">Rate:</label>
                                <div class="rating" id="rating">
                                    <span class="star" onclick="selectStar(1)">★</span>
                                    <span class="star" onclick="selectStar(2)">★</span>
                                    <span class="star" onclick="selectStar(3)">★</span>
                                    <span class="star" onclick="selectStar(4)">★</span>
                                    <span class="star" onclick="selectStar(5)">★</span>
                                </div>

                                <br><label for="feedback">Feedback:</label>
                                <textarea name="feedback" id="feedback" placeholder="Your feedback here..."></textarea><br>

                                <input type="hidden" name="rating" value=""/>
                                <input type="hidden" name="SF_ID" value="<?php echo $row['SF_ID']; ?>">
                                <input type="hidden" name="Title" value="<?php echo $row['Title']; ?>">
                                <input type="submit" value="Submit Feedback">
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
