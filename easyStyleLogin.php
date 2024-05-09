<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EasyStyleLogin</title>
</head>

<body>
<?php
session_start();
if (isset($_SESSION['error']))
{
    echo "<script type = 'text/javascript'>alert('".$_SESSION['error']."')</script>";
    unset($_SESSION['error']);
}
?>

<form action="action_page.php" method="post">
    <div class="container">
        <input type="text" id="uname" placeholder="Enter Username" name="uname" required>
        <label for="uname"><b>Username</b></label>
        <br>
        <input type="password" id="psw" placeholder="Enter Password" name="psw" required>
        <label for="psw"><b>Password</b></label>
        <br>
        <button type="submit">Login</button>
        <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <span class="psw">Forgot <a href="change_pw.php">password?</a></span>
    </div>
</form>
</body>
</html>