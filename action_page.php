<!-- This file is used to authenticate the user. It calls the authenticateUser function from db_connection.php. -->

<?php
require_once 'db_connection.php';

$username = $_POST['uname'];
$password = $_POST['psw'];

$conn = openConnect();

$sql = "SELECT * FROM USERS WHERE UNAME = '$username' AND PWORD = '$password'";
$result = $conn->query($sql);

if (authenticateUser($conn, $username, $password))
    {
        // redirect to the MainLanding.html page
        closeConnect($conn);
        header("Location: easyStyleMain.html");
        exit();
    }
    // else if the query returns empty, the username and password are invalid
        else
    {
        // pop-up informing user of invalid username and password
        closeConnect($conn);
        $_SESSION['error'] = "Invalid username or password";
        header("Location: easyStyleLogin.html");
        exit;
    }
die();

