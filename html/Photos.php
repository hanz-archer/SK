<?php
include("../connection/Connection.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image'])) {
    $image = $_POST['image'];
    $imagePath = "../photos/" . $image;


    if (file_exists($imagePath)) {
        unlink($imagePath);
    }


    $query = "DELETE FROM photos WHERE image = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $image);

    if (mysqli_stmt_execute($stmt)) {
        echo "Image deleted successfully.";
    } else {
        echo "Error deleting image: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <link rel="stylesheet" href="../css/Photos.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="../html/HomePage.php">
            <img src="../images/SK_Logo.png" alt="SK Logo">
        </a>
        <span class="logo-text">SK Sumaguan - Photos</span>
    </div>
    <nav class="nav-links">
        <a href="../html/HomePage.php" class="nav-item">HOME</a>
    </nav>
</header>

<div class="gallery">
    <?php

    $query = "SELECT * FROM photos ORDER BY id DESC";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = "../photos/" . htmlspecialchars($row['image']);
            echo '<img src="' . $imagePath . '" alt="Gallery Image" class="gallery-img" data-image-name="' . htmlspecialchars($row['image']) . '">';
        }
    } else {
        echo "<p>No photos uploaded yet.</p>";
    }
    ?>
</div>

<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>




<script>
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    const closeBtn = document.getElementsByClassName("close")[0];

    let currentImg = null; 

    document.querySelectorAll(".gallery-img").forEach(img => {
        img.addEventListener("click", function() {
            modal.style.display = "block";
            modalImage.src = this.src;
            currentImg = this;
        });
    });

    closeBtn.onclick = function() {
        modal.style.display = "none";
    };


    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
</script>


</body>
</html>
