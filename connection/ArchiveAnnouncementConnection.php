<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "skdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $announcementId = intval($_GET['id']);

    $conn->begin_transaction();

    try {
        $stmtInsert = $conn->prepare(
            "INSERT INTO archive_announcements (AnnouncementID, Title, Date, Description) 
             SELECT AnnouncementID, Title, Date, Description 
             FROM announcements 
             WHERE AnnouncementID = ?"
        );
        $stmtInsert->bind_param("i", $announcementId);
        $stmtInsert->execute();

        $stmtDelete = $conn->prepare("DELETE FROM announcements WHERE AnnouncementID = ?");
        $stmtDelete->bind_param("i", $announcementId);
        $stmtDelete->execute();

        $conn->commit();

        $stmtInsert->close();
        $stmtDelete->close();

        header("Location: ../admin/AdminAnnouncement.php?status=archived");
        exit();
    } catch (Exception $e) {
        $conn->rollback();

        echo "Error: " . $e->getMessage();
    }
} else {

    header("Location: ../admin/AdminAnnouncement.php?status=error");
    exit();
}

$conn->close();
?>
