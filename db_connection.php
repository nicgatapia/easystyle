<!-- Purpose: This file contains the functions that are used to control the connection to the database. NOTE: Since
this script consists only of PHP code, there is no closing ?> as per convention.-->

<?php
// this function opens the connection to the database and sets the default database. This eliminates the need to call
// mysqli_select_db() in the future. This function should be called as late as possible in each  script that needs to
// connect to the database (i.e. if we're querying the DB).
function openConnect()
    {
        $dbHost = "mysql.eecs.ku.edu";
        $dbUser = "447s24_fullmage72";
        $dbPassword = "Ae9aes4H";
        $dbName = "";
        $connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName) or die("Connection failed: " . mysqli_error());
        return $connection;
    }

// this function selects the database. Keeping this in the code for now, there's a chance that we'll need it if we have
// to convert from the mysqli functions back to mysql functions. I'm contacting Prof. Luo about this.
//function selectDB()
//    {
//        mysqli_select_db($dbName) or die("Database selection failed: " . mysqli_error());
//    }

//this function closes the connection. It should be called as soon as possible after the connection is no longer needed.
function closeConnect($connection)
    {
        mysqli_close($connection);
    }

// This function is used for all MySQL queries to the database.
function queryDB($connection, $query)
    {
        $result = mysqli_query($connection, $query) or die("Query failed");
        return $result;

/* This function authenticates the user against the User table in the database. If successful, redirects to main page.
   If failure, a pop-up informs user of the failure. */
function authenticateUser($connection, $username, $password)
    {
        $sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
        $result = queryDB($connection, $sql);
        if ($result)
        {
            // redirect to the MainLanding.html page
            header("Location: MainLanding.html");
            die(); // this is necessary to prevent the script from continuing to execute after the redirect
        }
        else
        {
            // create a pop-up window that says "Invalid username or password"
            echo "<script type='text/javascript'>alert('Invalid username or password');</script>";
        }
    }
