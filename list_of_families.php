<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
include_once './activityeligibility.php';

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

 } else {
    header("location:index.php");
}

error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv=Content-Type content="text/html; charset=utf8_general_ci" />
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
        <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/datatables_responsive.js"></script>
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
                    </div>
                    <!-- /page header -->

                    <div class="content">
                        <!-- Toolbar -->
                        <div class="navbar navbar-default navbar-component navbar-xs">
                            <ul class="nav navbar-nav visible-xs-block">
                                <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
                            </ul>

                            <div class="navbar-collapse collapse" id="navbar-filter">
                                <ul class="nav navbar-nav element-active-slate-400">
                                    <li><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>List of Families</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Media library -->
                        <div class="panel panel-flat">
                            <?php
                            $selectRes = mysql_query("SET NAMES utf8");
                            $selectSQL = 'SELECT family_master.family_phone,village_master.village_name,family_member_master.fm_occupation_id,family_member_master.fm_per_month_salary,family_master.family_id,family_member_master.fm_member_name FROM family_master INNER JOIN family_member_master ON family_master.family_id = family_member_master.family_id INNER JOIN village_master ON family_master.village_id = village_master.village_id WHERE family_member_master.fm_status = 1 AND family_master.activity_status = 0';
                            if (!( $selectRes = mysql_query($selectSQL) )) {
                                echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
                            } else {
                                ?>                                 
                                <table class="table datatable-responsive">
                                    <thead>
                                        <tr>
                                            <th>Preview</th>
                                            <th>Village Name</th>
                                            <th>Name of Family Head</th>
                                            <th>Occupation</th>
                                            <th>Monthly Income (Rs)</th>
                                            <th>Telephone/ land line no</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysql_num_rows($selectRes) == 0) {
                                            echo '<tr><td>No Rows Returned</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                                        } else {
                                            while ($row = mysql_fetch_assoc($selectRes)) {
                                                $family_id = $row['family_id'];
                                                $vname = $row['village_name'];
                                                $headname = $row['fm_member_name'];
                                                $occupation = $row['fm_occupation_id'];
                                                $salary = $row['fm_per_month_salary'];
                                                $contact = $row['family_phone'];
                                                ?>
                                                <tr id="family_del<?php echo $family_id; ?>">
                                                    <td><a href='assets/images/placeholder.jpg' data-popup='lightbox'><img src='assets/images/placeholder.jpg' alt='' class='img-rounded img-preview'></a></td>
                                                    <td><?php echo $vname ?></td>
                                                    <td><?php echo $headname ?></a></td>
                                                    <td><?php echo $occupation ?></td>
                                                    <td><?php echo $salary ?></a></td>
                                                    <td><?php echo $contact ?></td>
                                                    <td class="text-center">
                                                        <form name="form" method="POST" action="activityeligibility.php">
                                                            <input value="<?php echo $family_id; ?>" type="hidden" name="familyid" name="familyid">
                                                            <button type="submit" name="btn-save" class="btn bg-teal-400">Select<i class="icon-arrow-right14 position-right"></i></button>
                                                        </form>                                                        
                                                    </td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- /media library -->

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


