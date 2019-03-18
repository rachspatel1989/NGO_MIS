<?php
session_start();
include_once 'include/DB_Functions.php';
$db = new DB_Functions();
include_once './activity_pipepump_support_insert.php';

$allocate_id = $_GET['allocate_id'];
$sqlfamily = "SELECT activity_allocation_master.family_id FROM activity_allocation_master WHERE activity_allocation_master.allocate_id = '$allocate_id'";
$family = mysql_query($sqlfamily) or die(mysql_error());
$rows = mysql_fetch_assoc($family);
$fm_id = $rows['family_id'];

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

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$curdate = date('d/m/Y', time());

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
        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/visualization/echarts/echarts.js"></script>

        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/user_pages_profile.js"></script>
        <!-- /theme JS files -->

        <!-- A2 -->
        <script type="text/javascript">
            $(function () {
                $("#hidedataA2").hide();
                $("#opendataA1").show();
                if ($("#pendingYesA1").is(":checked")) {
                    document.getElementById("btn-save").disabled = true;
                }
                $("#completedYesA1").on("input", function () {
                    $("#hidedataA2").toggle();
                });
            });
        </script> 
        <script type="text/javascript">
            $(function () {
                $("input[name='A1']").click(function () {
                    if ($("#completedYesA1").is(":checked")) {
                        $("#hidedataA2").show();
                        document.getElementById("btn-save").disabled = false;
                    }
                    if ($("#pendingYesA1").is(":checked")) {
                        $("#hidedataA2").hide();
                        document.getElementById("btn-save").disabled = true;
                    }
                    if ($("#terminatedYesA1").is(":checked")) {
                        $("#hidedataA2").hide();
                        document.getElementById("btn-save").disabled = false;
                    }

                });
            });
        </script>

        <!-- A3 -->
        <script type="text/javascript">
            $(function () {
                $("#hidedataA3").hide();
                $("#completedYesA2").on("input", function () {
                    $("#hidedataA3").toggle();
                });
            });
        </script> 
        <script type="text/javascript">
            $(function () {
                $("input[name='A2']").click(function () {
                    if ($("#completedYesA2").is(":checked")) {
                        $("#hidedataA3").show();
                        document.getElementById("btn-save").disabled = false;
                    }
                    if ($("#pendingYesA2").is(":checked")) {
                        $("#hidedataA3").hide();
                        document.getElementById("btn-save").disabled = true;
                    }
                    if ($("#terminatedYesA2").is(":checked")) {
                        $("#hidedataA3").hide();
                        document.getElementById("btn-save").disabled = false;
                    }
                });
            });
        </script>

        <!-- A4 -->
        <script type="text/javascript">
            $(function () {
                $("#hidedataA4").hide();
                $("#completedYesA3").on("input", function () {
                    $("#hidedataA4").toggle();
                });
            });
        </script> 
        <script type="text/javascript">
            $(function () {
                $("input[name='A3']").click(function () {
                    if ($("#completedYesA3").is(":checked")) {
                        $("#hidedataA4").show();
                        document.getElementById("btn-save").disabled = false;
                    }
                    if ($("#pendingYesA3").is(":checked")) {
                        $("#hidedataA4").hide();
                        document.getElementById("btn-save").disabled = true;
                    }
                    if ($("#terminatedYesA3").is(":checked")) {
                        $("#hidedataA4").hide();
                        document.getElementById("btn-save").disabled = false;
                    }
                });
            });
        </script>

        <!-- A5 -->
        <script type="text/javascript">
            $(function () {
                $("#hidedataA5").hide();
                $("#completedYesA4").on("input", function () {
                    $("#hidedataA5").toggle();
                });
            });
        </script> 
        <script type="text/javascript">
            $(function () {
                $("input[name='A4']").click(function () {
                    if ($("#completedYesA4").is(":checked")) {
                        $("#hidedataA5").show();
                        document.getElementById("btn-save").disabled = false;
                    }
                    if ($("#pendingYesA4").is(":checked")) {
                        $("#hidedataA5").hide();
                        document.getElementById("btn-save").disabled = true;
                    }
                    if ($("#terminatedYesA4").is(":checked")) {
                        $("#hidedataA5").hide();
                        document.getElementById("btn-save").disabled = false;
                    }
                });
            });
        </script>

        <!-- A6 -->
        <script type="text/javascript">
            $(function () {
                $("#hidedataA6").hide();
                $("#completedYesA5").on("input", function () {
                    $("#hidedataA6").toggle();
                });
            });
        </script> 
        <script type="text/javascript">
            $(function () {
                $("input[name='A5']").click(function () {
                    if ($("#completedYesA5").is(":checked")) {
                        $("#hidedataA6").show();
                        document.getElementById("btn-save").disabled = false;
                    }
                    if ($("#pendingYesA5").is(":checked")) {
                        $("#hidedataA6").hide();
                        document.getElementById("btn-save").disabled = true;
                    }
                    if ($("#terminatedYesA5").is(":checked")) {
                        $("#hidedataA6").hide();
                        document.getElementById("btn-save").disabled = false;
                    }
                });
            });
        </script>

        <!-- A7 -->
        <script type="text/javascript">
            $(function () {
                $("#hidedataA7").hide();
                $("#completedYesA6").on("input", function () {
                    $("#hidedataA7").toggle();
                });
            });
        </script> 
        <script type="text/javascript">
            $(function () {
                $("input[name='A6']").click(function () {
                    if ($("#completedYesA6").is(":checked")) {
                        $("#hidedataA7").show();
                        document.getElementById("btn-save").disabled = false;
                    }
                    if ($("#pendingYesA6").is(":checked")) {
                        $("#hidedataA7").hide();
                        document.getElementById("btn-save").disabled = true;
                    }
                    if ($("#terminatedYesA6").is(":checked")) {
                        $("#hidedataA7").hide();
                        document.getElementById("btn-save").disabled = false;
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("input[name='A7']").click(function () {
                    if ($("#completedYesA7").is(":checked")) {
                        document.getElementById("btn-save").disabled = false;
                    }
                    if ($("#pendingYesA7").is(":checked")) {
                        document.getElementById("btn-save").disabled = true;
                    }
                    if ($("#terminatedYesA7").is(":checked")) {
                        document.getElementById("btn-save").disabled = false;
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#opendataA6").hide();
            });
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>Indicators</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /toolbar -->
                    </div>
                    <!-- /page header -->
                    <!-- Content area -->
                    <div class="content">
                        <!-- User profile -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tabbable">
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="activity">

                                            <form action="#" method="post">
                                                <!-- Rice Cultivation -->
                                                <div class="PipePumpSupport">
                                                    <div class="panel panel-white">
                                                        <div class="panel-heading">
                                                            <h6 class="panel-title text-semibold">Water Resource Development P) Pipe / Pump Support</h6>
                                                            <div class="heading-elements">
                                                                <ul class="icons-list">
                                                                    <li><a data-action="collapse"></a></li>
                                                                    <li><a data-action="reload"></a></li>
                                                                    <li><a data-action="close"></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <table class="table table-striped media-library table-lg">
                                                                <thead>                                                               
                                                                    <tr>
                                                                        <th>Description of Steps</th>
                                                                        <th>Time Gap</th>
                                                                        <th>Record Action </th>
                                                                        <th>Visit Date </th>
                                                                        <th>Remark (if any)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $sql = mysql_query("SELECT Count(activity_progress_master.pr_id) as cnt FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id");
                                                                    $row = mysql_fetch_array($sql);
                                                                    $cnt = $row['cnt'];
                                                                    if ($cnt == 0) {
                                                                        ?>
                                                                        <tr id="hidedataA1">  
                                                                            <td style="width: 300px">Is cluster coordinator raised generated demand from eligible farmers?  <input type="hidden" id="L1" name="L1" value="Is cluster coordinator raised generated demand from eligible farmers?  " class="form-control"></td>
                                                                            <td> 05 days </td>
                                                                            <td>
                                                                                <label class="radio-inline" for="A1">
                                                                                    <input name="A1" type="radio" id="pendingYesA1" checked="checked" value="Pending">
                                                                                    Pending
                                                                                </label><br/>
                                                                                <label class="radio-inline" for="A1">
                                                                                    <input name="A1" type="radio" id="completedYesA1" value="Completed">
                                                                                    Completed
                                                                                </label><br/>
                                                                                <label class="radio-inline" for="A1">
                                                                                    <input name="A1" type="radio" id="terminatedYesA1" value="Terminate">
                                                                                    Terminate
                                                                                </label>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="visit1" class="form-control" value="<?php echo $curdate ?>" placeholder="" disabled>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name="remark1" class="form-control" value="" placeholder="">
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    } else {
                                                                        $activity_sql = mysql_query("SELECT activity_progress_master.action_recorded,activity_progress_master.visit_date,activity_progress_master.remarks FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id LIMIT 1");
                                                                        while ($activity_row = mysql_fetch_array($activity_sql)) {
                                                                            $action = $activity_row['action_recorded'];
                                                                            $visit = $activity_row['visit_date'];
                                                                            $remarks = $activity_row['remarks'];
                                                                            ?>  
                                                                            <tr id="hidedataA1">       
                                                                                <td style="width: 300px">Is cluster coordinator raised generated demand from eligible farmers?  <input type="hidden" id="L1" name="L1" value="Is cluster coordinator raised generated demand from eligible farmers?  " class="form-control"></td>

                                                                                <td> 05 days </td>
                                                                                <?php
                                                                                if ($action == "Pending") {
                                                                                    echo "<td><input name='A1' type='radio' id='pendingYesA1' checked='checked' value='Pending'> Pending <br/><input name='A1' type='radio' id='completedYesA1' value='Completed'> Completed <br/><input name='A1' type='radio' id='terminatedYesA1' value='Terminate'> Terminate </td>";
                                                                                } else
                                                                                if ($action == "Completed") {
                                                                                    echo "<td><input name='A1' type='radio' id='pendingYesA1' value='Pending'> Pending <br/><input name='A1' type='radio' id='completedYesA1' checked='checked' value='Completed'> Completed <br/><input name='A1' type='radio' id='terminatedYesA1' value='Terminate'> Terminate </td>";
                                                                                    ?>
                                                                            <script type="text/javascript">
                                                                                $(function () {
                                                                                    $("#hidedataA2").show();
                                                                                    $("#opendataA1").hide();
                                                                                    if ($("#pendingYesA2").is(":checked")) {
                                                                                        document.getElementById("btn-save").disabled = true;
                                                                                    }
                                                                                });
                                                                            </script>
                                                                            <?php
                                                                        } else {
                                                                            echo "<td><input name='A1' type='radio' id='pendingYesA1' value='Pending'> Pending <br/><input name='A1' type='radio' id='completedYesA1' value='Completed'> Completed <br/><input name='A1' type='radio' id='terminatedYesA1' checked='checked' value='Terminate'> Terminate </td>";
                                                                        }
                                                                        ?>
                                                                        <td>
                                                                            <input type="text" name="visit1" class="form-control" value="<?php echo $visit ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark1" class="form-control" value="<?php echo $remarks ?>" placeholder="">
                                                                        </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <tr id="opendataA1"> 
                                                                    <td colspan="5">
                                                                        <div class="col-md-4"></div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <select name="activity_name" id="activity_name" class="form-control">
                                                                                    <option value="null">select</option>
                                                                                    <option value="Pumping Machinery">Pumping Machinery</option>
                                                                                    <option value="Pipe and Accessories">Pipe and Accessories</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4"></div>
                                                                    </td>                                                                    
                                                                </tr>        

                                                                <?php
                                                                $sql = mysql_query("SELECT Count(activity_progress_master.pr_id) as cnt FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id");
                                                                $row = mysql_fetch_array($sql);
                                                                $cnt = $row['cnt'];
                                                                if ($cnt == 1) {
                                                                    ?>
                                                                    <tr id="hidedataA2">  
                                                                        <td style="width: 300px">Is block coordinator verified the proposed list of farmers for approval?<input type="hidden" id="L2" name="L2" value="Is block coordinator verified the proposed list of farmers for approval?" class="form-control"></td>

                                                                        <td> 05 days </td>
                                                                        <td>
                                                                            <label class="radio-inline" for="A2">
                                                                                <input name="A2" type="radio" id="pendingYesA2" checked="checked" value="Pending">
                                                                                Pending
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A1">
                                                                                <input name="A2" type="radio" id="completedYesA2" value="Completed">
                                                                                Completed
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A1">
                                                                                <input name="A2" type="radio" id="terminatedYesA2" value="Terminate">
                                                                                Terminate
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="visit2" class="form-control" value="<?php echo $curdate ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark2" class="form-control" value="" placeholder="">
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                } else {
                                                                    $activity_sql = mysql_query("SELECT activity_progress_master.action_recorded,activity_progress_master.visit_date,activity_progress_master.remarks FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id LIMIT 1, 1");
                                                                    while ($activity_row = mysql_fetch_array($activity_sql)) {
                                                                        $action = $activity_row['action_recorded'];
                                                                        $visit = $activity_row['visit_date'];
                                                                        $remarks = $activity_row['remarks'];
                                                                        ?>  
                                                                        <tr id="hidedataA2">       
                                                                            <td style="width: 300px">Is block coordinator verified the proposed list of farmers for approval?<input type="hidden" id="L2" name="L2" value="Is block coordinator verified the proposed list of farmers for approval?" class="form-control"></td>

                                                                            <td> 05 days </td>
                                                                            <?php
                                                                            if ($action == "Pending") {
                                                                                echo "<td><input name='A2' type='radio' id='pendingYesA2' checked='checked' value='Pending'> Pending <br/><input name='A2' type='radio' id='completedYesA2' value='Completed'> Completed <br/><input name='A2' type='radio' id='terminatedYesA2' value='Terminate'> Terminate </td>";
                                                                            } else
                                                                            if ($action == "Completed") {
                                                                                echo "<td><input name='A2' type='radio' id='pendingYesA2' value='Pending'> Pending <br/><input name='A2' type='radio' id='completedYesA2' checked='checked' value='Completed'> Completed <br/><input name='A2' type='radio' id='terminatedYesA2' value='Terminate'> Terminate </td>";
                                                                                ?>
                                                                            <script type="text/javascript">
                                                                                $(function () {
                                                                                    $("#hidedataA3").show();
                                                                                    if ($("#pendingYesA3").is(":checked")) {
                                                                                        document.getElementById("btn-save").disabled = true;
                                                                                    }
                                                                                });
                                                                            </script>

                                                                            <?php
                                                                        } else {
                                                                            echo "<td><input name='A2' type='radio' id='pendingYesA2' value='Pending'> Pending <br/><input name='A2' type='radio' id='completedYesA2' value='Completed'> Completed <br/><input name='A2' type='radio' id='terminatedYesA2' checked='checked' value='Terminate'> Terminate </td>";
                                                                        }
                                                                        ?>
                                                                        <td>
                                                                            <input type="text" name="visit2" class="form-control" value="<?php echo $visit ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark2" class="form-control" value="<?php echo $remarks ?>" placeholder="">
                                                                        </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                                <?php
                                                                $sql = mysql_query("SELECT Count(activity_progress_master.pr_id) as cnt FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id");
                                                                $row = mysql_fetch_array($sql);
                                                                $cnt = $row['cnt'];
                                                                if ($cnt == 2) {
                                                                    ?>
                                                                    <tr id="hidedataA3">  
                                                                        <td style="width: 300px">Approval of concern authority of DBMGF for enterprise:<input type="hidden" id="L3" name="L3" value="Approval of concern authority of DBMGF for enterprise:" class="form-control"></td>
                                                                        <td> 05 days </td>
                                                                        <td>
                                                                            <label class="radio-inline" for="A3">
                                                                                <input name="A3" type="radio" id="pendingYesA3" checked="checked" value="Pending">
                                                                                Pending
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A3">
                                                                                <input name="A3" type="radio" id="completedYesA3" value="Completed">
                                                                                Completed
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A3">
                                                                                <input name="A3" type="radio" id="terminatedYesA3" value="Terminate">
                                                                                Terminate
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="visit3" class="form-control" value="<?php echo $curdate ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark3" class="form-control" placeholder="">
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                } else {
                                                                    $activity_sql = mysql_query("SELECT activity_progress_master.action_recorded,activity_progress_master.visit_date,activity_progress_master.remarks FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id LIMIT 2, 1");
                                                                    while ($activity_row = mysql_fetch_array($activity_sql)) {
                                                                        $action = $activity_row['action_recorded'];
                                                                        $visit = $activity_row['visit_date'];
                                                                        $remarks = $activity_row['remarks'];
                                                                        ?>  
                                                                        <tr id="hidedataA3">       
                                                                            <td style="width: 300px">Approval of concern authority of DBMGF for enterprise:<input type="hidden" id="L3" name="L3" value="Approval of concern authority of DBMGF for enterprise:" class="form-control"></td>

                                                                            <td> 05 days </td>
                                                                            <?php
                                                                            if ($action == "Pending") {
                                                                                echo "<td><input name='A3' type='radio' id='pendingYesA3' checked='checked' value='Pending'> Pending <br/><input name='A3' type='radio' id='completedYesA3' value='Completed'> Completed <br/><input name='A3' type='radio' id='terminatedYesA3' value='Terminate'> Terminate </td>";
                                                                            } else
                                                                            if ($action == "Completed") {
                                                                                echo "<td><input name='A3' type='radio' id='pendingYesA3' value='Pending'> Pending <br/><input name='A3' type='radio' id='completedYesA3' checked='checked' value='Completed'> Completed <br/><input name='A3' type='radio' id='terminatedYesA3' value='Terminate'> Terminate </td>";
                                                                                ?>
                                                                            <script type="text/javascript">
                                                                                $(function () {
                                                                                    $("#hidedataA4").show();
                                                                                    if ($("#pendingYesA4").is(":checked")) {
                                                                                        document.getElementById("btn-save").disabled = true;
                                                                                    }
                                                                                });
                                                                            </script>
                                                                            <?php
                                                                        } else {
                                                                            echo "<td><input name='A3' type='radio' id='pendingYesA3' value='Pending'> Pending <br/><input name='A3' type='radio' id='completedYesA3' value='Completed'> Completed <br/><input name='A3' type='radio' id='terminatedYesA3' checked='checked' value='Terminate'> Terminate </td>";
                                                                        }
                                                                        ?>
                                                                        <td>
                                                                            <input type="text" name="visit3" class="form-control" value="<?php echo $visit ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark3" class="form-control" value="<?php echo $remarks ?>" placeholder="">
                                                                        </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                                <?php
                                                                $sql = mysql_query("SELECT Count(activity_progress_master.pr_id) as cnt FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id");
                                                                $row = mysql_fetch_array($sql);
                                                                $cnt = $row['cnt'];
                                                                if ($cnt == 3) {
                                                                    ?>
                                                                    <tr id="hidedataA4">  
                                                                        <td style="width: 300px">Expected contribution / Margin money from the beneficiary is received, receipt issued<input type="hidden" id="L4" name="L4" value="Expected contribution / Margin money from the beneficiary is received, receipt issued" class="form-control"></td>
                                                                        <td> 05 days </td>
                                                                        <td>
                                                                            <label class="radio-inline" for="A4">
                                                                                <input name="A4" type="radio" id="pendingYesA4" checked="checked" value="Pending">
                                                                                Pending
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A4">
                                                                                <input name="A4" type="radio" id="completedYesA4" value="Completed">
                                                                                Completed
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A4">
                                                                                <input name="A4" type="radio" id="terminatedYesA4" value="Terminate">
                                                                                Terminate
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="visit4" class="form-control" value="<?php echo $curdate ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark4" class="form-control" placeholder="">
                                                                        </td>
                                                                    </tr>

                                                                    <?php
                                                                } else {
                                                                    $activity_sql = mysql_query("SELECT activity_progress_master.action_recorded,activity_progress_master.visit_date,activity_progress_master.remarks FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id LIMIT 3, 1");
                                                                    while ($activity_row = mysql_fetch_array($activity_sql)) {
                                                                        $action = $activity_row['action_recorded'];
                                                                        $visit = $activity_row['visit_date'];
                                                                        $remarks = $activity_row['remarks'];
                                                                        ?>  
                                                                        <tr id="hidedataA4">       
                                                                            <td style="width: 300px">Expected contribution / Margin money from the beneficiary is received, receipt issued<input type="hidden" id="L4" name="L4" value="Expected contribution / Margin money from the beneficiary is received, receipt issued" class="form-control"></td>

                                                                            <td> 05 days </td>
                                                                            <?php
                                                                            if ($action == "Pending") {
                                                                                echo "<td><input name='A4' type='radio' id='pendingYesA4' checked='checked' value='Pending'> Pending <br/><input name='A4' type='radio' id='completedYesA4' value='Completed'> Completed <br/><input name='A4' type='radio' id='terminatedYesA4' value='Terminate'> Terminate </td>";
                                                                            } else
                                                                            if ($action == "Completed") {
                                                                                echo "<td><input name='A4' type='radio' id='pendingYesA4' value='Pending'> Pending <br/><input name='A4' type='radio' id='completedYesA4' checked='checked' value='Completed'> Completed <br/><input name='A4' type='radio' id='terminatedYesA4' value='Terminate'> Terminate </td>";
                                                                                ?>
                                                                            <script type="text/javascript">
                                                                                $(function () {
                                                                                    $("#hidedataA5").show();
                                                                                    $("#opendataA6").show();
                                                                                    if ($("#pendingYesA5").is(":checked")) {
                                                                                        document.getElementById("btn-save").disabled = true;
                                                                                    }
                                                                                });
                                                                            </script>
                                                                            <?php
                                                                        } else {
                                                                            echo "<td><input name='A4' type='radio' id='pendingYesA4' value='Pending'> Pending <br/><input name='A4' type='radio' id='completedYesA4' value='Completed'> Completed <br/><input name='A4' type='radio' id='terminatedYesA4' checked='checked' value='Terminate'> Terminate </td>";
                                                                        }
                                                                        ?>
                                                                        <td>
                                                                            <input type="text" name="visit4" class="form-control" value="<?php echo $visit ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark4" class="form-control" value="<?php echo $remarks ?>" placeholder="">
                                                                        </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                                <?php
                                                                $sql = mysql_query("SELECT Count(activity_progress_master.pr_id) as cnt FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id");
                                                                $row = mysql_fetch_array($sql);
                                                                $cnt = $row['cnt'];
                                                                if ($cnt == 4) {
                                                                    ?>
                                                                    <tr id="hidedataA5">  
                                                                        <td style="width: 300px">Is done support of Pumping machinery or pipes and accessories to beneficiary? <input type="hidden" id="L5" name="L5" value="Is done support of Pumping machinery or pipes and accessories to beneficiary? " class="form-control"></td>
                                                                        <td> 05 days </td>
                                                                        <td>
                                                                            <label class="radio-inline" for="A5">
                                                                                <input name="A5" type="radio" id="pendingYesA5" checked="checked" value="Pending">
                                                                                Pending
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A5">
                                                                                <input name="A5" type="radio" id="completedYesA5" value="Completed">
                                                                                Completed
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A5">
                                                                                <input name="A5" type="radio" id="terminatedYesA5" value="Terminate">
                                                                                Terminate
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="visit5" class="form-control" value="<?php echo $curdate ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark5" class="form-control" placeholder="">
                                                                        </td>
                                                                    </tr>

                                                                    <?php
                                                                } else {
                                                                    $activity_sql = mysql_query("SELECT activity_progress_master.action_recorded,activity_progress_master.visit_date,activity_progress_master.remarks FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id LIMIT 4,1");
                                                                    while ($activity_row = mysql_fetch_array($activity_sql)) {
                                                                        $action = $activity_row['action_recorded'];
                                                                        $visit = $activity_row['visit_date'];
                                                                        $remarks = $activity_row['remarks'];
                                                                        ?>  
                                                                        <tr id="hidedataA5">       
                                                                            <td style="width: 300px">Is done support of Pumping machinery or pipes and accessories to beneficiary? <input type="hidden" id="L5" name="L5" value="Is done support of Pumping machinery or pipes and accessories to beneficiary? " class="form-control"></td>

                                                                            <td> 05 days </td>
                                                                            <?php
                                                                            if ($action == "Pending") {
                                                                                echo "<td><input name='A5' type='radio' id='pendingYesA5' checked='checked' value='Pending'> Pending <br/><input name='A5' type='radio' id='completedYesA5' value='Completed'> Completed <br/><input name='A5' type='radio' id='terminatedYesA5' value='Terminate'> Terminate </td>";
                                                                            } else
                                                                            if ($action == "Completed") {
                                                                                echo "<td><input name='A5' type='radio' id='pendingYesA5' value='Pending'> Pending <br/><input name='A5' type='radio' id='completedYesA5' checked='checked' value='Completed'> Completed <br/><input name='A5' type='radio' id='terminatedYesA5' value='Terminate'> Terminate </td>";
                                                                                ?>
                                                                            <script type="text/javascript">
                                                                                $(function () {
                                                                                    $("#hidedataA6").show();
                                                                                    $("#opendataA6").hide();
                                                                                    if ($("#pendingYesA6").is(":checked")) {
                                                                                        document.getElementById("btn-save").disabled = true;
                                                                                    }
                                                                                });
                                                                            </script>
                                                                            <?php
                                                                        } else {
                                                                            echo "<td><input name='A5' type='radio' id='pendingYesA5' value='Pending'> Pending <br/><input name='A5' type='radio' id='completedYesA5' value='Completed'> Completed <br/><input name='A5' type='radio' id='terminatedYesA5' checked='checked' value='Terminate'> Terminate </td>";
                                                                        }
                                                                        ?>
                                                                        <td>
                                                                            <input type="text" name="visit5" class="form-control" value="<?php echo $visit ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark5" class="form-control" value="<?php echo $remarks ?>" placeholder="">
                                                                        </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <tr id="opendataA6">  
                                                                    <td colspan="5">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>1. Amount of DBMGF Grant (INR)</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>2. LHWRF Grant (INR)</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" name="amount_grant" id="amount_grant" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" name="lhwrf_grant" id="lhwrf_grant" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div><br/>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>3. MF (INR)</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>4. Beneficiaries Contribution (INR)</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" name="mf" id="mf" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <input type="text" name="benifi_contribution" id="benifi_contribution" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <?php
                                                                $sql = mysql_query("SELECT Count(activity_progress_master.pr_id) as cnt FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id");
                                                                $row = mysql_fetch_array($sql);
                                                                $cnt = $row['cnt'];
                                                                if ($cnt == 5) {
                                                                    ?>
                                                                    <tr id="hidedataA6">  
                                                                        <td style="width: 300px">Is pumping machinery, pipes and accessories installation done?<input type="hidden" id="L6" name="L6" value="Is pumping machinery, pipes and accessories installation done?" class="form-control"></td>
                                                                        <td> 05 days </td>
                                                                        <td>
                                                                            <label class="radio-inline" for="A6">
                                                                                <input name="A6" type="radio" id="pendingYesA6" checked="checked" value="Pending">
                                                                                Pending
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A6">
                                                                                <input name="A6" type="radio" id="completedYesA6" value="Completed">
                                                                                Completed
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A6">
                                                                                <input name="A6" type="radio" id="terminatedYesA6" value="Terminate">
                                                                                Terminate
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="visit6" class="form-control" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark6" class="form-control" placeholder="">
                                                                        </td>
                                                                    </tr>

                                                                    <?php
                                                                } else {
                                                                    $activity_sql = mysql_query("SELECT activity_progress_master.action_recorded,activity_progress_master.visit_date,activity_progress_master.remarks FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id LIMIT 5,1");
                                                                    while ($activity_row = mysql_fetch_array($activity_sql)) {
                                                                        $action = $activity_row['action_recorded'];
                                                                        $visit = $activity_row['visit_date'];
                                                                        $remarks = $activity_row['remarks'];
                                                                        ?>  
                                                                        <tr id="hidedataA6">       
                                                                            <td style="width: 300px">Is pumping machinery, pipes and accessories installation done?<input type="hidden" id="L6" name="L6" value="Is pumping machinery, pipes and accessories installation done?" class="form-control"></td>

                                                                            <td> 05 days </td>
                                                                            <?php
                                                                            if ($action == "Pending") {
                                                                                echo "<td><input name='A6' type='radio' id='pendingYesA6' checked='checked' value='Pending'> Pending <br/><input name='A6' type='radio' id='completedYesA6' value='Completed'> Completed <br/><input name='A6' type='radio' id='terminatedYesA6' value='Terminate'> Terminate </td>";
                                                                            } else
                                                                            if ($action == "Completed") {
                                                                                echo "<td><input name='A6' type='radio' id='pendingYesA6' value='Pending'> Pending <br/><input name='A6' type='radio' id='completedYesA6' checked='checked' value='Completed'> Completed <br/><input name='A6' type='radio' id='terminatedYesA6' value='Terminate'> Terminate </td>";
                                                                                ?>
                                                                            <script type="text/javascript">
                                                                                $(function () {
                                                                                    $("#hidedataA7").show();
                                                                                    if ($("#pendingYesA7").is(":checked")) {
                                                                                        document.getElementById("btn-save").disabled = true;
                                                                                    }
                                                                                });
                                                                            </script>
                                                                            <?php
                                                                        } else {
                                                                            echo "<td><input name='A6' type='radio' id='pendingYesA6' value='Pending'> Pending <br/><input name='A6' type='radio' id='completedYesA6' value='Completed'> Completed <br/><input name='A6' type='radio' id='terminatedYesA6' checked='checked' value='Terminate'> Terminate </td>";
                                                                        }
                                                                        ?>
                                                                        <td>
                                                                            <input type="text" name="visit6" class="form-control" value="<?php echo $visit ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark6" class="form-control" value="<?php echo $remarks ?>" placeholder="">
                                                                        </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>


                                                                <?php
                                                                $sql = mysql_query("SELECT Count(activity_progress_master.pr_id) as cnt FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id");
                                                                $row = mysql_fetch_array($sql);
                                                                $cnt = $row['cnt'];
                                                                if ($cnt == 6) {
                                                                    ?>
                                                                    <tr id="hidedataA7">  
                                                                        <td style="width: 300px">Start the end-line survey<input type="hidden" id="L7" name="L7" value="Start the end-line survey" class="form-control"></td>
                                                                        <td> 45 days </td>
                                                                        <td>
                                                                            <label class="radio-inline" for="A7">
                                                                                <input name="A7" type="radio" id="pendingYesA7" checked="checked" value="Pending">
                                                                                Pending
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A7">
                                                                                <input name="A7" type="radio" id="completedYesA7" value="Completed">
                                                                                Completed
                                                                            </label><br/>
                                                                            <label class="radio-inline" for="A7">
                                                                                <input name="A7" type="radio" id="terminatedYesA7" value="Terminate">
                                                                                Terminate
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="visit7" class="form-control" value="<?php echo $curdate ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark7" class="form-control" placeholder="">
                                                                        </td>
                                                                    </tr>                                                                     
                                                                    <?php
                                                                } else {
                                                                    $activity_sql = mysql_query("SELECT activity_progress_master.action_recorded,activity_progress_master.visit_date,activity_progress_master.remarks FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id LIMIT 6,1");
                                                                    while ($activity_row = mysql_fetch_array($activity_sql)) {
                                                                        $action = $activity_row['action_recorded'];
                                                                        $visit = $activity_row['visit_date'];
                                                                        $remarks = $activity_row['remarks'];
                                                                        ?>  
                                                                        <tr id="hidedataA7">       
                                                                            <td style="width: 300px">Start the end-line survey<input type="hidden" id="L7" name="L7" value="Start the end-line survey" class="form-control"></td>

                                                                            <td> 45 days </td>
                                                                            <?php
                                                                            if ($action == "Pending") {
                                                                                echo "<td><input name='A7' type='radio' id='pendingYesA7' checked='checked' value='Pending'> Pending <br/><input name='A7' type='radio' id='completedYesA7' value='Completed'> Completed <br/><input name='A7' type='radio' id='terminatedYesA7' value='Terminate'> Terminate </td>";
                                                                            } else
                                                                            if ($action == "Completed") {
                                                                                echo "<td><input name='A7' type='radio' id='pendingYesA7' value='Pending'> Pending <br/><input name='A7' type='radio' id='completedYesA7' checked='checked' value='Completed'> Completed <br/><input name='A7' type='radio' id='terminatedYesA7' value='Terminate'> Terminate </td>";
                                                                                ?>
                                                                            <script type="text/javascript">
                                                                                $(function () {
                                                                                    $("#btn-save").hide();
                                                                                });
                                                                            </script>
                                                                            <?php
                                                                        } else {
                                                                            echo "<td><input name='A7' type='radio' id='pendingYesA7' value='Pending'> Pending <br/><input name='A7' type='radio' id='completedYesA7' value='Completed'> Completed <br/><input name='A7' type='radio' id='terminatedYesA7' checked='checked' value='Terminate'> Terminate </td>";
                                                                        }
                                                                        ?>
                                                                        <td>
                                                                            <input type="text" name="visit7" class="form-control" value="<?php echo $visit ?>" placeholder="" disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="remark7" class="form-control" value="<?php echo $remarks ?>" placeholder="">
                                                                        </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="text-right">  
                                                        <button type="submit" name="btn-save" id="btn-save" class="btn btn-primary">Submit Activity <i class="icon-arrow-right14 position-right"></i></button>
                                                    </div>
                                                </div>                                                
                                                <!-- /media library -->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /user profile -->
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
