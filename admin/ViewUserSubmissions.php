<?php
include("../connection/Connection.php");

if (!isset($_GET['SF_ID'])) {
    echo "No SF_ID provided.";
    exit();
}

$SF_ID = intval($_GET['SF_ID']);

// Fetch the Title and FormType for the given SF_ID
$sql = "SELECT Title, FormType FROM suggestion_and_feedback WHERE SF_ID = $SF_ID";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "No data found for this SF_ID.";
    exit();
}

$row = $result->fetch_assoc();
$title = $row['Title'];
$formType = $row['FormType'];

// Fetch the suggestion or feedback data from the respective tables based on FormType
if ($formType == 'Suggestion') {
    $sqlSuggestions = "
        SELECT us.SK_ID, a.first_name, a.middle_name, a.last_name, us.Suggestions, us.DateSubmitted
        FROM user_suggestions us
        JOIN accounts a ON us.SK_ID = a.SK_ID
        WHERE us.SF_ID = $SF_ID
    ";
    $suggestionsResult = $conn->query($sqlSuggestions);
    $feedbacksResult = null; // Do not fetch feedbacks for suggestions
} elseif ($formType == 'Feedback') {
    $sqlFeedbacks = "
        SELECT uf.SK_ID, a.first_name, a.middle_name, a.last_name, uf.Feedbacks, uf.Rating, uf.DateSubmitted
        FROM user_feedbacks uf
        JOIN accounts a ON uf.SK_ID = a.SK_ID
        WHERE uf.SF_ID = $SF_ID
    ";
    $feedbacksResult = $conn->query($sqlFeedbacks);
    $suggestionsResult = null; // Do not fetch suggestions for feedbacks
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/ViewUserSubmissions.css">
    <title>User Submissions for SF_ID: <?php echo $SF_ID; ?></title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - User Submissions</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminSF.php" class="nav-item">Back to Suggestions and Feedback</a>
        </nav>
    </header>

    <div class="container">
        <?php if ($formType == 'Suggestion'): ?>
            <h2>Suggestions for: <?php echo $title; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Suggestion</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($suggestionsResult->num_rows > 0) {
                        while ($row = $suggestionsResult->fetch_assoc()) {
                            $fullName = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
                            $formattedDate = date("F j, Y, g:i a", strtotime($row['DateSubmitted']));
                            echo "<tr>
                                    <td>{$fullName}</td>
                                    <td>{$row['Suggestions']}</td>
                                    <td>{$formattedDate}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No suggestions found for this yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if ($formType == 'Feedback'): ?>
            <h2>Feedbacks for: <?php echo $title; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Feedback</th>
                        <th>Rating</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($feedbacksResult->num_rows > 0) {
                        while ($row = $feedbacksResult->fetch_assoc()) {
                            $fullName = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
                            $formattedDate = date("F j, Y, g:i a", strtotime($row['DateSubmitted']));
                            echo "<tr>
                                    <td>{$fullName}</td>
                                    <td>{$row['Feedbacks']}</td>
                                    <td>{$row['Rating']}</td>
                                    <td>{$formattedDate}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No feedbacks found for this yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
