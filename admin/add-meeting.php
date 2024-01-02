<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');

if (isset($_REQUEST['add-meeting'])) {
    $meet_topic = $_REQUEST['meet_topic'];
    $start_time = $_REQUEST['starttime'];
    $end_time = $_REQUEST['endtime'];
    $date = $_REQUEST['date'];
    $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0; // Set the default status to 0 (Inactive) if not selected

    $insert_query = pg_query($connection, "INSERT INTO tbl_meeting (meet_topic, start_time, end_time, meet_date, status) 
                                           VALUES ('$meet_topic', '$start_time', '$end_time', '$date', '$status')");

    if ($insert_query > 0) {
        $msg = "Meeting created successfully";
    } else {
        $msg = "Error!";
    }
}
?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Add Meeting</h4>
            </div>
            <div class="col-sm-8 text-right m-b-20">
                <a href="meeting.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post">
                    <div class="form-group">
                        <label>Meeting Topic</label>
                        <input type="text" class="form-control" name="meet_topic" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Time</label>
                                <div class="time-icon">
                                    <input type="text" class="form-control" id="datetimepicker3" name="starttime" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Time</label>
                                <div class="time-icon">
                                    <input type="text" class="form-control" id="datetimepicker4" name="endtime" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Meeting Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="meeting_active" value="1" checked>
                            <label class="form-check-label" for="meeting_active">
                                Active
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="meeting_inactive" value="0">
                            <label class="form-check-label" for="meeting_inactive">
                                Inactive
                            </label>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button name="add-meeting" class="btn btn-primary submit-btn">Add Meeting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>