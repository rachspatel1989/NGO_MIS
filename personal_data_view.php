<?php
session_start();
include_once 'include/DB_Functions.php';
$db_handle = new DB_Functions();
include_once 'personaldata_update.php';

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

$query = "SELECT * FROM district_master";
$results = $db_handle->runQuery($query);
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

        <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
        <script>
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
                    url: "include/get_village.php",
                    data: 'gp_id=' + val,
                    success: function (data) {
                        $("#village-list").html(data);
                    }
                });
            }

            function selectDistrict(val) {
                $("#search-box").val(val);
                $("#suggesstion-box").hide();
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>Personal Data</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /toolbar -->
                    </div>
                    <!-- /page header -->
                    <?php
                    $get_family_id = $_GET["getid"];
                    $select_fami_sql = mysql_query("SELECT * FROM family_master where family_id='$get_family_id'");
                    $row_fam = mysql_fetch_array($select_fami_sql);
                    $gfamily_habitation = $row_fam['family_habitation'];
                    $gfamily_phone = $row_fam['family_phone'];
                    $gfamily_head_name = $row_fam['family_head_name'];
                    $gfamily_address = $row_fam['family_address'];
                    ?>
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
                                                    <input type="hidden" name="get_id" value="<?php echo $get_family_id; ?>"/>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>District name:</label>
                                                            <select name="district" id="district-list" class="form-control" onChange="getBlock(this.value);" required="">                                       
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
                                                            <label for="district_code">Code:</label>
                                                            <input id="district_code" name="district_code" class="form-control" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Block name:</label>
                                                            <select name="block" id="block-list" class="form-control" onChange="getCluster(this.value);">
                                                                <?php
                                                                $select_block = mysql_query("SELECT * FROM block_master where block_id='$row_fam[block_id]'");
                                                                $row_block = mysql_fetch_array($select_block);
                                                                $block_id = $row_block['block_id'];
                                                                $block_name = $row_block['block_name'];
                                                                ?>                                                                
                                                                <option value="<?php echo $block_id; ?>"><?php echo $block_name; ?></option>                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="block_code">Code:</label>
                                                            <input id="block_code" name="block_code" class="form-control" type="text" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Cluster name:</label>
                                                            <select name="cluster" id="cluster-list" class="form-control" onChange="getGP(this.value);">
                                                                <?php
                                                                $select_block = mysql_query("SELECT * FROM cluster_master where cluster_id='$row_fam[cluster_id]'");
                                                                $row_block = mysql_fetch_array($select_block);
                                                                $cluster_id = $row_block['cluster_id'];
                                                                $cluster_name = $row_block['cluster_name'];
                                                                ?>                                                                
                                                                <option value="<?php echo $cluster_id; ?>"><?php echo $cluster_name; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="cluster_code">Code:</label>
                                                            <input id="cluster_code" name="cluster_code" class="form-control" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>GP name:</label>
                                                            <select name="gp" id="gp-list" class="form-control" onChange="getVillage(this.value);">
                                                                <?php
                                                                $select_block = mysql_query("SELECT * FROM gp_master where gp_id='$row_fam[gp_id]'");
                                                                $row_block = mysql_fetch_array($select_block);
                                                                $gp_id = $row_block['gp_id'];
                                                                $gp_name = $row_block['gp_name'];
                                                                ?>                                                                
                                                                <option value="<?php echo $gp_id; ?>"><?php echo $gp_name; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="gp_code">Code:</label>
                                                            <input id="gp_code" name="gp_code" class="form-control" type="text" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Village name:</label>
                                                            <select name="village" id="village-list" class="form-control">
                                                                <?php
                                                                $select_block = mysql_query("SELECT * FROM village_master where village_id='$row_fam[village_id]'");
                                                                $row_block = mysql_fetch_array($select_block);
                                                                $village_id = $row_block['village_id'];
                                                                $village_name = $row_block['village_name'];
                                                                ?>                                                                
                                                                <option value="<?php echo $village_id; ?>"><?php echo $village_name; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="village_code">Code:</label>
                                                            <input id="village_code" name="village_code" class="form-control" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Habitation name:</label>
                                                            <input type="text" name="family_habitation" value="<?php echo $gfamily_habitation; ?>" id="family_habitation" class="form-control" placeholder="Habitation Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="family_phone">Telephone/ land line #:</label>
                                                            <input type="text" name="family_phone" id="family_phone" value="<?php echo $gfamily_phone; ?>" class="form-control" maxlength="10" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required />
                                                            <span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
                                                            <script type="text/javascript">
                                                                var specialKeys = new Array();
                                                                specialKeys.push(8); //Backspace
                                                                function IsNumeric(e) {
                                                                    var keyCode = e.which ? e.which : e.keyCode
                                                                    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) !== -1);
                                                                    document.getElementById("error").style.display = ret ? "none" : "inline";
                                                                    return ret;
                                                                }
                                                            </script>
                                                            <label></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>HH Head name:</label>
                                                            <input type="text" name="family_head_name" value="<?php echo $gfamily_head_name; ?>" id="family_head_name" class="form-control" placeholder="HH Head Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Address of HH (Extra information):</label>
                                                            <textarea name="family_address" id="family_address" value="<?php echo $gfamily_address; ?>" rows="4" cols="4" placeholder="Address of HH" class="form-control" required><?php echo $gfamily_address; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right stepy-finish">
                                                    <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">Update</button>
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
        <script>
            //District Code
            function insertResultsDistrict(json) {
                $("#district_code").val(json["district_code"]);
            }
            function clearFormDistrict() {
                $("#district_code").val("");
            }
            function makeAjaxRequestDistrict(placeId) {
                $.ajax({
                    type: "POST",
                    data: {placeId: placeId},
                    dataType: "json",
                    url: "include/process_ajax_district.php",
                    success: function (json) {
                        insertResultsDistrict(json);
                    }
                });
            }
            $("#district-list").on("change", function () {
                var id = $(this).val();
                if (id === "0") {
                    clearFormDistrict();
                } else {
                    makeAjaxRequestDistrict(id);
                }
            });

            //Block Code
            function insertResultsBlock(json) {
                $("#block_code").val(json["block_code"]);
            }
            function clearFormBlock() {
                $("#block_code").val("");
            }
            function makeAjaxRequestBlock(placeId) {
                $.ajax({
                    type: "POST",
                    data: {placeId: placeId},
                    dataType: "json",
                    url: "include/process_ajax_block.php",
                    success: function (json) {
                        insertResultsBlock(json);
                    }
                });
            }
            $("#block-list").on("change", function () {
                var id = $(this).val();
                if (id === "0") {
                    clearFormBlock();
                } else {
                    makeAjaxRequestBlock(id);
                }
            });

            //Cluster Code
            function insertResultsCluster(json) {
                $("#cluster_code").val(json["cluster_code"]);
            }
            function clearFormCluster() {
                $("#cluster_code").val("");
            }
            function makeAjaxRequestCluster(placeId) {
                $.ajax({
                    type: "POST",
                    data: {placeId: placeId},
                    dataType: "json",
                    url: "include/process_ajax_cluster.php",
                    success: function (json) {
                        insertResultsCluster(json);
                    }
                });
            }
            $("#cluster-list").on("change", function () {
                var id = $(this).val();
                if (id === "0") {
                    clearFormCluster();
                } else {
                    makeAjaxRequestCluster(id);
                }
            });

            //GP Code
            function insertResultsGP(json) {
                $("#gp_code").val(json["gp_code"]);
            }
            function clearFormGP() {
                $("#gp_code").val("");
            }
            function makeAjaxRequestGP(placeId) {
                $.ajax({
                    type: "POST",
                    data: {placeId: placeId},
                    dataType: "json",
                    url: "include/process_ajax_gp.php",
                    success: function (json) {
                        insertResultsGP(json);
                    }
                });
            }
            $("#gp-list").on("change", function () {
                var id = $(this).val();
                if (id === "0") {
                    clearFormGP();
                } else {
                    makeAjaxRequestGP(id);
                }
            });

            //Village Code
            function insertResultsVillage(json) {
                $("#village_code").val(json["village_code"]);
            }

            function clearFormVillage() {
                $("#village_code").val("");
            }

            function makeAjaxRequestVillage(placeId) {
                $.ajax({
                    type: "POST",
                    data: {placeId: placeId},
                    dataType: "json",
                    url: "include/process_ajax_village.php",
                    success: function (json) {
                        insertResultsVillage(json);
                    }
                });
            }

            $("#village-list").on("change", function () {
                var id = $(this).val();
                if (id === "0") {
                    clearFormVillage();
                } else {
                    makeAjaxRequestVillage(id);
                }
            });

        </script>
    </body>
</html>
