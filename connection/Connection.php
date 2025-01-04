    <?php

    $servername = "localhost";
    $username = "sk";
    $password = "group4appdev*";
    $dbname = "skdb";
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Only echo this if the connection is successful
    echo "";

    ?>
