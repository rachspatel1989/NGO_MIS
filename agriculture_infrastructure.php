<?php
session_start();
include_once 'include/DB_Functions.php';
$db = new DB_Functions();
//include_once 'agriculture_infrastructure_insert.php';
include_once 'agriculture_infrastructure_insert.php';

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

        <!-- /theme JS files -->
        <script type="text/javascript">
            $(function () {
                $("#hidedata").hide();
                $("#farmlandYes").on("input", function () {
                    $("#hidedata").toggle();
                });
            });
        </script> 
        <script type="text/javascript">
            $(function () {
                $("input[name='havefarmland']").click(function () {
                    if ($("#farmlandYes").is(":checked")) {
                        $("#hidedata").show();
                    }
                    if ($("#farmlandNo").is(":checked")) {
                        $("#hidedata").hide();
                    }
                });
            });
        </script>

        <!--checkbox-->
        <script type="text/javascript">
            $(document).ready(function () {
                //Uncheck the CheckBox initially
                $('#ownfarmland').removeAttr('checked');
                // Initially, Hide the SSN textbox when Web Form is loaded
                $('#ownland').hide();
                $('#landtype').hide();
                $('#ownfarmland').change(function () {
                    if (this.checked) {
                        $('#ownland').show();
                        $('#landtype').show();
                    } else {
                        $('#ownland').hide();
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                //Uncheck the CheckBox initially
                $('#leasefarmland').removeAttr('checked');
                // Initially, Hide the SSN textbox when Web Form is loaded
                $('#leaseland').hide();
                $('#landtype').hide();
                $('#leasefarmland').change(function () {
                    if (this.checked) {
                        $('#leaseland').show();
                        $('#landtype').show();
                    } else {
                        $('#leaseland').hide();
                    }
                });
            });
        </script>


        <script type="text/javascript">
            $(function () {
                $("#Q21").hide();
                $("#usepumpYes").on("input", function () {
                    $("#Q21").toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='usepump']").click(function () {
                    if ($("#usepumpNo").is(":checked")) {
                        $("#Q21").hide();
                    }
                    if ($("#usepumpYes").is(":checked")) {
                        $("#Q21").show();
                    }

                });
            });
        </script>

        <script>
            function addMore() {
                $("<div>").load("agriculture_infrastructure_irrigation_array.php", function () {
                    $("#product").append($(this).html());
                });
            }
            function deleteRow() {
                $('div.product-item').each(function (index, item) {
                    jQuery(':checkbox', this).each(function () {
                        if ($(this).is(':checked')) {
                            $(item).remove();
                        }
                    });
                });
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>E. Agriculture Infrastructure</b></a></li>
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
                        <form method="post" id="frmform">
                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="text-semibold">
                                                <div class="row">                                
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="display-block">1. Does HH own or lease farmland?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <label class="radio-inline" for="havefarmland">
                                                                    <input name="havefarmland" id="farmlandNo" type="radio" value="No">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline" for="havefarmland">
                                                                    <input name="havefarmland" id="farmlandYes" type="radio" value="Yes">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="hidedata">
                                                    <div class="row">                                
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. Do you <b>[**READ**]</b> any farm land?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="checkbox-inline" for="ownfarmland">
                                                                    <input name="ownfarmland" id="ownfarmland" type="checkbox" value="Own">
                                                                    <b>Own</b>
                                                                </label>
                                                                <label class="checkbox-inline" for="leasefarmland">
                                                                    <input name="leasefarmland" id="leasefarmland" type="checkbox" value="Lease">
                                                                    <b>Lease</b>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="row">

                                                            <div class="col-md-4" id="landtype">
                                                                <fieldset class="text-semibold">
                                                                    <div class="form-group">
                                                                    </div><br/><br/>
                                                                    <div class="form-group">
                                                                        <label>3. Area</label>
                                                                    </div><br/><br/><br/><br/>
                                                                    <div class="form-group">
                                                                        <label>4. How much would it cost to buy this land today?</label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>5. How much would it cost per year to lease this land?</label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>6. How much land is <b>irrigated / under</b> water? (Enter 0 if none of the land is under irrigation)</label>
                                                                    </div><br/><br/><br/>
                                                                    <div class="form-group">
                                                                        <label>7. Currently, how much land is <b>undulating?</b> (Enter 0 if do not have undulating land)</label>
                                                                    </div><br/><br/><br/>
                                                                    <div class="form-group">
                                                                        <label>8. Currently, how much land is <b>waste/ uncultivable </b>? (Enter 0 if do not have waste land)</label>
                                                                    </div><br/><br/>
                                                                    <div class="form-group">
                                                                        <label>9. In past 1 year, how much <b>undulating land</b> is leveled? (Ask if have undulating land. Enter 0 if none of the undulating land is leveled)</label>
                                                                    </div><br/><br/><br/>
                                                                    <div class="form-group">
                                                                        <label>10. In past 1 year, how much area of <b>waste land</b> brought into the cultivable/ irrigation? (Ask if waste land available. Enter 0 if none of the waste land brought into irrigation)</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-4" id="ownland">
                                                                <fieldset class="text-semibold">
                                                                    <div class="form-group">
                                                                        <input type="text" name="owntype" id="owntype" class="form-control" value="Own">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="ownareaunit" id="ownareaunit" class="form-control">
                                                                            <option value="null">Select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="ownarea" id="ownarea" class="form-control" placeholder="(1 to 200)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="owncost" id="owncost" class="form-control"  placeholder="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="owncost1" id="owncost1" class="form-control" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="ownirrigatedunit" id="ownirrigatedunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <input type="text" name="ownirrigatedarea" id="ownirrigatedarea" class="form-control" placeholder="(0 to 100)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="ownundulatingunit" id="ownundulatingunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="ownundulatingarea" id="ownundulatingarea" class="form-control" placeholder="Enter 0 if do not have undulation land">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="ownwasteunit" id="ownwasteunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="ownwastearea" id="ownwastearea" class="form-control"  placeholder="(Enter 0 if do no have waste land)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="ownleveledunit" id="ownleveledunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="ownleveledarea" id="ownleveledarea" class="form-control" placeholder="(Enter 0 if none of the undulating land is leveled.)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="ownunderirrigationunit" id="ownunderirrigationunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="ownunderirrigationarea" id="ownunderirrigationarea" class="form-control" placeholder="(Enter 0 if none of the waste land brought into irrigation)">
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-4" id="leaseland">
                                                                <fieldset class="text-semibold">
                                                                    <div class="form-group">
                                                                        <input type="text" name="leasetype" id="leasetype" class="form-control" value="Lease">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="leaseareaunit" id="leaseareaunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="leasearea" class="form-control" placeholder="(1 to 200)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="leasecost" id="leasecost" class="form-control" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="leasecost1" id="leasecost1" class="form-control" placeholder="(Rs.1000 to Rs.90 lakh per acre)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="leaseirrigatedunit" id="leaseirrigatedunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="leaseirrigatedarea" id="leaseirrigatedarea" class="form-control" placeholder="Enter 0 if none of the land is under irrigation)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="leaseundulatingunit" id="leaseundulatingunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="leaseundulatingarea" id="leaseundulatingarea" class="form-control" placeholder="(Enter 0 if do not have undulating land)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="leasewasteunit" id="leasewasteunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="leasewastearea" id="leasewastearea" class="form-control" placeholder="(Enter 0 if do not have waste land)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="leaseleveledunit" id="leaseleveledunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="leaseleveledarea" id="leaseleveledarea" class="form-control" placeholder="(Enter 0 if none of the undulating land is leveled)">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <select name="leaseunderirrigationunit" id="leaseunderirrigationunit" class="form-control">
                                                                            <option value="null">select</option>
                                                                            <option value="Bigha">Bigha</option>
                                                                            <option value="Acres">Acres</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" name="leaseunderirrigationarea" id="leaseunderirrigationarea" class="form-control" placeholder="(Enter 0 if none of the waste land brought into irrigation)">
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-flat">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <fieldset class="text-semibold">
                                                                        <div class="row">
                                                                            <div id="outer">
                                                                                <div class="content-group" id="header">
                                                                                    <div id="l2">
                                                                                        <h6 class="panel-title"><b>Source of Irrigation</b></h6>
                                                                                    </div>
                                                                                    <div id="product">
                                                                                        <?php require_once("agriculture_infrastructure_dugwell.php") ?>
                                                                                    </div>
                                                                                    <div id="product">
                                                                                        <?php require_once("agriculture_infrastructure_borewell.php") ?>
                                                                                    </div>
                                                                                    <div id="product">
                                                                                        <?php require_once("agriculture_infrastructure_pipeline.php") ?>
                                                                                    </div>
<!--                                                                                    <div class="btn-action float-clear">
                                                                                        <input type="button" name="add_item" value="Add More" onClick="addMore();" />
                                                                                        <input type="button" name="del_item" value="Delete" onClick="deleteRow();" />
                                                                                        <span class="success"><?php
//                                                                                        if (isset($message)) {
//                                                                                            echo $message;
//                                                                                        }
                                                                                        ?></span>
                                                                                    </div>-->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="row" id="Q201">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>20. At what level the ground water is available in your village?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="water_own" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q202">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>20. Do you use pumps to draw waters from above source?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="radio">
                                                                    <label class="radio-inline">
                                                                        <input name="usepump" id="usepumpNo" type="radio" value="No">
                                                                        No
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input name="usepump" id="usepumpYes" type="radio" value="Yes">
                                                                        Yes
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q21">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>21. How many pumps do you have (combine for all farmlands owned and leased)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="water_own" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <div class="text-right stepy-finish">
                                                        <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">Submit & Next <i class="icon-arrow-right14 position-right"></i></button>
                                                    </div>
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
