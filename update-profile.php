<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');
$id = $_SESSION['id'];
$fetch_data = pg_query($connection, "select * from tbl_employee where id='$id'");
$res = pg_fetch_array($fetch_data);
?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                <div class="card-header">
                    <h4 class="page-title">Update Profile</h4>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Update Profile Form -->
                        <form method="post" action="updated-profile.php">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="first_name">First Name:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="first_name" value="<?php echo $res['first_name']; ?>" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="first_name">Last Name:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="last_name" value="<?php echo $res['last_name']; ?>" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="first_name">Password:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="pwd" value="<?php echo $res['password']; ?>" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="first_name">Email:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="emailid" value="<?php echo $res['emailid']; ?>" required>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </form>
                        <!-- End Update Profile Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>