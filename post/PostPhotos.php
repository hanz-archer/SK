<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photos</title>
    <link rel="stylesheet" href="../css/PostPhotos.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header>    
        <div class="logo">
            <a href="../html/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Upload Photos</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminPhotos.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Upload Photos</h1>
        <form id="addForm" enctype="multipart/form-data">
            <label for="">Upload multiple photos:</label>
            <input type="file" name="image[]" id="image" required multiple>
            <center><button type="submit" id="submitBtn">Submit</button></center>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $("#addForm").submit(function (e) {
                e.preventDefault(); // Prevent default form submission

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to proceed with the upload?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, upload it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, proceed with the AJAX request
                        let form_data = new FormData(this);

                        $.ajax({
                            url: "../connection/PostPhotosConnection.php",
                            method: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            success: function (response) {
                                Swal.fire(
                                    'Uploaded!',
                                    'Your photos have been uploaded successfully.',
                                    'success'
                                ).then(() => {

                                    window.location.href = "../admin/AdminPhotos.php";
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred: ' + xhr.responseText,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>
</html>
