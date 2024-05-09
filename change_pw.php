<?php
ini_set('display_errors', 1);
require_once 'db_connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $conn = openConnect();

    if (authenticateUser($conn, $username, $current_password)) {
        if ($new_password == $confirm_password) {
            $sql = "UPDATE USERS SET PWORD = ? WHERE UNAME = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $new_password, $username);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                closeConnect($conn);
                header("Location: password_change_success.html"); // Redirect to a success page
            } else {
                $_SESSION['error'] = "Failed to update password";
                header("Location: change_pw.php");
            }
        } else {
            $_SESSION['error'] = "New password and confirmation password do not match";
            header("Location: change_pw.php");
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect";
        header("Location: change_pw.php");
    }

    die();
} else {
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
}
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Change Password</title>
    </head>
    <body>
    <h2>Change Password</h2>
    <form action="change_pw.php" method="post">
        <div class="container">
            <label for="username"><b>Username</b></label>
            <input type="text" id="username" placeholder="Enter Username" name="username" required>
            <br>
            <label for="current_password"><b>Current Password</b></label>
            <input type="password" id="current_password" placeholder="Enter Current Password" name="current_password" required>
            <br>
            <label for="new_password"><b>New Password</b></label>
            <input type="password" id="new_password" placeholder="Enter New Password" name="new_password" required>
            <br>
            <label for="confirm_password"><b>Confirm New Password</b></label>
            <input type="password" id="confirm_password" placeholder="Confirm New Password" name="confirm_password" required>
            <br>
            <button type="submit">Change Password</button>
        </div>
    </form>
    </body>
    </html>
