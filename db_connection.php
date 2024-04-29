<?php
ini_set('display_errors', 1);
// Purpose: This file contains the functions that are related to connections to the database. NOTE: Since
//this script consists only of PHP code, there is no tag closer as per convention.
// this function opens the connection to the database and sets the default database. This eliminates the need to call
// mysqli_select_db() in the future. This function should be called as late as possible in each  script that needs to
// connect to the database (i.e. if we're querying the DB).
function openConnect()
    {
        $dbHost = "mysql.eecs.ku.edu";
        $dbUser = "447s24_fullmage72";
        $dbPassword = "Ae9aes4H";
        $dbName = "447s24_fullmage72";
        $connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName) or die("Connection failed");
        return $connection;
    }

// this function selects the database. Keeping this in the code for now, there's a chance that we'll need it if we have
// to convert from the mysqli functions back to mysql functions. I'm contacting Prof. Luo about this.
//function selectDB()
//    {
//        mysqli_select_db($dbName) or die("Database selection failed: " . mysqli_error());
//    }

// This function closes the connection. It should be called as soon as possible after the connection is no longer needed.
function closeConnect($connection)
    {
        mysqli_close($connection);
    }

function queryDB($connection, $query)
    {
        $result = mysqli_query($connection, $query) or die("Query failed");
        return $result;
    }

/* This function authenticates the user against the User table in the database. If successful, redirects to main page.
  If failure, a pop-up informs user of the failure. */
  function authenticateUser($connection, $username, $password)
  {
      $sql = "SELECT * FROM USERS WHERE UNAME = ?";
      $stmt = mysqli_prepare($connection, $sql);
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result && mysqli_num_rows($result) > 0)
      {
          $user = mysqli_fetch_assoc($result);
          $hashedPassword = $user['PWORD']; // Get the hashed password from the database
          if (password_verify($password, $hashedPassword))
          // redirect to the MainLanding.html page
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      // else if the query returns empty, the username and password are invalid
      else
      {
          return false;
      }
  }