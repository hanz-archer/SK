<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Meetings</title>
    <link rel="stylesheet" href="../css/AdminArchive.css">
</head>
<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-image: url("../images/HP_bg.png");
  background-repeat: no-repeat;
  background-size: cover;
  color: white;
}

header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 10px;
  background-image: url("../images/HP_bg.png");
  background-size: cover;
  background-repeat: no-repeat;
  height: 70px;
  width: 100%;
  z-index: 1000;
  position: fixed;
  top: 0;
  left: 0;
}

.logo {
  display: flex;
  align-items: center;
}

.logo img {
  width: 50px;
  height: auto;
  margin-right: 10px;
}

.logo-text {
  color: white;
  font-size: 24px;
}

.nav-item {
  color: white;
  text-decoration: none;
  margin-right: 30px;
  font-size: 20px;
}

main {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: transparent;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
}

.bulletin-board {
    margin-top: 20px;
    color: Black;
}

.announcement-card {
    background-color: rgba(255, 255, 255, 0.5); 
    border: 1px solid #ced4da; 
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    transition: transform 0.2s, box-shadow 0.2s; 
}

.announcement-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.announcement-card h2 {
    font-size: 20px;
    color: #007bff;
    margin-bottom: 10px;
}

.announcement-date {
    font-size: 14px;
    color: #282828;
    margin-bottom: 10px;
}

.announcement-details {
    font-size: 16px;
    line-height: 1.5;
}

</style>
<body>
    <header>
        <div class="logo">
            <a href="../admin/AdminHP.php">
                <img src="../images/SK_Logo.png" alt="SK Logo">
            </a>
            <span class="logo-text">SK Sumaguan - Archive Meetings</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminMeetings.php" class="nav-item">back</a>           
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <main>
        <h1>Archived Meetings</h1>
        <div class="bulletin-board">
            <?php
                $conn = new mysqli("localhost", "root", "", "skdb");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT MeetingID, Title, DateOfMeeting, DatePosted, Agenda FROM archive_meetings ORDER BY DateOfMeeting DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="announcement-card">';
                        echo '<h2>' . $row["Title"] . '</h2>';
                        echo '<p class="announcement-date">Date of Meeting: ' . date("F j, Y", strtotime($row["DateOfMeeting"])) . '</p>';
                        echo '<p class="announcement-date">Posted on: ' . date("F j, Y", strtotime($row["DatePosted"])) . '</p>';
                        echo '<p class="announcement-details"><strong>Agenda:</strong> ' . $row["Agenda"] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No archived meetings available at the moment.</p>";
                }

                $conn->close();
            ?>
        </div>
    </main>
</body>
</html>