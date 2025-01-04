<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Budget Allocation</title>
    <link rel="stylesheet" href="../css/PostBudget.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Post Announcements</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminBudget.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>   

    <div class="form-container">
        <center><h1>Post Budget Allocation</h1></center>
    
        <form id="budget-form" method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter budget title" required>

            <label for="total_budget">Total Budget:</label>
            <input type="number" id="total_budget" name="total_budget" placeholder="Enter total budget" required>

            <label for="description">Expenses Breakdown:</label>
            <textarea id="description" name="description" rows="10" placeholder="Describe the budget breakdown..." required></textarea>

            <button type="submit">POST BUDGET</button>
        </form>
    </div>

    <script>
        $('#budget-form').on('submit', function(e) {
            e.preventDefault(); 

            if (!$('#title').val() || !$('#total_budget').val() || !$('#description').val()) {
                Swal.fire("Please fill all the fields completely");
                return;
            }

            Swal.fire({
                title: "Do you want to post the budget allocation?",
                showDenyButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '../connection/PostBudgetConnection.php',
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire("Saved!", "Budget allocation posted successfully!", "success")
                                .then(() => {
                                    window.location.href = '../admin/AdminBudget.php'; 
                                });
                            } else {
                                Swal.fire("Error", "Failed to post the budget allocation. Please try again.", "error");
                            }
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Post cancelled", "", "info");
                }
            });
        });
    </script>
</body>
</html>
