<?php
include("../connection/Connection.php");

$query = "SELECT * FROM awards ORDER BY AwardID DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Awards and Certificates</title>
    <link rel="stylesheet" href="../css/Awards.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Awards and Certificates</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <main>
        <h1>AWARDS AND CERTIFICATES</h1>
        <br><br>

        <div class="certificate-gallery">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="certificate-card">';


                    if (!empty($row['Image'])) {

                        $imagePath = '../photos/awards/' . htmlspecialchars($row['Image']);
                        echo '<img src="' . $imagePath . '" alt="Award Image" class="award-image">';
                    } else {
                        echo '<p>No image available</p>';
                    }

                    echo '<h2>' . htmlspecialchars($row['Title']) . '</h2>';
                    echo '<p class="certificate-date">Awarded: ' . htmlspecialchars($row['DateAwarded']) . '</p>';
                    echo '<p class="certificate-description">' . nl2br(htmlspecialchars($row['Description'])) . '</p>';
                    echo '<a href="../edit/EditAwards.php?id=' . $row['AwardID'] . '"><button class="edit-btn">Edit</button></a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No awards found.</p>';
            }

            mysqli_close($conn);
            ?>
        </div>

        <div class="plus-button" onclick="toggleUploadMenu()">
            <a href="../post/PostAwards.php">
                <img src="../images/plus_icon.png" alt="Plus Icon">
            </a>
        </div>
    </main>
</body>
</html>
