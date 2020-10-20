<?php session_start();
require 'connect.php';
$username = $_SESSION['username'];
$query00 = "SELECT username FROM users WHERE username='$username' and state='online'";
if (!empty($connection)) {
$result00 = mysqli_query($connection, $query00) or die(mysqli_error($connection));
if ((isset($_SESSION['username']) == '') || ($result00->fetch_row() == NULL)) {
    header("Location: login.php");
}
else {

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8_general_ci">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css"
    <title></title>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $("#form1 #select-all").click(function () {
            $("#form1 input[type='checkbox']").prop('checked', this.checked);
        });
    });
</script>
<br>
<form class="form-signin" id="form1" method="post">
    <a type="submit" class="btn btn-lg btn-primary btn-block " name="logout" href="logout.php">log out</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <th><input type="checkbox" id="select-all"/></th>
        <th>email</th>
        <th>username</th>
        <th>date_registration</th>
        <th>date_last_login</th>
        <th>status</th>

        <?php

        $query0 = "UPDATE users SET state='offline' WHERE time<UNIX_TIMESTAMP()-300 and state='online'";
        $result0 = mysqli_query($connection, $query0) or die(mysqli_error($connection));
        $query = "SELECT * FROM users";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        while ($row = $result->fetch_row()) {
            $email = $row[1];
            $username = $row[2];
            $date_registration = $row[4];
            $date_last_login = $row[5];
            $status = $row[6];
            $id = $row[0];
            echo "<tr><td><input type='checkbox' name='check[]' value='$id'/></td>
            <td>$email</td><td>$username</td><td>$date_registration</td><td>$date_last_login</td>
            <td>$status</td></tr>";
        }

        ?>
    </table>
    <button class="btn btn-lg btn-primary btn-group" type="submit" name='delete' value="delete">delete</button>
    <button class="btn btn-lg btn-primary btn-group" type="submit" name='block' value="block">block</button>
    <button class="btn btn-lg btn-primary btn-group" type="submit" name='unblock' value="delete">unblock</button>
    <br>
</form>

<?php

if (isset($_POST['delete'])) {
    if (isset($_POST['check'])) {
        foreach ($_POST['check'] as $value) {
            $query = "DELETE FROM users WHERE id='$value'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        }
    }
}

if (isset($_POST['block'])) {
    if (isset($_POST['check'])) {
        foreach ($_POST['check'] as $value) {
            $query = "UPDATE users SET state='block' WHERE id='$value'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        }
    }
}

if (isset($_POST['unblock'])) {
    if (isset($_POST['check'])) {
        foreach ($_POST['check'] as $value) {
            $query = "UPDATE users SET state='offline' WHERE id='$value'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        }
    }
}
}
}
?>
</body>
</html>


