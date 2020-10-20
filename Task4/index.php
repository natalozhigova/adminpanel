<?php
require 'connect.php';

if ((isset($_POST['username'])) && (isset($_POST['password'])) && (isset($_POST['email']))) {
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $date = date("Y-m-d H:i:s");
    $date_registration=$date;
    $date_last_login = $date;
    $state = "offline";

    $query = "INSERT INTO users (email,username, password, data_registration, data_last_login, state, time)
    VALUES ('$email','$username',' $password','$date_registration','$date_last_login','$state', UNIX_TIMESTAMP())";
    if (!empty($connection)) {
        $result = mysqli_query($connection, $query);
        if ($result) {
            $successMessage = "Sign up was success. Please Log in";
        } else {
            $falseMessage = "Error. Try it again";
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
        <h2>Sign Up</h2>
        <?php if (isset($successMessage) ) { ?> <div class="alert-success" role="alert"><?php  echo $successMessage;?></div> <?php }?>
        <?php if (isset($falseMessage) ) { ?> <div class="alert-danger" role="alert"><?php  echo $falseMessage;?></div> <?php } ?>
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">sign up</button>
        <a class="btn btn-lg btn-primary btn-block" href="login.php">log in</a>
    </form>
</div>
</body>
</html>


