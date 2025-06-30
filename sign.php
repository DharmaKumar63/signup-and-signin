<?php

$uname1 = $_POST['uname1'];
$umobile1 = $_POST['umobile1'];
$uemail1 = $_POST['uemail1'];
$upswd1 = $_POST['upswd1'];
$upswd2 = $_POST['upswd2'];

if (!empty($uname1) && !empty($umobile1) && !empty($uemail1) && !empty($upswd1) && !empty($upswd2)) {

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "register";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die('Connect error(' . $conn->connect_errno . ') ' . $conn->connect_error);
    } else {
        // Check if the email already exists
        $SELECT = "SELECT uemail1 FROM dbform WHERE uemail1 = ? LIMIT 1";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $uemail1);
        $stmt->execute();
        $stmt->bind_result($resultuemail1);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            // Email does not exist, proceed to insert
            $stmt->close();
            
            // Insert new record
            $INSERT = "INSERT INTO dbform (uname1, umobile1, uemail1, upswd1, upswd2) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssss", $uname1, $umobile1, $uemail1, $upswd1, $upswd2);
            $stmt->execute();
            echo "New record inserted successfully";
        } else {
            echo "Someone already registered using this email.";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required.";
    die();
}

?>
