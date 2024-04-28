<!-- This file is used to authenticate the user. It calls the authenticateUser function from db_connection.php. -->

<?php
require_once 'db_connection.php';

$username = $_POST['uname'];
$password = $_POST['psw'];

$sql = "SELECT * FROM USERS WHERE UNAME = '$username' AND PWORD = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Login successful. Welcome, " . htmlspecialchars($username) . "!";
} else {
    echo "Login failed. Please check your username and password.";
}
?>
