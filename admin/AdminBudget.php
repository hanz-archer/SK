<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Budget Allocation</title>
    <link rel="stylesheet" href="../css/BudgetAllocation.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../html/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Budget Allocation</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <main>
        <h1>BUDGET ALLOCATION</h1><br>

        <div class="bulletin-board">
        <?php
            include("../connection/Connection.php");


            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }


            $sql = "SELECT * FROM budget ORDER BY Created_At DESC"; 
            $result = $conn->query($sql);


            if (!$result) {
                die("Error in SQL query: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="budget-post" onclick="toggleDetails(this)">
                        <h2 class="activity-title">' . htmlspecialchars($row['Title']) . '</h2>
                        <p class="budget-date">Posted: ' . htmlspecialchars(date("F j, Y, g:i a", strtotime($row['Created_At']))) . '</p>
                        <div class="budget-details" style="display: none;">
                            <p class="total-budget">Total Budget: ₱' . htmlspecialchars($row['Total_Budget']) . '</p>
                            <div class="expense-breakdown">
                                <h3>Expense Breakdown:</h3>
                                <p>' . nl2br(htmlspecialchars($row['Description'])) . '</p>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <a href="../edit/EditBudget.php?id=' . htmlspecialchars($row['Budget_ID']) . '">
                                <button class="edit-btn">Edit</button>
                            </a>
                        </div>
                    </div>';
                }
            } else {
                echo "<p>No budget allocations found.</p>";
            }


            $conn->close();
        ?>
        </div>

        <div class="plus-button" onclick="toggleUploadMenu()">
            <a href="../post/PostBudget.php">
                <img src="../images/plus_icon.png" alt="Plus Icon">
            </a>
        </div>
    </main>

    <script>
        function toggleDetails(section) {
            const details = section.querySelector('.budget-details');
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
