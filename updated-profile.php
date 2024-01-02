<?php
session_start();
include('includes/connection.php');

if (isset($_POST['update_profile'])) {
    $id = $_SESSION['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['pwd'];
    $emailid = $_POST['emailid'];

    // You may want to perform additional validation and sanitization here

    // Update the profile in the database
    $update_query = pg_query($connection, "UPDATE tbl_employee SET
        first_name='$first_name',
        last_name='$last_name',
        password='$password',
        emailid='$emailid'
        WHERE id='$id'
    ");

    if ($update_query) {
        // If the update is successful, you can redirect the user or show a success message
        header('location: profile.php');
        exit();
    } else {
        // If the update fails, you can redirect with an error message
        header('location: update-profile.php?error=1');
        exit();
    }
} else {
    // Redirect to the update-profile.php page if the form was not submitted
    header('location: update-profile.php');
    exit();
}
