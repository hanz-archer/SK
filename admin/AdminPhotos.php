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
    <title>Admin Photo Gallery</title>
    <link rel="stylesheet" href="../css/Photos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<header>
    <div class="logo">
        <a href="../html/AdminHP.php">
            <img src="../images/SK_Logo.png" alt="SK Logo">
        </a>
        <span class="logo-text">SANGGUNIANG KABATAAN - Barangay Sumaguan</span>
    </div>
    <nav class="nav-links">
        <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
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
    <i id="deleteBtn" class="fas fa-trash delete-icon"></i>
    <img class="modal-content" id="modalImage">
</div>

<div class="plus-button" onclick="toggleUploadMenu()">
    <a href="../post/PostPhotos.php">
        <img src="../images/plus_icon.png" alt="Plus Icon">
    </a>
</div>



<script>
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    const closeBtn = document.getElementsByClassName("close")[0];
    const deleteBtn = document.getElementById("deleteBtn");

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

    deleteBtn.onclick = function() {
        if (currentImg) {
            const imageName = currentImg.getAttribute("data-image-name");


            modal.style.display = "none";


            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this image?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "AdminPhotos.php",
                        method: "POST",
                        data: { image: imageName },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response,
                                'success'
                            ).then(() => {
                                currentImg.remove(); 
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the image: ' + xhr.responseText,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
</script>


</body>
</html>
