<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
$db_handle = new DB_Functions();

ini_set('max_execution_time', 3000);
//mysql_set_charset("UTF8");
$login_id = $_SESSION['login_id'];
$login_uid = $_SESSION['login_uid'];
$login_type = $_SESSION['login_type'];
if ($login_id != "") {
    $admin_id = $_SESSION['login_id'];
    $result_sa = mysql_query("SELECT * from register_master WHERE reg_id = '$login_uid'");
    $data_sa = mysql_fetch_array($result_sa);
    $reg_id = $data_sa['reg_id'];
    $reg_name = $data_sa['reg_first_name'] . ' ' . $data_sa['reg_last_name'];
    $reg_img = $data_sa['reg_profile_img_path'];
    $reg_desi = $data_sa['reg_designation'];
    $reg_email = $data_sa['reg_user_email'];
    $reg_phone = $data_sa['reg_contact_no'];

    $family_sql = mysql_query("SELECT * from family_master");
    $family_row = mysql_num_rows($family_sql);
} else {
    header("location:index.php");
}

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

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

if (isset($_POST['btn-update'])) { // Has the image been uploaded?
    $fname = $_POST['reg_first_name'];
    $lname = $_POST['reg_last_name'];
    $email = $_POST['reg_user_email'];
    $designation = $_POST['reg_designation'];
    $contact = $_POST['reg_contact_no'];
    $address = $_POST['reg_address'];
    $district = $_POST['district'];
    $block = $_POST['block'];
    $cluster = $_POST['cluster'];

    $ip = ipCheck();
    $sql_query = "update register_master set reg_first_name='$fname',reg_last_name='$lname',reg_designation='$designation',reg_district = '$district',reg_block = '$block',reg_cluster = '$cluster',reg_contact_no='$contact',reg_address='$address',reg_device_id= '$ip',reg_modified_date= STR_TO_DATE('$date', '%m/%d/%Y%h:%i') where reg_id='$login_uid'";
    mysql_query($sql_query);
    $sql_query1 = "update login_master set login_type='$designation',reg_device_id= '$ip',reg_modified_date= STR_TO_DATE('$date', '%m/%d/%Y%h:%i') where login_uid='$login_uid'";

    if (mysql_query($sql_query1)) {
        ?>
        <script type="text/javascript">
            window.location.href = 'dashboard.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert('error occured while updating your data');
        </script>
        <?php
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
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="assets/js/plugins/forms/wizards/stepy.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jasny_bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/datepicker.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/effects.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/notifications/jgrowl.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/anytime.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.date.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.time.js"></script>
        <script type="text/javascript" src="assets/js/plugins/pickers/pickadate/legacy.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/wizard_stepy.js"></script>
        <script type="text/javascript" src="assets/js/pages/picker_date.js"></script>
        <script type="text/javascript" src="assets/js/pages/form_multiselect.js"></script>
        
    </head>

    <body>
        <input type="hidden" name="userType" id="userType" value=<?php echo $login_type; ?> >
        <!-- Main navbar -->
        <?php include 'include/header.php'; ?>
        <!-- /main navbar -->

        <!-- Page container -->
        <div class="page-container login-container" style="min-height:933px">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main sidebar -->
                <?php include 'include/sidemenu.php'; ?>
                <!-- /main sidebar -->

                <!-- Content area -->
                <div class="content">


                    <?php
                    $officer_sql = mysql_query("SELECT * FROM register_master WHERE reg_id = $login_uid");
                    $officer_row = mysql_fetch_array($officer_sql);
                    $regid = $officer_row['reg_id'];
                    $fname = $officer_row['reg_first_name'];
                    $lname = $officer_row['reg_last_name'];
                    $email = $officer_row['reg_user_email'];
                    $designation = $officer_row['reg_designation'];
                    $contact = $officer_row['reg_contact_no'];
                    $address = $officer_row['reg_address'];
                    $district = $officer_row['reg_district'];
                    $block = $officer_row['reg_block'];
                    $cluster = $officer_row['reg_cluster'];
                    ?>  
                    <form enctype="multipart/form-data" action="" method="POST">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="text-left">
                                            <h5 class="content-group-lg">Update account <small class="display-block">All fields are required</small></h5>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" id="reg_first_name" value="<?php echo $fname; ?>" placeholder="First name" name="reg_first_name">
                                                    <div class="form-control-feedback">
                                                        <i class="icon-user-check text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" value="<?php echo $lname; ?>" placeholder="Second name" id="reg_last_name" name="reg_last_name">
                                                    <div class="form-control-feedback">
                                                        <i class="icon-user-check text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                       

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <input type="email" class="form-control" value="<?php echo $email; ?>" name="reg_user_email" id="reg_user_email" placeholder="Your email">
                                                    <div class="form-control-feedback">
                                                        <i class="icon-mention text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <input type="text" name="reg_contact_no" id="reg_contact_no" value="<?php echo $contact; ?>" class="form-control" placeholder="Your number">
                                                    <div class="form-control-feedback">
                                                        <i class="icon-phone2 text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <textarea name="reg_address" name="reg_address" id="reg_address" rows="1" cols="4" placeholder="Address" class="form-control"><?php echo $address; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <select name="reg_designation" class="form-control" id="reg_designation" onchange="showhide()">
                                                        <option value="<?php echo $designation; ?>"><?php
                                                            if ($designation == 'projectmanager'):
                                                                echo "Project Manager";
                                                            elseif ($designation == 'administrator'):
                                                                echo "Administrator";
                                                            elseif ($designation == 'blockcoordinator'):
                                                                echo "Block Coordinator";
                                                            elseif ($designation == 'guest'):
                                                                echo "Guest";                                                            
                                                            else:
                                                                echo "None";
                                                            endif;
                                                            ?></option>
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
                                            <a href="dashboard.php" class="btn btn-link"><i class="icon-arrow-left13 position-left"></i> Back to Home..</a>
                                            <button type="submit" name="btn-update" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-10"><b><i class="icon-plus3"></i></b> Update account</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /registration form -->
                    <!-- Footer -->
                    <?php include 'include/footer.php'; ?>
                    <!-- /footer -->
                </div>
                <!-- /content area -->              
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->  
        
    </body>
</html>


