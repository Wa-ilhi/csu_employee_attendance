<?php
session_start();

if (empty($_SESSION['name'])) {
  header('location:index.php');
}

include('header.php');
include('includes/connection.php');

$id = $_SESSION['id'];
$shift = pg_fetch_assoc(pg_query($connection, "SELECT shift FROM tbl_employee WHERE id='$id'"));
$emp = pg_fetch_assoc(pg_query($connection, "SELECT * FROM tbl_employee WHERE id='$id'"));
$empid = $emp['employee_id'];
$dept = $emp['department'];

$currDate = date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

$intime = "";
$outtime = "";
$shiftTime = substr($shift['shift'], 0, 8);

if (time() > strtotime($shiftTime)) {
  $intime = "Late";
} else {
  $intime = "On Time";
}

$outShiftTime = substr($shift['shift'], -8);

if (time() > strtotime($outShiftTime)) {
  $outtime = "Over Time";
} else {
  $outtime = "Early";
}

$error_message = '';
$success_message = '';

if (isset($_POST['turn-it'])) {
  $shift = $shift['shift'];
  $department = $dept;
  $location = $_POST['location'];
  $msg = $_POST['msg'];
  $meetTopic = $_POST['meet_topic'];
  $employeeId = $empid;
  $date = $currDate;
  $checkIn = $currentTime;
  $inStatus = $intime;

  //trigger executed
  try {
    $insertQuery = pg_query($connection, "INSERT INTO tbl_attendance (employee_id, department, shift, location, message, meet_topic, date, check_in, in_status, check_out, out_status) VALUES ('$employeeId', '$department', '$shift', '$location', '$msg', '$meetTopic', '$date', '$checkIn', '$inStatus', NOW(), '$outtime')");
    if (!$insertQuery) {
      throw new Exception(pg_last_error($connection));
    }
    $success_message = "Attendance recorded successfully!";
  } catch (Exception $e) {
    $error_message = "Employee is already checked-in for the day. ";
  }
}

$fetchAttendance = pg_query($connection, "SELECT date FROM employee_attendance_view WHERE check_out='00:00:00' AND employee_id='$empid'");
$rows = pg_num_rows($fetchAttendance);


?>

<div class="page-wrapper">
  <div class="content">
    <div class="row">
      <div class="col-sm-4">
        <h4 class="page-title">Attendance Form</h4>
      </div>
    </div>

    <?php if (!empty($error_message)) { ?>
      <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } elseif (!empty($success_message)) { ?>
      <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } ?>

    <?php if ($rows == 0) { ?>
      <div class="col-lg-8 offset-lg-2">
        <form method="post">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Shift <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="shift" value="<?php echo $shift['shift']; ?>" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Meeting Topic <span class="text-danger">*</span></label>
                <select class="select" name="meet_topic" required>
                  <option value="">Select</option>
                  <?php
                  $fetchMeetings = pg_query($connection, "SELECT meet_topic FROM tbl_meeting");
                  while ($meeting = pg_fetch_assoc($fetchMeetings)) {
                  ?>
                    <option value="<?php echo $meeting['meet_topic']; ?>"><?php echo $meeting['meet_topic']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Location <span class="text-danger">*</span></label>
                <select class="select" name="location" required>
                  <option value="">Select</option>
                  <?php
                  $fetchLocations = pg_query($connection, "SELECT location FROM tbl_location");
                  while ($loc = pg_fetch_assoc($fetchLocations)) {
                  ?>
                    <option value="<?php echo $loc['location']; ?>"><?php echo $loc['location']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Message </label>
                <textarea class="form-control" name="msg"></textarea>
              </div>
            </div>
          </div>
          <div class="m-t-20 text-center">
            <button class="btn btn-primary submit-btn" name="turn-it"><img src="assets/img/login.png" width="40"> Turn It!</button>
          </div>
        </form>
      </div>
    <?php } else { ?>
      <div class="col-lg-12 offset-lg-2">
        <div class="row">
          <div class="col-sm-6">
            <center>
              <h3>Thank You For Today</h3>
            </center>
            <form method="post">
              <div class="m-t-20 text-center">
                <?php
                $currDate = date('Y-m-d');
                $fetchCheckout = pg_query($connection, "SELECT out_status FROM employee_attendance_view  WHERE date='$currDate' AND employee_id='$empid'");
                $result = pg_fetch_assoc($fetchCheckout);
                $result = $result['out_status'];

                if ($result == 'Pending' || $checkoutStatus == 1) {
                ?>
                  <button class="btn btn-primary submit-btn" name="check-out" onclick="return confirmDelete()"><img src="assets/img/login.png" width="40"> Check Out!</button>
                <?php  } else { ?>
                  <button class="btn btn-primary submit-btn" name="check-out" onclick="return confirmDelete()"><img src="assets/img/login.png" width="40"> Done!</button>
                  <h5>See you tomorrow!</h5>
                <?php } ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php
include('footer.php');
?>

<script language="JavaScript" type="text/javascript">
  function confirmDelete() {
    return confirm('Are you sure want to check out now?');
  }
</script>