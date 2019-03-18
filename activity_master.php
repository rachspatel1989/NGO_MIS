<?php
session_start();
include_once 'include/DB_Functions.php';
$db_handle = new DB_Functions();
$db = new DB_Functions();
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

    $query = "SELECT * FROM activity_sector_master";
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

    if (isset($_POST['btn-save'])) {

        $ip = ipCheck();
// receiving the post params
        $sector_id = $_POST['sector'];
        $activity_name = $_POST['activityname'];
        $activity_id = $_POST['activity_id'];
        $tempid = "";

        date_default_timezone_set('Asia/Kolkata');
        $date_cr = date('m/d/Y');
        $dt = date("Y/m/d", strtotime($date_cr));
        $St_Time = "01:00:00";
        $date = date('m/d/Y h:i:s a', time());
        $timestamp = strtotime($date);

        // check if patient already exists 
        if ($db->isActivityExisted($activity_name)) {
            // user already exists
            $response["response"] = 0;
            $response["message"] = $activity_name . "already exists";
            echo json_encode($response);
        } else {
            $user = $db->insertActivity($sector_id, $activity_name, $ip, $date, $timestamp, $tempid);
            if ($user) {
                ?>
                <script type="text/javascript">
                    alert('Data Are Inserted Successfully ');
                    window.location.href = 'list_of_activities.php';
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
} else {
    header("location:index.php");
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
        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/visualization/echarts/echarts.js"></script>

        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/user_pages_profile.js"></script>
        <!-- /theme JS files -->
    </head>

    <body>
        <input type="hidden" name="userType" id="userType" value=<?php echo $login_type; ?> >
        <!-- Main navbar -->
        <?php include 'include/header.php'; ?>
        <!-- /main navbar -->

        <!-- Page container -->
        <div class="page-container" style="min-height:933px">
            <!-- Page content -->
            <div class="page-content">

                <!-- Main sidebar -->
                <?php include 'include/sidemenu.php'; ?>
                <!-- /main sidebar -->

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Page header -->
                    <div class="page-header">
                        <div class="page-header-content">
                            <div class="page-title">
                                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Desh Bandhu & Manju Gupta (DBMG) Foundation</h4>
                            </div>
                        </div>
                        <!-- /header content -->
                        <!-- Toolbar -->
                        <div class="navbar navbar-default navbar-component navbar-xs">
                            <ul class="nav navbar-nav visible-xs-block">
                                <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
                            </ul>

                            <div class="navbar-collapse collapse" id="navbar-filter">
                                <ul class="nav navbar-nav element-active-slate-400">
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>Activity</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /toolbar -->
                    </div>
                    <!-- /page header -->

                    <!-- /page header -->
                    <!-- Content area -->
                    <div class="content">
                        <!-- Clickable title -->                        
                        <form method="post" id="myform">
                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="text-semibold">
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Sector name:</label>
                                                            <select name="sector" id="sector" class="form-control">                                       
                                                                <option value="">Select Sector</option>
                                                                <?php
                                                                foreach ($results as $sector) {
                                                                    ?>
                                                                    <option value="<?php echo $sector["sector_id"]; ?>"><?php echo $sector["sector_name"]; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label>Activity Name</label>
                                                            <input type="text" name="activityname" id="activityname" class="form-control" placeholder="Activity Name">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-right stepy-finish">
                                                    <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">Submit <i class="icon-arrow-right14 position-right"></i></button>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>                           
                        <!-- Footer -->
                        <?php include 'include/footer.php'; ?>
                        <!-- /footer -->

                    </div>
                    <!-- /content area -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

        </div>
        <!-- /page container -->

    </body>
</html>