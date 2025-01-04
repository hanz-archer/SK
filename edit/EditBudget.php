<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Budget Allocation</title>
    <link rel="stylesheet" href="../css/EditBudget.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="../html/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Lamacan - Edit Awards and Certificates</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminBudget.php" class="nav-item">back</a>
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Edit Budget Allocation</h1>

        <?php
        include("../connection/Connection.php");

        // Get the budget ID from the URL
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);

            // Fetch the budget details from the database
            $sql = "SELECT * FROM budget WHERE Budget_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                echo "<p>Budget allocation not found.</p>";
                exit;
            }
        } else {
            echo "<p>No ID provided.</p>";
            exit;
        }
        ?>

        <form id="budget-form" method="POST">
            <input type="hidden" name="budget_id" value="<?php echo htmlspecialchars($row['Budget_ID']); ?>">

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['Title']); ?>" required>

            <label for="total_budget">Total Budget:</label>
            <input type="number" id="total_budget" name="total_budget" value="<?php echo htmlspecialchars($row['Total_Budget']); ?>" required>

            <label for="description">Expenses Breakdown:</label>
            <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($row['Description']); ?></textarea>


            <button type="submit">UPDATE</button>
        </form>
    </div>

    <script>
        $('#budget-form').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            Swal.fire({
                title: "Do you want to save the changes for this budget?",
                showDenyButton: true,
                confirmButtonText: "Save",
                denyButtonText: "Don't save"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../connection/EditBudgetConnection.php', 
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire("Updated!", "Budget allocation updated successfully!", "success")
                                .then(() => {
                                    window.location.href = '../admin/AdminBudget.php'; // Redirect to the budget page
                                });
                            } else {
                                Swal.fire("Error", "Failed to update the budget allocation. Please try again.", "error");
                            }
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        });
    </script>
</body>
</html>
