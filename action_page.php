<!-- This file is used to authenticate the user. It calls the authenticateUser function from db_connection.php. -->

<?php
require_once 'db_connection.php';

// assign the username and password posted from Loginlanding.html to a variable
$username = $_POST['username'];
$password = $_POST['password'];

// connect to the database
$conn = openConnect();

/* call the authenticateUser function from db_connection.php. */
authenticateUser($conn, $username, $password);

