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

                        <div class="content">
                            <!-- Media library -->
                            <div class="panel panel-flat"> 
                                <?php
                                if (empty($_POST["village_name"])) {
                                    # Prepare the SELECT Query
                                    $selectSQL = "SELECT * FROM family_master";
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
                                                    <th>Family Address</th>
                                                    <th>Family Habitation</th>
                                                    <th>Phone</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                if (mysql_num_rows($selectRes) == 0) {
                                                    echo '<tr><td colspan="4">No Rows Returned</td></tr>';
                                                } else {
                                                    while ($row = mysql_fetch_assoc($selectRes)) {
//                                                        echo $row[village_id];
                                                        $selectSQL11 = mysql_query("SELECT * FROM village_master where village_id='$row[village_id]'");
                                                        $rowv = mysql_fetch_array($selectSQL11);
                                                ?>
                                                <tr>
                                                    <td><?php echo $rowv['village_name'];?></td>
                                                    <td><?php echo $row['family_head_name'];?></td>
                                                    <td><?php echo $row['family_address'];?></td>
                                                    <td><?php echo $row['family_habitation'];?></td>
                                                    <td><?php echo $row['family_phone'];?></td>
<!--                                                    <td>                                      
                                                        <a href="?getid=<?php // echo $row['family_id'];?>" title="Edit"><button class="btn btn-primary btn-xs" style="padding: 5px 5px;font-size: 8px"><i class="icon-pencil"></i></button></a>
                                                        <button class="btn btn-danger btn-xs" style="padding: 5px 5px;font-size: 8px" title="Delete"><i class="icon-trash "></i></button>                                                        
                                                    </td>-->
                                                    <td class="text-center">
                                                        <ul class="icons-list" title="Edit">
                                                                <li class="dropdown">
                                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                                <i class="icon-menu9"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                                                <!--<li><a href="#"><i class="icon-file-pdf"></i> Export to .pdf</a></li>-->
                                                                                <li><a href="personal_data_view.php?getid=<?php echo $row['family_id'];?>">Personal Data</a></li>
                                                                                <li><a href="household_roster_new_view.php?getid=<?php echo $row['family_id'];?>">Household Roster</a></li>
                                                                                <li><a href="socioeconomics_view.php?getid=<?php echo $row['family_id'];?>">Socio Economics</a></li>
                                                                                <li><a href="livestock_view.php?getid=<?php echo $row['family_id'];?>">Live Stock</a></li>
                                                                                <li><a href="agriculture_infrastructure_view.php?getid=<?php echo $row['family_id'];?>">Agriculture Infrastructure</a></li>
                                                                                <li><a href="crop_productivity_farm_technology_view.php?getid=<?php echo $row['family_id'];?>">Crop Productivity and Farm Technology</a></li>
                                                                                <li><a href="self_employment_view.php?getid=<?php echo $row['family_id'];?>">Self Employment</a></li>
                                                                                <li><a href="observation_household_view.php?getid=<?php echo $row['family_id'];?>">Observation Household</a></li>
                                                                        </ul>
                                                                </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                
                                                <?php
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