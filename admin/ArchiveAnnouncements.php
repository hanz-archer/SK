<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Announcements</title>
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
    background-color: rgba(255, 255, 255, 0.5);; 
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
    color:rgb(123, 0, 0);
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
            <span class="logo-text">SK Sumaguan - Archive Announcement</span>
        </div>
        <nav class="nav-links">
            <a href="../admin/AdminAnnouncement.php" class="nav-item">back</a>           
            <a href="../admin/AdminHP.php" class="nav-item">HOME</a>
        </nav>
    </header>

    <main>
        <h1>Archived Announcements</h1>
        <div class="bulletin-board">
            <?php
                $conn = new mysqli("localhost", "root", "", "skdb");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT AnnouncementID, Title, Date, Description FROM archive_announcements ORDER BY Date DESC, AnnouncementID DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        
                        $description = str_replace(array("\r\n", "\n", "\r"), "<br>", htmlspecialchars($row["Description"]));
                    
                        echo '<div class="announcement-card">';
                        echo '<h2>' . htmlspecialchars($row["Title"]) . '</h2>';
                        echo '<p class="announcement-date">Posted: ' . date("F j, Y, g:i A", strtotime($row["Date"])) . '</p>';
                        echo '<p class="announcement-details">' . $description . '</p>';
                        echo '</div>';
                    }                    
                } else {
                    echo "<p>No archived announcements available at the moment.</p>";
                }

                $conn->close();
            ?>
        </div>
    </main>
</body>
</html>
