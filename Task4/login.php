<?php session_start();
require 'connect.php';

if ((isset($_POST['email'])) && (isset($_POST['password']))) {
$email = $_POST['email'];
$password = $_POST['password'];
$date = date("Y-m-d H:i:s");
$date_last_login = $date;
$state = "online";

$query = "SELECT * FROM users WHERE email='$email' and password='$password'";
if (!empty($connection)) {
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    while ($row = $result->fetch_row()) {
        $id = $row[0];
        $username = $row[2];
        $status = $row[6];
        $time = $row[7];

        $count = mysqli_num_rows($result);
        if (($count == 1) && ($status == 'block')) {
            $falseMessage0 = "Hello, '$username'! You are blocked. Contact administrator";
        } else if (($count == 1) && ($status == 'offline')) {
            $_SESSION['username'] = $username;
            $query1 = "UPDATE users SET state='online', data_last_login='$date_last_login', time=UNIX_TIMESTAMP() WHERE id='$id' ";
            $result1 = mysqli_query($connection, $query1) or die(mysqli_error($connection));
        }else if (($count == 1) && ($status == 'online')) {
            $_SESSION['username'] = $username;
        } else {
            $falseMessage = "Error. Try it again";
        }
    }
}
if (isset($falseMessage0)) {
    echo $falseMessage0;
} else {
    if (isset($_SESSION['username']) == $username) {
        header("Location: userTable.php");
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css"
    <title></title>
</head>
<body>
<div class="container">
    <form class="form-signin" method="POST">
        <h2>Log In</h2>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">log in</button>
        <a class="btn btn-lg btn-primary btn-block" href="index.php">sign up</a>
    </form>
</div>

</body>
</html>
