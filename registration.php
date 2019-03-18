<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
$db_handle = new DB_Functions();

$query = "SELECT * FROM district_master";
$results = $db_handle->runQuery($query);

function ipCheck() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
//Is it a proxy address
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getid() {
    $result = mysql_query("SELECT * FROM register_master");
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
        $get = mysql_query("SELECT MAX(reg_unique_no) FROM register_master");
        $got = mysql_fetch_array($get);
        $next_id = $got['MAX(reg_unique_no)'] + 1;
        return $next_id;
    } else {
        $next_id = 1001;
        return $next_id;
    }
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

if (isset($_POST['btn-register'])) { // Has the image been uploaded?
    $reg_first_name = $_POST['reg_first_name'];
    $reg_last_name = $_POST['reg_last_name'];
    $reg_designation = $_POST['reg_designation'];
    $reg_user_email = $_POST['reg_user_email'];
    $reg_contact_no = $_POST['reg_contact_no'];
    $reg_address = $_POST['reg_address'];
    $reg_district = $_POST['district'];
    $reg_block = $_POST['block'];
    $reg_cluster = $_POST['cluster'];
    $tempid = "";
    $ip = ipCheck();

    $next_id = getid();
    $sql_query = "INSERT INTO register_master(reg_unique_no,reg_first_name,reg_last_name,reg_user_email,reg_designation,reg_district,reg_block,reg_cluster,reg_contact_no,reg_address,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$next_id','$reg_first_name','$reg_last_name','$reg_user_email','$reg_designation','$reg_district','$reg_block','$reg_cluster','$reg_contact_no','$reg_address','web','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')";
    mysql_query($sql_query);
    $sql_fetch = "SELECT reg_id FROM register_master where reg_user_email = '$reg_user_email'";
    if (!( $selectRes = mysql_query($sql_fetch) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        if (mysql_num_rows($selectRes) == 0) {
            echo 'No Rows Returned';
        } else {
            
        }
        while ($row = mysql_fetch_assoc($selectRes)) {
            $pwd = randomPassword();
            $regis_id = $row['reg_id'];
            $sql = "INSERT INTO login_master(login_uid,login_uname,login_password,login_type,status,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$regis_id','$reg_user_email','$pwd','$reg_designation','Active','web','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')";

            if (mysql_query($sql)) {
                ?>
                <script type="text/javascript">
                    window.location.href = 'index.php';
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    alert('error occured while inserting your data');
                </script>
                <?php
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Desh Bandhu & Manju Gupta (DBMG) Foundation</title>

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/nicescroll.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/drilldown.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/login.js"></script>
        <!-- /theme JS files -->

    </head>

    <body>
        <!-- Page container -->
        <div class="page-container login-container">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main content -->
                <div class="content-wrapper">
                    <br/><br/><br/><br/>
                    <!-- Registration form -->
                    <form enctype="multipart/form-data" action="" method="POST">
                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="panel registration-form">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                                            <h5 class="content-group-lg">Create account <small class="display-block">All fields are required</small></h5>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" id="reg_first_name" placeholder="First name" name="reg_first_name">
                                                    <div class="form-control-feedback">
                                                        <i class="icon-user-check text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" placeholder="Second name" id="reg_last_name" name="reg_last_name">
                                                    <div class="form-control-feedback">
                                                        <i class="icon-user-check text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <input type="email" class="form-control" name="reg_user_email" id="reg_user_email" placeholder="Your email">
                                                    <div class="form-control-feedback">
                                                        <i class="icon-mention text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <input type="text" name="reg_contact_no" id="reg_contact_no" class="form-control" placeholder="Your number">
                                                    <div class="form-control-feedback">
                                                        <i class="icon-phone2 text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <textarea name="reg_address" name="reg_address" id="reg_address" rows="1" cols="4" placeholder="Address" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <select name="reg_designation" class="form-control" id="reg_designation" onchange="showhide()">
                                                        <option value="null">Choose Designation</option>
                                                        <option value="administrator">Administrator</option>
                                                        <option value="projectmanager">Project Manager</option>
                                                        <option value="blockcoordinator">Block Coordinator</option>
                                                        <option value="guest">Guest</option>
                                                    </select>
                                                    <div class="form-control-feedback">
                                                        <i class="text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">											
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="styled">
                                                    Accept <a href="#">terms of service</a>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <a href="index.php" class="btn btn-link"><i class="icon-arrow-left13 position-left"></i> Back to Login..</a>
                                            <button type="submit" name="btn-register" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-10"><b><i class="icon-plus3"></i></b> Create account</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /registration form -->
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
            <!-- Footer -->
            <?php include 'include/footer.php'; ?>
            <!-- /footer -->
        </div>
        <!-- /page container -->

    </body>
</html>
