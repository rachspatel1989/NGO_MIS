<?php
session_start();
include_once 'include/DB_Functions.php';
$db = new DB_Functions();
include_once 'crop_productivity_farm_technology_insert.php';

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
error_reporting(0);
?>
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

        <!-- /theme JS files -->
        <script type="text/javascript">
            $(function () {
                $("#nextcrop").hide();
                $("#consumed_crop_Kharip").on("input", function () {
                    $("#nextcrop").toggle();
                }
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='consumed_crop']").click(function () {
                    if ($("#consumed_crop_No").is(":checked")) {
                        $("#nextcrop").hide();
                    }
                    if ($("#consumed_crop_Kharip").is(":checked")) {
                        $("#nextcrop").show();
                    }
                    if ($("#consumed_crop_Rabi").is(":checked")) {
                        $("#nextcrop").show();
                    }
                    if ($("#consumed_crop_Entire").is(":checked")) {
                        $("#nextcrop").show();
                    }

                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#Q10").hide();
                $("#newtechNo").on("input", function () {
                    $("#Q10").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='newtech']").click(function () {
                    if ($("#newtechYes").is(":checked")) {
                        $("#Q10").hide();
                    }
                    if ($("#newtechNo").is(":checked")) {
                        $("#Q10").show();
                    }

                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#Q15").hide();
                $("#wellirrigationNo").on("input", function () {
                    $("#Q15").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='wellirrigation']").click(function () {
                    if ($("#wellirrigationYes").is(":checked")) {
                        $("#Q15").hide();
                    }
                    if ($("#wellirrigationNo").is(":checked")) {
                        $("#Q15").show();
                    }

                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#Q18").hide();
                $("#landavailableNo").on("input", function () {
                    $("#Q18").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='landavailable']").click(function () {
                    if ($("#landavailableYes").is(":checked")) {
                        $("#Q18").hide();
                    }
                    if ($("#landavailableNo").is(":checked")) {
                        $("#Q18").show();
                    }

                });
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>F. Crop Productivity and Farm Technology</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /toolbar -->
                    </div>
                    <!-- /page header -->

                    <!-- /page header -->
                    <!-- Content area -->
                    <div class="content">
                        
<!--Grid View Start-->
<?php 
$sql_fet_sql = mysql_query("SELECT family_id FROM family_master ORDER BY family_id DESC");
$row_data = mysql_fetch_array($sql_fet_sql);
$fam_id = $row_data['family_id'];
$sql_fet_sql1 = mysql_query("SELECT * FROM family_crop_master ,family_farmtech_master WHERE family_crop_master.family_id = family_farmtech_master.family_id AND family_crop_master.family_id = '$fam_id'");
$sql_fm_rows = mysql_num_rows($sql_fet_sql1);
//$row_data1 = mysql_fetch_array($sql_fet_sql1);
if($sql_fm_rows == 0)
{
    
}
else
{
?>
                       <?php /* <div class="panel panel-flat">
                            <?php
//                            while($row_data1 = mysql_fetch_array($sql_fet_sql1))
//                                {
                                ?>                                 
                                <table class="table datatable-responsive">
                                    <thead>
                                        <tr>                                            
                                            <th>Family ID</th>
                                            <th>Crops</th>
                                            <th>Consumed Crops</th>
                                            <th>Land Area</th>
                                            <th>Production</th>
                                            <th>Production Quality</th>
                                            <th>Expenditure</th>
                                            <th>Market Rate</th>
                                            <th>Executing from the Irrigated Land</th>
                                            
<!--                                            <th>Monthly Income (Rs)</th>
                                            <th>Telephone/ land line no</th>-->
                                            <!--<th class="text-center">Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        if (mysql_num_rows($selectRes) == 0) {
//                                            echo '<tr><td>No Rows Returned</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
//                                        } else {
//                                            while ($row = mysql_fetch_assoc($selectRes)) {
                                        while($row_data1 = mysql_fetch_array($sql_fet_sql1))
                                            {                                        
                                                $fmm_id = $row_data1['family_id'];
                                                $mem_name = $row_data1['crop_id'];
                                                $mem_age = $row_data1['cm_consumed_crop'];
                                                $mem_gen = $row_data1['cm_land_area'];
                                                $mem_number = $row_data1['cm_total_production_amount'];
                                                $cm_total_sold_amount = $row_data1['cm_total_sold_amount'];
                                                $cm_total_expenditure = $row_data1['cm_total_expenditure'];
                                                $cm_market_rate = $row_data1['cm_market_rate'];
                                                $cm_production_amt = $row_data1['cm_production_amt'];
//                                                $mem = $row_data1[''];
//                                                $contact = $row['family_phone'];
                                                ?>
                                                <tr id="family_del<?php echo $fmm_id; ?>">
                                                    <td><?php echo $fmm_id; ?></td>
                                                    <td><?php echo $mem_name; ?></td>
                                                    <td><?php echo $mem_age; ?></td>
                                                    <td><?php echo $mem_gen; ?></td>
                                                    <td><?php echo $mem_number; ?></td>
                                                    <td><?php echo $cm_total_sold_amount; ?></a></td>
                                                    <td><?php echo $cm_total_expenditure; ?></a></td>
                                                    <td><?php echo $cm_market_rate; ?></a></td>
                                                    <td><?php echo $cm_production_amt; ?></a></td>
                                                    
<!--                                                    <td><?php //echo $salary ?></a></td>
                                                    <td><?php //echo $contact ?></td>-->
<!--                                                    <td class="text-center">
                                                        <form name="form" method="POST" action="activityeligibility.php">
                                                            <input value="<?php //echo $family_id; ?>" type="hidden" name="familyid" name="familyid">
                                                            <button type="submit" name="btn-save" class="btn bg-teal-400">Select<i class="icon-arrow-right14 position-right"></i></button>
                                                        </form>
                                                        <button class="btn bg-teal-400 btn-xs"><a href="family_activities.php?family_id=<?php //echo $family_id ?>" style="color:white">&nbsp;Select&nbsp;</a></button>
                                                    </td>-->
                                                    <?php
//                                                }
//                                            }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
//                            }
                            ?>
                        </div>       */   ?>                 
<?php                        
}
?>
<!--Grid View End-->
                        
                        
                        
                        <!-- Clickable title -->
                        <form method="post" id="frmform">
                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="text-semibold">
                                                <div class="row">                                
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="display-block">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CROPS</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-control" name="crop_id" id="crop_id">
                                                                <?php
                                                                $query = "select * from crop_master";
                                                                $results = mysql_query($query);

                                                                while ($rows = mysql_fetch_assoc($results)) {
                                                                    ?>
                                                                    <option value="<?php echo $rows['crop_name']; ?>"><?php echo $rows['crop_name']; ?></option>

                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                       <?php 
                                                            $family_query = "select * form family_crop_master where cm_id=".$_GET['getid'];
                                                            $family_crop_data = mysql_query($family_query);
                                                       ?> 
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>1. Let me know if you took <b>[**CROP**]</b> in all season.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <label class="radio-inline" for="consumed_crop">
                                                                    <input name="consumed_crop" id="consumed_crop_No" type="radio" value="Not taken this Crop">
                                                                    Not taken this Crop
                                                                </label>
                                                                <label class="radio-inline" for="consumed_crop">
                                                                    <input name="consumed_crop" id="consumed_crop_Kharip" type="radio" value="Yes, in Kharip only">
                                                                    Yes, in Kharif only
                                                                </label>
                                                                <label class="radio-inline" for="consumed_crop">
                                                                    <input name="consumed_crop" id="consumed_crop_Rabi" type="radio" value="Yes, in Rabi only">
                                                                    Yes, in Rabi only
                                                                </label>
                                                                <label class="radio-inline" for="consumed_crop">
                                                                    <input name="consumed_crop" id="consumed_crop_Entire" type="radio" value="Yes, entire year">
                                                                    Yes, entire year
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="nextcrop">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. How much area of farmland used for <b>[**Crop**]</b> production?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" name="landarea" id="landarea" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <select name="landunit" id="landunit" class="form-control">
                                                                    <option value="null">select</option>
                                                                    <option value="Bigha">Bigha</option>
                                                                    <option value="Acres">Acres</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>3. How much total production did you get for <b>[**Crop**]?</b></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" name="totalproductionamount" id="totalproductionamount" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <select name="totalproductionunit" id="totalproductionunit" class="form-control">
                                                                    <option value="null">select</option>
                                                                    <option value="Kilogram">Kilogram</option>
                                                                    <option value="Quintal">Quintal</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>4. How much quantity of total production did you sell for <b>[**Crop**]</b>?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" name="soldamount" id="soldamount" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <select name="soldunit" id="soldunit" class="form-control">
                                                                    <option value="null">select</option>
                                                                    <option value="Kilogram">Kilogram</option>
                                                                    <option value="Quintal">Quintal</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>5. How much expenditure you incurred in producing <b>[**Crop**]</b>?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="expenditure" id="expenditure" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>6. What was the market rate for <b>[**Crop**]</b>?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" name="marketrate" id="marketrate" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <select name="marketrateunit" id="marketrateunit" class="form-control">
                                                                    <option value="null">select</option>
                                                                    <option value="Kilogram">Kilogram</option>
                                                                    <option value="Quintal">Quintal</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>7. How much production you were executing from the irrigated land for <b>[**Crop**]</b>?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" name="productionamount" id="productionamount" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <select name="productionunit"  id="productionunit" class="form-control">
                                                                    <option value="null">select</option>
                                                                    <option value="Kilogram">Kilogram</option>
                                                                    <option value="Quintal">Quintal</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
<?php
if($sql_fm_rows == 0)
{    
?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>8. Do you do traditional cultivation for paddy (Rice)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline">
                                                                        <input name="ispaddy" id="ispaddyNo" type="radio" value="No- we do not cultivate paddy (Rice)">
                                                                        No- we do not cultivate paddy (Rice)
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="ispaddy" id="ispaddyNoTraditional" type="radio" value="No- we do not do traditional cultivation for paddy (Rice)">
                                                                        No- we do not do traditional cultivation for paddy (Rice)
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="ispaddy" id="ispaddyYes" type="radio" value="Yes">
                                                                        Yes
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>9. Are you wiling to adopt new technologies?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline" for="newtech">
                                                                        <input name="newtech" id="newtechYes" type="radio" value="Yes">
                                                                        Yes  
                                                                    </label>
                                                                    <label class="radio-inline" for="newtech">
                                                                        <input name="newtech" id="newtechNo" type="radio" value="No">
                                                                        No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q10">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>10. Why you are not willing to adopt new technologies? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="technology[]" id="technology">
                                                                        <option value="Do not trust new technology">Do not trust new technology</option>
                                                                        <option value="Do not have Skill to operate">Do not have Skill to operate</option>
                                                                        <option value="Maintenance is high">Maintenance is high</option>
                                                                        <option value="Do not have money">Do not have money</option>
                                                                        <option value="Do not nave enough land">Do not nave enough land</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div><br/>
                                                                <div id="dvOther">
                                                                    <input type="text" id="txtother" class="form-control" placeholder="If Other than Specify">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <label><h6><b>Desh Bandhu and Manju Gupta Foundation is non Government and not for profit organization working in Dhule district for upliftment of poor families socially and economically.</b></h6></label><br/>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>11. In agricultural sector, which most important technological support you are expecting from DBMGF?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline">
                                                                        <input name="techsupport" id="techsupportAgri" type="radio" value="Agriculture technology">
                                                                        Agriculture technology  
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupport" id="techsupportSkill" type="radio" value="Skill Training">
                                                                        Skill Training
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupport" id="techsupportWater" type="radio" value="Water">
                                                                        Water 
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupport" id="techsupportEnterpr" type="radio" value="Entrepreneurship Development Programs">
                                                                        Entrepreneurship Development Programs
                                                                    </label><br/>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupport" id="techsupportActivity" type="radio" value="Agriculture allied activities">
                                                                        Agriculture allied activities
                                                                    </label>
                                                                    <label class="radio-inline"> 
                                                                        Other
                                                                    </label>
                                                                    <div class="radio-inline">
                                                                        <input type="text" class="form-control" name="techsupportOther" id="techsupportOther">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>12.In agriculture sector, which second important technological support you are expecting from DBMGF? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportsecond" id="techsupportsecondAgri" type="radio" value="Agriculture technology">
                                                                        Agriculture technology  
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportsecond" id="techsupportsecondSkill" type="radio" value="Skill Training">
                                                                        Skill Training
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportsecond" id="techsupportsecondWater" type="radio" value="Water">
                                                                        Water 
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportsecond" id="techsupportsecondEnterpre" type="radio" value="Entrepreneurship Development Programs">
                                                                        Entrepreneurship Development Programs
                                                                    </label><br/>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportsecond" id="techsupportsecondActivity" type="radio" value="Agriculture allied activities">
                                                                        Agriculture allied activities
                                                                    </label>
                                                                    <label class="radio-inline"> 
                                                                        Other
                                                                    </label>
                                                                    <div class="radio-inline">
                                                                        <input type="text" class="form-control" id="techsupportsecondOther" name="techsupportsecondOther">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>13. In agriculture sector, which hird important technological support you are expecting from DBMGF?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportthird" id="techsupportthirdAgri" type="radio" value="Agriculture technology">
                                                                        Agriculture technology  
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportthird" id="techsupportthirdSkill" type="radio" value="Skill Training">
                                                                        Skill Training
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportthird" id="techsupportthirdWater" type="radio" value="Water">
                                                                        Water 
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportthird" id="techsupportthirdEnterpre" type="radio" value="Entrepreneurship Development Programs">
                                                                        Entrepreneurship Development Programs
                                                                    </label><br/>
                                                                    <label class="radio-inline">
                                                                        <input name="techsupportthird" id="techsupportthirdActivity" type="radio" value="Agriculture allied activities">
                                                                        Agriculture allied activities
                                                                    </label>
                                                                    <label class="radio-inline"> 
                                                                        Other
                                                                    </label>
                                                                    <div class="radio-inline">
                                                                        <input type="text" name="techsupportthirdOther" class="form-control" id="techsupportthirdOther">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>14. Are you willing to do Group Well (GW) irrigation?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline" for="wellirrigation">
                                                                        <input name="wellirrigation" id="wellirrigationYes" type="radio" value="Yes">
                                                                        Yes 
                                                                    </label>
                                                                    <label class="radio-inline" for="wellirrigation">
                                                                        <input name="wellirrigation" id="wellirrigationNo" type="radio" value="No">
                                                                        No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q15">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>15. Why you are not willing to do Group Well (GW) irrigation?  </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" id="irrigation" name="irrigation[]">
                                                                        <option value="No money">No money</option>
                                                                        <option value="No one will provide it/do not know who will provide it">No one will provide it/do not know who will provide it</option>
                                                                        <option value="We think that it will be waste of money">We think that it will be waste of money</option>
                                                                        <option value="We do not need it (like We have own/lease well or rain, surface water is enough)">We do not need it (like We have own/lease well or rain, surface water is enough)</option>
                                                                        <option value="Groud water level is far below (not possible to dug the well)">Groud water level is far below (not possible to dug the well)</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div><br/>
                                                                <div id="dvOther1">
                                                                    <input type="text" id="txtother1" class="form-control" placeholder="If Other than Specify">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>16.Which type of source you are going to use for Group Well (GW)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline">
                                                                        <input name="gwsource" id="gwsourceDug" type="radio" value="Dug Well">
                                                                        Dug Well
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="gwsource" id="gwsourceBore" type="radio" value="Bore well">
                                                                        Bore well
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="gwsource" id="gwsourceCanal" type="radio" value="Canal/Check dam">
                                                                        Canal/Check dam
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        Other
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input type="text" name="gwsourceOther" id="gwsourceOther" class="form-control">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>17. Are you ready to make available your land for Group Well (GW) irrigation?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline" for="landavailable">
                                                                        <input name="landavailable" id="landavailableYes" type="radio" value="Yes">
                                                                        Yes 
                                                                    </label>
                                                                    <label class="radio-inline" for="landavailable">
                                                                        <input name="landavailable" id="landavailableNo" type="radio" value="No">
                                                                        No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q18">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>18. Why you are not ready to make available your land for Group Well (GW) irrigation?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="nolandreasone[]" id="nolandreasone">
                                                                        <option value="Not interested">Not interested</option>
                                                                        <option value="Have very less land">Have very less land</option>
                                                                        <option value="Water is not available under my land">Water is not available under my land</option>
                                                                        <option value="Do not know what benefits we will get">Do not know what benefits we will get</option>
                                                                        <option value="We have own/ lease well">We have own/ lease well</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div><br/>
                                                                <div id="dvOther1">
                                                                    <input type="text" id="txtother1" class="form-control" placeholder="If Other than Specify">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
<?php
}
?>                                                    
                                                </div>
<?php
if($sql_fm_rows == 0)
{    
?>
                                                <div class="text-right stepy-finish">
                                                    <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">Submit<i class="icon-arrow-right14 position-right"></i></button>
                                                </div>
<?php
}
else
{
?>
                                                <div class="text-right stepy-finish">
                        <?php
                        if($sql_fm_rows == 4)
                        {  
                            ?>
                                                    <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">Next<i class="icon-arrow-right14 position-right"></i></button>
                            <?php
                        }
                        else
                        {
                        ?>
                                                    <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">ADD More<i class="icon-arrow-right14 position-right"></i></button>
                                                    <a href="self_employment.php" class="btn btn-primary stepy-finish">Next</a>
                        <?php
                        }
                        ?>

                                                </div>
<!--                                                <div class="text-right stepy-finish">
                                                    
                                                </div>                                                -->
<?php    
}
?>                                                
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /clickable title -->
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
