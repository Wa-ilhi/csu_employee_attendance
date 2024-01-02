<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Employee Attendance Management System</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<?php
session_start();
include('includes/connection.php');

if (isset($_REQUEST['login'])) {
    $username = pg_escape_string($connection, $_REQUEST['username']);
    $pwd = pg_escape_string($connection, $_REQUEST['pwd']);

    // Use pg_query_params to prevent SQL injection
    $fetch_query = pg_query_params($connection, "SELECT * FROM tbl_employee WHERE username = $1 AND password = $2 AND role = $3", array($username, $pwd, '0'));

    if ($fetch_query === false) {
        die("Query failed: " . pg_last_error($connection));
    }

    // Use pg_num_rows and pg_fetch_assoc for PostgreSQL
    $res = pg_num_rows($fetch_query);

    if ($res > 0) {
        $data = pg_fetch_assoc($fetch_query);
        $name = $data['first_name'] . ' ' . $data['last_name'];
        $role = $data['role'];
        $id = $data['id'];
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;
        $_SESSION['id'] = $id;
        header('location:profile.php');
    } else {
        $msg = "Incorrect login details.";
    }
}
?>

<body>
    <div class="main-wrapper account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form method="post" class="form-signin">
                        <div class="account-logo">
                            <h3>Employee Attendance Management</h3>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" autofocus="" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pwd" required>
                        </div>
                        <span style="color:red;"><?php if (!empty($msg)) {
                                                        echo $msg;
                                                    } ?></span>
                        <br>
                        <div class="form-group text-center">
                            <button type="submit" name="login" class="btn btn-primary account-btn">Login</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>