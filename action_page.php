<!-- This file is used to authenticate the user. It calls the authenticateUser function from db_connection.php. -->

<?php
    ini_set('display_errors', 1);
    require_once 'db_connection.php';

    //start the session
    session_start();

    // assign the username and password posted from easyStyleLogin.php to a variable
    $username = $_POST['uname'];
    $password = $_POST['psw'];

    // connect to the database
    $conn = openConnect();

    /* call the authenticateUser function from db_connection.php. */
    if (authenticateUser($conn, $username, $password))
    {
        // redirect to the easyStyleMain.html page
        closeConnect($conn);
        header("Location: easyStyleMain.html");
    }
    // else if the query returns empty, the username and password are invalid
        else
    {
        // pop-up informing user of invalid username and password
        closeConnect($conn);
        $_SESSION['error'] = "Invalid username or password";
        header("Location: easyStyleLogin.php");
    }
die();
