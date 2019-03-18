<?php
session_start();
include_once 'include/DB_Functions.php';
$db = new DB_Functions();
include './family_activities_insert.php';

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

$fm_id = $_GET['family_id'];
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DBMG</title>

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

        <script type="text/javascript">
                $(function () {
                    $("#btnsave").show();
                    $("#appyes").on("input", function () {
                        $("#btnsave").toggle();
                    });
                });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='approval']").click(function () {
                    if ($("#appno").is(":checked")) {

                        alert("Please select another Activity");
                        document.getElementById("btnsave").disabled = true;
                    }
                    if ($("#appyes").is(":checked")) {
                        document.getElementById("btnsave").disabled = false;
                    }
                });
            });
        </script>        
        <script type="text/javascript">
            function myFunction() {
                document.getElementById("btnsave").disabled = true;
            }
        </script>

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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>Activities</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /toolbar -->

                    </div>
                    <!-- /page header -->
                    <!-- Content area -->
                    <div class="content">
                        <form id="idform" name="idform" method="post">
                            <!-- User profile -->
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="tabbable">
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="activity">

                                                <!-- Media library -->
                                                <div class="panel panel-white">
                                                    <div class="panel-heading">
                                                        <h6 class="panel-title text-semibold">List Of Activities</h6>
                                                        <div class="heading-elements">
                                                            <ul class="icons-list">
                                                                <li><a data-action="collapse"></a></li>
                                                                <li><a data-action="reload"></a></li>
                                                                <li><a data-action="close"></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $selectSQL = "SELECT activity_allocation_master.allocate_id,activity_allocation_master.family_id,activity_allocation_master.activity_id FROM activity_allocation_master WHERE activity_allocation_master.family_id = $fm_id";
                                                    if (!( $selectRes = mysql_query($selectSQL) )) {
                                                        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
                                                    } else {
                                                        ?>
                                                        <table class="table table-striped media-library table-lg">
                                                            <thead>
                                                                <tr>
                                                                    <th>Activity/Intervention</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>                                                           
                                                                <?php
                                                                if (mysql_num_rows($selectRes) == 0) {
                                                                    echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                                                                } else {
                                                                    while ($row = mysql_fetch_assoc($selectRes)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row['activity_id'] ?></td>
                                                                            <td>
                                                                                <button class="btn bg-teal-400 btn-xs"><a href="family_activities.php?allocate_id=<?php echo $row['allocate_id'] ?>&activity_id=<?php echo $row['activity_id'] ?>&family_id=<?php echo $row['family_id'] ?>" style="color:white">&nbsp;Select&nbsp;</a></button></td>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>                                                                        
                                                            </tbody>
                                                        </table> 
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                $_SESSION['get_allocate_id'] = $_GET['allocate_id'];
                                                $get_allocate_id = $_SESSION['get_allocate_id'];
                                                $_SESSION['get_activity'] = $_GET['activity_id'];
                                                $get_activity = $_SESSION['get_activity'];
                                                ?>
                                                <div id="allocate_id" class = "form-group">
                                                    <input type = "hidden" id="allocate_id" name = "allocate_id" value="<?php echo $get_allocate_id; ?>" class = "form-control">
                                                </div>
                                                <div id="family_id" class = "form-group">
                                                    <input type = "hidden" id="family_id" name = "family_id" value="<?php echo $fm_id; ?>" class = "form-control">
                                                </div>                                                
                                                <div id="activity_id" class = "form-group">
                                                    <label>Activity Name</label>
                                                    <input type = "text" id="activity_id" name = "activity_id" value="<?php echo $get_activity; ?>" class = "form-control">
                                                </div><br/>
                                                <div id="approval" class = "form-group">
                                                    <label>Approval of Concern Authority granted for the Beneficiary?</label>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="radio-inline"><input type="radio" name="approval" id="appyes" value="Yes">Yes</label> 
                                                    <label class="radio-inline"><input type="radio" name="approval" id="appno" value="No">No</label>
                                                </div><br/>
                                                <div class="form-group">
                                                    <label>Why the beneficiary is not ready to take the benefit of any listed activities?</label>
                                                    <input type="text" name="reason" class="form-control" placeholder="Specify Reason..">
                                                </div>
                                                <!-- /media library -->

                                                <div class="text-right">
                                                    <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">Submit<i class="icon-arrow-right14 position-right"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <?php
                                    $SQL = "SELECT family_master.family_id,family_member_master.fm_member_name FROM family_master INNER JOIN family_member_master ON family_master.family_id = family_member_master.family_id WHERE family_master.family_id = $fm_id and family_member_master.fm_status = 1";
                                    if (!( $selectRes = mysql_query($SQL) )) {
                                        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
                                    } else {
                                        if (mysql_num_rows($selectRes) == 0) {
                                            echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                                        } else {
                                            while ($row = mysql_fetch_assoc($selectRes)) {
                                                ?>

                                                <!-- User thumbnail -->
                                                <div class="thumbnail">
                                                    <div class="thumb thumb-rounded thumb-slide">
                                                        <img src="assets/images/placeholder.jpg" alt="">
                                                        <div class="caption">
                                                            <span>
                                                                <a href="#" class="btn bg-success-400 btn-icon btn-xs" data-popup="lightbox"><i class="icon-plus2"></i></a>
                                                                <a href="user_pages_profile.html" class="btn bg-success-400 btn-icon btn-xs"><i class="icon-link"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="caption text-center">
                                                        <h6 class="text-semibold no-margin"><?php echo $row['fm_member_name'] ?></h6>
                                                    </div>
                                                </div>
                                                <!-- /user thumbnail -->
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- /user profile -->

                            <!-- Footer -->
<?php include 'include/footer.php'; ?>
                            <!-- /footer -->

                        </form>                           
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


