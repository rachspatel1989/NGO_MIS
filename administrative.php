<?php
session_start();
include_once 'include/DB_Functions.php';
$db = new DB_Functions();
include_once 'administrative_insert.php';

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
                $("#benefithide").hide();
                $("#chkYes").on("input", function () {
                    $("#benefithide").toggle();
                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("input[name='recievebenefit']").click(function () {
                    if ($("#chkNo").is(":checked")) {
                        $("#benefithide").hide();
                    } else {
                        $("#benefithide").show();
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>A. Administrative</b></a></li>
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
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Greetings!  My name is</label> 
                                                            <input type="text" name="hhheadname" id="hhheadname" class="form-control" placeholder="Name"> 
                                                            <label> I am working for Desh Bandhu & Manju Gupta (DBMG) Foundationbased in Dhule, whichworks at grassroot level for rural development.  We aredoing a survey to understand your household’sinformation. You will complete a 15 minute questionnaire which asks about people in your household, their education, income, expenditure, and farming.  The results from this survey will be used by us to improve livelihood in this region. </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="display-block text-semibold">1. Are you willing to participate in this interview?</label>
                                                            <label class="radio-inline">
                                                                <input name="participates" id="participateNo" value="No" type="radio">
                                                                No
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="participates" id="participateYes" value="Yes" type="radio">
                                                                Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>2. Number of visits made to complete interviews:</label>
                                                            <input type="text" name="noofvisit" id="noofvisit" class="form-control" placeholder="Number of Visits">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>3. Date: </label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                                <input class="form-control daterange-single" type="text" name="interview_date" id="interview_date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="content-group-lg">
                                                            <label>4. Time Begun:</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="icon-watch2"></i></span>
                                                                <input type="text" class="form-control" name="time_begun" id="anytime-time" readonly="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="content-group-lg">
                                                            <label>5. Time End:</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="icon-watch2"></i></span>
                                                                <input type="text" class="form-control" name="time_end" id="anytime-time" value="12:34" readonly="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="content-group-lg">
                                                            <label>6. Duration:</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="icon-watch2"></i></span>
                                                                <input readonly="" class="form-control" id="time_duration" name="time_duration" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="content-group-lg">
                                                            <label>11. What is the Result of Interview?</label>
                                                            <input type="text" class="form-control" name="interview_result" id="interview_result" placeholder="Result of Interview">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="panel-heading">
                                                        <h6 class="panel-title"><b>Y. Eligibility to Receive Benefits</b></h6>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label><b>Explain about DBMG foundation</b>.Desh Bandhu and Manju Gupta Foundation is non Government and not for proft organization working in Dhule district for upliftment of poor families socially and economically.</label> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="display-block">1. Did you or any member of your family that lives with you now / or used to live with you in past 5 years (since 2010) received any benefits from DBMG foundation?</label>
                                                            <label class="radio-inline" for="chkNo">
                                                                <input type="radio" name="recievebenefit" id="chkNo" value="No">
                                                                No
                                                            </label>
                                                            <label class="radio-inline" for="chkYes">
                                                                <input type="radio" name="recievebenefit" id="chkYes" value="Yes">
                                                                Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="benefithide">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>2. Which scheme or benefits did you receive from DBMG Foundation? </label>
                                                            <div class="multi-select-full">
                                                                <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="schemereceive[]" id="schemereceive">
                                                                    <option value="Vegetable Cultivation">Vegetable Cultivation(Tomato, Chilli, Bhendi, Gavar, Cauliflower, etc)</option>
                                                                    <option value="Yield Enhancement">Yield Enhancement(SRI/ Soyabean/ Tur/ Moong/ Gram / Wheat)</option>
                                                                    <option value="Cattle Induction">Cattle Induction</option>
                                                                    <option value="Poultry">Poultry</option>
                                                                    <option value="Group well">Group well</option>
                                                                    <option value="Land Levelling">Land Leveling</option>
                                                                    <option value="Support for Self Employment">Grant / Credit Support for Self Employment</option>
                                                                    <option value="Wage Employment">Wage Employment</option>
                                                                    <option value="Orchard Development">Orchard Development (Mango, Acid Lime, Pomegranate, Ber, Gauvaetc)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="content-group-lg">
                                                            <label class="display-block">3. How will you rate the help received by these schemes/benefits in improving your livelihood?</label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="rate" id="rate" value="Not Improved">
                                                                Not improved
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="rate" id="rate" value="Somewhat Improved">
                                                                Somewhat improved
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="rate" id="rate" value="Improved">
                                                                Improved
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="rate" id="rate" value="Don't know">
                                                                Don’t know
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="text-right">
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
