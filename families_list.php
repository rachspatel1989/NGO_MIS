<?php
# Init the MySQL Connection
session_start();
include_once 'include/DB_Functions.php';
$db_handle = new DB_Functions();
$query = "SELECT * FROM district_master";
$results = $db_handle->runQuery($query);

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
if (isset($_GET['q']) == 'logout') {
    header("location:index.php");
}
error_reporting(E_ALL ^ E_NOTICE);
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

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>District name:</label>
                                    <select name="district" id="district-list" class="form-control" onChange="getBlock(this.value);">                                       
                                        <option value="">Select District</option>
                                        <?php
                                        foreach ($results as $district) {
                                            ?>
                                            <option value="<?php echo $district["district_id"]; ?>"><?php echo $district["district_name"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>                                                       
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Block name:</label>
                                    <select name="block" id="block-list" class="form-control" onChange="getCluster(this.value);">
                                        <option value="">Select Block</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cluster name:</label>
                                    <select name="cluster" id="cluster-list" class="form-control" onChange="getGP(this.value);">
                                        <option value="select">Select Cluster</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>GP name:</label>
                                    <select name="gp" id="gp-list" class="form-control" onChange="getVillage(this.value);">
                                        <option value="select">Select GP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Village name:</label>
                                    <select name="village" id="village-list" class="form-control" onChange="getdata(this.value)">
                                        <option value="select">Select Village</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="content">
                            <!-- Media library -->
                            <div class="panel panel-flat"> 
                                <?php
                                if (empty($_POST["village_name"])) {
                                    # Prepare the SELECT Query
                                    $selectSQL = "SELECT * FROM list_of_families";
                                    # Execute the SELECT Query
                                    if (!( $selectRes = mysql_query($selectSQL) )) {
                                        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
                                    } else {
                                        ?>
                                        <table name="familylist" id="family-list" class="table datatable-responsive">
                                            <thead>
                                                <tr>                                            
                                                    <th>Village Name</th>
                                                    <th>Name of Family Head</th>
                                                    <th>Selection Year</th>
                                                    <th>Poverty Status</th>
                                                    <th>Total Land</th>
                                                    <th>Cultivable Land</th>
                                                    <th>Irrigated Land</th>
                                                    <th>Monthly Income (Rs)</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                if (mysql_num_rows($selectRes) == 0) {
                                                    echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                                                } else {
                                                    while ($row = mysql_fetch_assoc($selectRes)) {
                                                        echo "<tr>"
                                                        . "<td>{$row['village_name']}</td>"
                                                        . "<td>{$row['family_head']}</td>"
                                                        . "<td>{$row['selection_year']}</td>"
                                                        . "<td>{$row['poverty_status']}</td>"
                                                        . "<td>{$row['total_land']}</td>"
                                                        . "<td>{$row['cultivable_land']}</td>"
                                                        . "<td>{$row['irrigated_land']}</td>"
                                                        . "<td>{$row['monthly_income']}</td>"
                                                        . "</tr>\n";
                                                    }
                                                }
                                                ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                }
                                ?>                             
                            </div>
                        </div>
                        <!-- Footer -->
                        <?php include 'include/footer.php'; ?>
                        <!-- /footer -->
                    </div>
                    <!-- /main content -->
                </div>
                <!-- /page content -->
            </div>
        </div>
            <!-- /page container -->
            <script type="text/javascript">
                function getBlock(val) {
                    $.ajax({
                        type: "POST",
                        url: "include/get_block.php",
                        data: 'district_id=' + val,
                        success: function (data) {
                            $("#block-list").html(data);
                        }
                    });
                }

                function getCluster(val) {
                    $.ajax({
                        type: "POST",
                        url: "include/get_cluster.php",
                        data: 'block_id=' + val,
                        success: function (data) {
                            $("#cluster-list").html(data);
                        }
                    });
                }

                function getGP(val) {
                    $.ajax({
                        type: "POST",
                        url: "include/get_gp.php",
                        data: 'cluster_id=' + val,
                        success: function (data) {
                            $("#gp-list").html(data);
                        }
                    });
                }

                function getVillage(val) {
                    $.ajax({
                        type: "POST",
                        url: "include/getfamiliyvillage.php",
                        data: 'gp_id=' + val,
                        success: function (data) {
                            $("#village-list").html(data);
                        }
                    });
                }
                function getdata(val)
                {
                    $.ajax({
                        type: "POST",
                        url: "include/get_familylist.php",
                        data: 'village_name=' + val,
                        success: function (data) {
                            $("#family-list").html(data);
                        }
                    });
                    return false;
                }

                function selectDistrict(val) {
                    $("#search-box").val(val);
                    $("#suggesstion-box").hide();
                }
            </script>
    </body>
</html>