<?php


$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "register";

// ! Check if the form was submitted
if (isset($_POST['submit'])) {
    $uname1 = $_POST['uname1'] ?? '';
    $upswd2 = $_POST['upswd2'] ?? '';

    // ! Create a database connection
    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM `dbform` WHERE uname1 = ? AND upswd2 = ?");
    mysqli_stmt_bind_param($stmt, "ss", $uname1, $upswd2);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "Login successful";
    } else {
        echo "Username or Password is incorrect";
    }

    // ! Close connections
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Form not submitted.";
}
?>
