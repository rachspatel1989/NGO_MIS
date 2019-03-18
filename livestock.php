<?php
session_start();
include_once 'include/DB_Functions.php';
$db = new DB_Functions();
include_once 'livestock_insert.php';

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
                $("#livestock").hide();
                $('#hidecow').hide();
                $('#hidebuffaloes').hide();
                $('#hidegoat').hide();
                $('#hidesheep').hide();
                $('#hidepoultry').hide();
                $('#hideanimal').hide();
                $('#hidebird').hide();
                $("#hormfarmYes").on("input", function () {
                    $("#livestock").toggle();
                    $("#hidecow").toggle();
                    $('#hidebuffaloes').toggle();
                    $('#hidegoat').toggle();
                    $('#hidesheep').toggle();
                    $('#hidepoultry').toggle();
                    $('#hideanimal').toggle();
                    $('#hidebird').toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("input[name='hormfarm']").click(function () {
                    if ($("#hormfarmNo").is(":checked")) {
                        $("#livestock").hide();
                        $('#hidecow').hide();
                        $('#hidebuffaloes').hide();
                        $('#hidegoat').hide();
                        $('#hidesheep').hide();
                        $('#hidepoultry').hide();
                        $('#hideanimal').hide();
                        $('#hidebird').hide();
                    } else {
                        $("#livestock").show();
                    }
                });
            });
        </script>


<!--        <script type="text/javascript">
     $(function () {
         $("input[id='benefitsgot']").click(function () {
              if ($("#homepurpose").is(":checked")) {
                 $("#Q6").hide();
                 $("#Q7").hide();
                 $("#Q8").hide();
             } else {
                 $("#Q6").show();
                 $("#Q7").show();
                 $("#Q8").show();
             }
             }
         });
     });
 </script>-->

        <!-- Page Load Hide Div -->
        <script type="text/javascript">
            $(function () {
                $('#hidecow').hide();
                $('#hidebuffaloes').hide();
                $('#hidegoat').hide();
                $('#hidesheep').hide();
                $('#hidepoultry').hide();
                $('#hideanimal').hide();
                $('#hidebird').hide();
                $("#livestocktype").on("input", function () {
                    $("#hidecow").toggle();
                    $('#hidebuffaloes').toggle();
                    $('#hidegoat').toggle();
                    $('#hidesheep').toggle();
                    $('#hidepoultry').toggle();
                    $('#hideanimal').toggle();
                    $('#hidebird').toggle();
                });
            });
        </script>
        <script type="text/javascript">
            $(function () {
                $('#livestocktype').change(function () {
                    $('#hidecow').hide();
                    $('#hidebuffaloes').hide();
                    $('#hidegoat').hide();
                    $('#hidesheep').hide();
                    $('#hidepoultry').hide();
                    $('#hideanimal').hide();
                    $('#hidebird').hide();
                    if ($(this).val() === "Cow") {
                        $('#hidecow').show();
                    } else if ($(this).val() === "Buffaloes") {
                        $('#hidebuffaloes').show();
                    } else if ($(this).val() === "Goat") {
                        $('#hidegoat').show();
                    } else if ($(this).val() === "Sheep") {
                        $('#hidesheep').show();
                    } else if ($(this).val() === "Poultry Birds") {
                        $('#hidepoultry').show();
                    } else if ($(this).val() === "Other Domestic Animal") {
                        $('#hideanimal').show();
                    } else if ($(this).val() === "Other Domestic Bird") {
                        $('#hidebird').show();
                    } else {
                        $('#hidecow').hide();
                        $('#hidebuffaloes').hide();
                        $('#hidegoat').hide();
                        $('#hidesheep').hide();
                        $('#hidepoultry').hide();
                        $('#hideanimal').hide();
                        $('#hidebird').hide();
                    }
                });
            });
        </script>

<!--   <script>
            // just for the demos, avoids form submit
            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
            });
            $("#frmform").validate({
                rules: {
                    income: {
                        required: true,
                        min: 1000,
                        max: 300000
                    },
                    expenditure: {
                        required: true,
                        min: 10,
                        max: 15000
                    },
                    milk: {
                        required: true,
                        min: 1,
                        max: 100
                    },
                    ratebaby: {
                        required: true,
                        min: 500,
                        max: 30000
                    },
                    ratefullgrown: {
                        required: true,
                        min: 500,
                        max: 60000
                    },
                    ratemilk: {
                        required: true,
                        min: 10,
                        max: 150
                    }
                }
            });
        </script>-->
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>D. Livestock</b></a></li>
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
                                                        <div class="form-group">
                                                            <label>1. Do you have the <b>[**Livestock**]</b> in your home or farm?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="radio">
                                                                <label class="radio-inline" for="hormfarm">
                                                                    <input name="hormfarm" id="hormfarmNo" type="radio" value="No">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline" for="hormfarm">
                                                                    <input name="hormfarm" id="hormfarmYes" type="radio" value="Yes">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script type="text/javascript">
                                                    $(function () {
                                                        $("input[name='hormfarm']").click(function () {
                                                            if ($("#hormfarmNo").is(":checked")) {
                                                                document.getElementById("btn-save").disabled = true;
                                                            }
                                                            if ($("#hormfarmYes").is(":checked")) {
                                                                document.getElementById("btn-save").disabled = false;
                                                            }
                                                        });
                                                    });
                                                </script>
                                                <div class="row" id="livestock">                                
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="display-block">&nbsp;&nbsp;&nbsp;&nbsp;<b>Livestock</b></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-control" name="livestocktype" id="livestocktype">
                                                                <option value="null">Select</option>
                                                                <option value="Cow">Cow</option>
                                                                <option value="Buffaloes">Buffaloes</option>
                                                                <option value="Goat">Goat</option>
                                                                <option value="Sheep">Sheep</option>
                                                                <option value="Poultry Birds">Poultry Birds</option>
                                                                <option value="Other Domestic Animal">Other Domestic Animal</option>
                                                                <option value="Other Domestic Bird">Other Domestic Bird</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cow -->
                                                <div id="hidecow">
                                                    <div class="row" id="Q2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. How many existing <b>[**Livestock**]</b> you have in the home?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="indigenousnreed">A. Indigenous Breed</label>
                                                                <input type="text" name="indigenousnreed" id="indigenousnreed" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="crossbreed">B. Cross breed</label>
                                                                <input type="text" name="crossbreed" id="crossbreed" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="income">3. How much income you have received from <b>[**Livestock**]</b> in last 1 year?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="income" id="income" class="form-control" placeholder="Rupees(1000 to 300000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q4">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="expenditure">4. In last one month, how much expenditure you spend on the <b>[**Livestock**]</b> activity (cost includes all inputs and transportation, labor cost may excluded with assumption that family members is the main labor for the activity)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="expenditure" id="expenditure" class="form-control" placeholder="Rupees(10 to 15000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q5">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>5. What benefits you got from the <b>[**Livestock**]</b> in last 1 year? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <label><b>Sell in the market</b></label>
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="benefitsgot[]" id="benefitsgotcow">
                                                                        <option value="Home purpose use" id="homepurpose">Home purpose use</option>
                                                                        <option value="livestock-Baby">livestock-Baby</option>
                                                                        <option value="livestock-Fully grown">livestock-Fully grown</option>
                                                                        <option value="livestock-Meat">livestock-Meat</option>
                                                                        <option value="livestock-Egg">livestock-Egg</option>
                                                                        <option value="livestock-Milk">livestock-Milk</option>
                                                                        <option value="livestock-Fur">livestock-Fur</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="Q6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>6. How much quantity of [**Benefit**] you get from [**Livestock**] in a day/ month?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="milk">Milk (Liters per day)</label>
                                                                    <input type="text" name="milk" id="milk" class="form-control" placeholder="Milk(1 to 100)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Q7">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>7. What is the rate of <b>[**Livestock**]</b> for <b>[**Benefit**]</b>? </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratebaby">Sell  of 1 baby of [**Livestock**]</label>
                                                                    <input type="text" name="ratebaby" id="ratebaby" class="form-control" placeholder="Rupees per Baby(500 to 30000)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratefullgrown">Sell  of 1 Full grown of[**Livestock**]</label>
                                                                    <input type="text" name="ratefullgrown" id="ratefullgrown" class="form-control" placeholder="Rupees per Full Grown livestock(500 to 60000)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6"></div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="ratemilk">Per liter milk of  [**Livestock**]</label>
                                                                    <input type="text" name="ratemilk" id="ratemilk" class="form-control" placeholder="per litter Milk(10 to 150)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q8">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>8. Is market easily accessible in the vicinity to sell things received from <b>[**Livestock**]?</b> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value=" Within village" type="radio">
                                                                    Within village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 1 KM peripheral from village" type="radio">
                                                                    Within 1 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 5 KM peripheral from village" type="radio">
                                                                    Within 5 KM peripheral from village
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="More than 5 KM peripheral from village" type="radio">
                                                                    More than 5 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Don't know" type="radio">
                                                                    Don't know
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q9">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>9. Do you have past experience of livestock management? (Cattle Rearing)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="Yes" type="radio">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Buffaloes -->
                                                <div id="hidebuffaloes">
                                                    <div class="row" id="Q2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. How many existing <b>[**Livestock**]</b> you have in the home?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="indigenousnreedbuff">A. Indigenous Breed</label>
                                                                <input type="text" name="indigenousnreedbuff" id="indigenousnreedbuff" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="crossbreedbuff">B. Cross breed</label>
                                                                <input type="text" name="crossbreedbuff" id="crossbreedbuff" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="incomebuff">3. How much income you have received from <b>[**Livestock**]</b> in last 1 year?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="incomebuff" id="incomebuff" class="form-control" placeholder="Rupees(1000 to 300000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q4">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="expenditurebuff">4. In last one month, how much expenditure you spend on the <b>[**Livestock**]</b> activity (cost includes all inputs and transportation, labor cost may excluded with assumption that family members is the main labor for the activity)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="expenditurebuff" id="expenditurebuff" class="form-control" placeholder="Rupees(10 to 15000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q5">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>5. What benefits you got from the <b>[**Livestock**]</b> in last 1 year? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <label><b>Sell in the market</b></label>
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="benefitsgot[]" id="benefitsgot">
                                                                        <option value="Home purpose use" id="homepurpose">Home purpose use</option>
                                                                        <option value="livestock-Baby">livestock-Baby</option>
                                                                        <option value="livestock-Fully grown">livestock-Fully grown</option>
                                                                        <option value="livestock-Meat">livestock-Meat</option>
                                                                        <option value="livestock-Egg">livestock-Egg</option>
                                                                        <option value="livestock-Milk">livestock-Milk</option>
                                                                        <option value="livestock-Fur">livestock-Fur</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="Q6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>6. How much quantity of [**Benefit**] you get from [**Livestock**] in a day/ month?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="milkbuff">Milk (Liters per day)</label>
                                                                    <input type="text" name="milkbuff" id="milkbuff" class="form-control" placeholder="Milk(1 to 100)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Q7">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>7. What is the rate of <b>[**Livestock**]</b> for <b>[**Benefit**]</b>? </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratebabybuff">Sell  of 1 baby of [**Livestock**]</label>
                                                                    <input type="text" name="ratebabybuff" id="ratebabybuff" class="form-control" placeholder="Rupees per Baby(500 to 30000)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratefullgrownbuff">Sell  of 1 Full grown of[**Livestock**]</label>
                                                                    <input type="text" name="ratefullgrownbuff" id="ratefullgrownbuff" class="form-control" placeholder="Rupees per Full Grown livestock(500 to 150000)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6"></div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="ratemilkbuff">Per liter milk of  [**Livestock**]</label>
                                                                    <input type="text" name="ratemilkbuff" id="ratemilkbuff" class="form-control" placeholder="per litter Milk(10 to 150)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q8">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>8. Is market easily accessible in the vicinity to sell things received from <b>[**Livestock**]?</b> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within village" type="radio">
                                                                    Within village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 1 KM peripheral from village" type="radio">
                                                                    Within 1 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 5 KM peripheral from village" type="radio">
                                                                    Within 5 KM peripheral from village
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="More than 5 KM peripheral from village" type="radio">
                                                                    More than 5 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Don't know" type="radio">
                                                                    Don't know
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q9">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>9. Do you have past experience of livestock management? (Cattle Rearing)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="Yes" type="radio">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Goat -->
                                                <div id="hidegoat">
                                                    <div class="row" id="Q2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. How many existing <b>[**Livestock**]</b> you have in the home?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="indigenousnreedgoat">A. Indigenous Breed</label>
                                                                <input type="text" name="indigenousnreedgoat" id="indigenousnreedgoat" class="form-control" placeholder="Range(0 to 100)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="crossbreedgoat">B. Cross breed</label>
                                                                <input type="text" name="crossbreedgoat" id="crossbreedgoat" class="form-control" placeholder="Range(0 to 100)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="incomegoat">3. How much income you have received from <b>[**Livestock**]</b> in last 1 year?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="incomegoat" id="incomegoat" class="form-control" placeholder="Rupees(1000 to 300000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q4">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="expendituregoat">4. In last one month, how much expenditure you spend on the <b>[**Livestock**]</b> activity (cost includes all inputs and transportation, labor cost may excluded with assumption that family members is the main labor for the activity)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="expendituregoat" id="expendituregoat" class="form-control" placeholder="Rupees(10 to 10000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q5">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>5. What benefits you got from the <b>[**Livestock**]</b> in last 1 year? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <label><b>Sell in the market</b></label>
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="benefitsgot[]" id="benefitsgot">
                                                                        <option value="Home purpose use">Home purpose use</option>
                                                                        <option value="livestock-Baby">livestock-Baby</option>
                                                                        <option value="livestock-Fully grown">livestock-Fully grown</option>
                                                                        <option value="livestock-Meat">livestock-Meat</option>
                                                                        <option value="livestock-Egg">livestock-Egg</option>
                                                                        <option value="livestock-Milk">livestock-Milk</option>
                                                                        <option value="livestock-Fur">livestock-Fur</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="Q6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>6. How much quantity of [**Benefit**] you get from [**Livestock**] in a day/ month?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="meatgoat">Meat (kgs per month)</label>
                                                                    <input type="text" name="meatgoat" id="meatgoat" class="form-control" placeholder="Meat(1 to 100)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="milkgoat">Milk (Liters per day)</label>
                                                                    <input type="text" name="milkgoat" id="milkgoat" class="form-control" placeholder="Milk(1 to 200)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Q7">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>7. What is the rate of <b>[**Livestock**]</b> for <b>[**Benefit**]</b>? </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratebabygoat">Sell  of 1 baby of [**Livestock**]</label>
                                                                    <input type="text" name="ratebabygoat" id="ratebabygoat" class="form-control" placeholder="Rupees per Baby(500 to 30000)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratefullgrowngoat">Sell  of 1 Full grown of[**Livestock**]</label>
                                                                    <input type="text" name="ratefullgrowngoat" id="ratefullgrown" class="form-control" placeholder="Rupees per Full Grown livestock(500 to 60000)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratemeatgoat">Per KG meat of [**Livestock**]</label>
                                                                    <input type="text" name="ratemeatgoat" id="ratemeatgoat" class="form-control" placeholder="per kg Meat">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratemilkgoat">Per liter milk of  [**Livestock**]</label>
                                                                    <input type="text" name="ratemilkgoat" id="ratemilkgoat" class="form-control" placeholder="per litter Milk(10 to 150)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q8">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>8. Is market easily accessible in the vicinity to sell things received from <b>[**Livestock**]?</b> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value=" Within village" type="radio">
                                                                    Within village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 1 KM peripheral from village" type="radio">
                                                                    Within 1 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 5 KM peripheral from village" type="radio">
                                                                    Within 5 KM peripheral from village
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="More than 5 KM peripheral from village" type="radio">
                                                                    More than 5 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Don't know" type="radio">
                                                                    Don't know
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q9">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>9. Do you have past experience of livestock management? (Cattle Rearing)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="Yes" type="radio">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Sheep -->
                                                <div id="hidesheep">
                                                    <div class="row" id="Q2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. How many existing <b>[**Livestock**]</b> you have in the home?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="indigenousnreedsheep">A. Indigenous Breed</label>
                                                                <input type="text" name="indigenousnreedsheep" id="indigenousnreedsheep" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="crossbreedsheep">B. Cross breed</label>
                                                                <input type="text" name="crossbreedsheep" id="crossbreedsheep" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="incomesheep">3. How much income you have received from <b>[**Livestock**]</b> in last 1 year?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="incomesheep" id="incomesheep" class="form-control" placeholder="Rupees(1000 to 300000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q4">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="expendituresheep">4. In last one month, how much expenditure you spend on the <b>[**Livestock**]</b> activity (cost includes all inputs and transportation, labor cost may excluded with assumption that family members is the main labor for the activity)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="expendituresheep" id="expendituresheep" class="form-control" placeholder="Rupees(10 to 10000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q5">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>5. What benefits you got from the <b>[**Livestock**]</b> in last 1 year? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <label><b>Sell in the market</b></label>
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="benefitsgot[]" id="benefitsgot">
                                                                        <option value="Home purpose use">Home purpose use</option>
                                                                        <option value="livestock-Baby">livestock-Baby</option>
                                                                        <option value="livestock-Fully grown">livestock-Fully grown</option>
                                                                        <option value="livestock-Meat">livestock-Meat</option>
                                                                        <option value="livestock-Egg">livestock-Egg</option>
                                                                        <option value="livestock-Milk">livestock-Milk</option>
                                                                        <option value="livestock-Fur">livestock-Fur</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="Q6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>6. How much quantity of [**Benefit**] you get from [**Livestock**] in a day/ month?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="meatsheep">Meat (kgs per month)</label>
                                                                    <input type="text" name="meatsheep" id="meatsheep" class="form-control" placeholder="Meat(1 to 50)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="milksheep">Milk (Liters per day)</label>
                                                                    <input type="text" name="milksheep" id="milksheep" class="form-control" placeholder="Milk(1 to 200)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="fursheep">Fur (kgs per year)</label>
                                                                    <input type="text" name="fursheep" id="fursheep" class="form-control" placeholder="Fur(5 to 500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Q7">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>7. What is the rate of <b>[**Livestock**]</b> for <b>[**Benefit**]</b>? </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratebabysheep">Sell  of 1 baby of [**Livestock**]</label>
                                                                    <input type="text" name="ratebabysheep" id="ratebabysheep" class="form-control" placeholder="Rupees per Baby(500 to 30000)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratefullgrownsheep">Sell  of 1 Full grown of[**Livestock**]</label>
                                                                    <input type="text" name="ratefullgrownsheep" id="ratefullgrownsheep" class="form-control" placeholder="Rupees per Full Grown livestock(500 to 30000)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="ratemeatsheep">Per KG meat of [**Livestock**]</label>
                                                                    <input type="text" name="ratemeatsheep" id="ratemeatsheep" class="form-control" placeholder="per kg Meat(20 to 1000)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratemilksheep">Per liter milk of  [**Livestock**]</label>
                                                                    <input type="text" name="ratemilksheep" id="ratemilksheep" class="form-control" placeholder="per litter Milk(10 to 150)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratefursheep">Per KG fur of [**Livestock**]</label>
                                                                    <input type="text" name="ratefursheep" id="ratefursheep" class="form-control" placeholder="per kg Fur(10 to 1500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q8">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>8. Is market easily accessible in the vicinity to sell things received from <b>[**Livestock**]?</b> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value=" Within village" type="radio">
                                                                    Within village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 1 KM peripheral from village" type="radio">
                                                                    Within 1 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 5 KM peripheral from village" type="radio">
                                                                    Within 5 KM peripheral from village
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="More than 5 KM peripheral from village" type="radio">
                                                                    More than 5 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Don't know" type="radio">
                                                                    Don't know
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q9">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>9. Do you have past experience of livestock management? (Cattle Rearing)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="Yes" type="radio">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Poultry Birds -->
                                                <div id="hidepoultry">
                                                    <div class="row" id="Q2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. How many existing <b>[**Livestock**]</b> you have in the home?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="indigenousnreedpoultry">A. Indigenous Breed</label>
                                                                <input type="text" name="indigenousnreedpoultry" id="indigenousnreedpoultry" class="form-control" placeholder="Range(0 to 10000)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="crossbreedpoultry">B. Cross breed</label>
                                                                <input type="text" name="crossbreedpoultry" id="crossbreedpoultry" class="form-control" placeholder="Range(0 to 10000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="incomepoultry">3. How much income you have received from <b>[**Livestock**]</b> in last 1 year?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="incomepoultry" id="incomepoultry" class="form-control" placeholder="Rupees(1000 to 300000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q4">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="expenditurepoultry">4. In last one month, how much expenditure you spend on the <b>[**Livestock**]</b> activity (cost includes all inputs and transportation, labor cost may excluded with assumption that family members is the main labor for the activity)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="expenditurepoultry" id="expenditurepoultry" class="form-control" placeholder="Rupees(0 to 25000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q5">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>5. What benefits you got from the <b>[**Livestock**]</b> in last 1 year? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <label><b>Sell in the market</b></label>
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="benefitsgot[]" id="benefitsgot">
                                                                        <option value="Home purpose use">Home purpose use</option>
                                                                        <option value="livestock-Baby">livestock-Baby</option>
                                                                        <option value="livestock-Fully grown">livestock-Fully grown</option>
                                                                        <option value="livestock-Meat">livestock-Meat</option>
                                                                        <option value="livestock-Egg">livestock-Egg</option>
                                                                        <option value="livestock-Milk">livestock-Milk</option>
                                                                        <option value="livestock-Fur">livestock-Fur</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="Q6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>6. How much quantity of [**Benefit**] you get from [**Livestock**] in a day/ month?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="meatpoultry">Meat (kgs per month)</label>
                                                                    <input type="text" name="meatpoultry" id="meatpoultry" class="form-control" placeholder="Meat(1 to 800)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="eggspoultry">Eggs (No. per day)</label>
                                                                    <input type="text" name="eggspoultry" id="eggspoultry" class="form-control" placeholder="Eggs(1 to 500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Q7">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>7. What is the rate of <b>[**Livestock**]</b> for <b>[**Benefit**]</b>? </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratebabypoultry">Sell  of 1 baby of [**Livestock**]</label>
                                                                    <input type="text" name="ratebabypoultry" id="ratebabypoultry" class="form-control" placeholder="Rupees per Baby(25 to 2500)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratefullgrownpoultry">Sell  of 1 Full grown of[**Livestock**]</label>
                                                                    <input type="text" name="ratefullgrownpoultry" id="ratefullgrownpoultry" class="form-control" placeholder="Rupees per Full Grown livestock(25 to 2500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratemeatpoultry">Per KG meat of [**Livestock**]</label>
                                                                    <input type="text" name="ratemeatpoultry" id="ratemeatpoultry" class="form-control" placeholder="per kg Meat(10 to 1000)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="rateeggpoultry">1 dozen Eggs of [**Livestock**]</label>
                                                                    <input type="text" name="rateeggpoultry" id="rateeggpoultry" class="form-control" placeholder="1 dozen Eggs(10 to 500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q8">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>8. Is market easily accessible in the vicinity to sell things received from <b>[**Livestock**]?</b> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value=" Within village" type="radio">
                                                                    Within village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 1 KM peripheral from village" type="radio">
                                                                    Within 1 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 5 KM peripheral from village" type="radio">
                                                                    Within 5 KM peripheral from village
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="More than 5 KM peripheral from village" type="radio">
                                                                    More than 5 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Don't know" type="radio">
                                                                    Don't know
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q9">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>9. Do you have past experience of livestock management? (Cattle Rearing)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="Yes" type="radio">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Animal -->
                                                <div id="hideanimal">
                                                    <div class="row" id="Q2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. How many existing <b>[**Livestock**]</b> you have in the home?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="indigenousnreedanimal">A. Indigenous Breed</label>
                                                                <input type="text" name="indigenousnreedanimal" id="indigenousnreedanimal" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="crossbreedanimal">B. Cross breed</label>
                                                                <input type="text" name="crossbreedanimal" id="crossbreedanimal" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="incomeanimal">3. How much income you have received from <b>[**Livestock**]</b> in last 1 year?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="incomeanimal" id="incomeanimal" class="form-control" placeholder="Rupees(1000 to 300000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q4">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="expenditureanimal">4. In last one month, how much expenditure you spend on the <b>[**Livestock**]</b> activity (cost includes all inputs and transportation, labor cost may excluded with assumption that family members is the main labor for the activity)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="expenditureanimal" id="expenditureanimal" class="form-control" placeholder="Rupees(0 to 25000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q5">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>5. What benefits you got from the <b>[**Livestock**]</b> in last 1 year? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <label><b>Sell in the market</b></label>
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="benefitsgot[]" id="benefitsgot">
                                                                        <option value="Home purpose use">Home purpose use</option>
                                                                        <option value="livestock-Baby">livestock-Baby</option>
                                                                        <option value="livestock-Fully grown">livestock-Fully grown</option>
                                                                        <option value="livestock-Meat">livestock-Meat</option>
                                                                        <option value="livestock-Egg">livestock-Egg</option>
                                                                        <option value="livestock-Milk">livestock-Milk</option>
                                                                        <option value="livestock-Fur">livestock-Fur</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="Q6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>6. How much quantity of [**Benefit**] you get from [**Livestock**] in a day/ month?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="meatanimal">Meat (kgs per month)</label>
                                                                    <input type="text" name="meatanimal" id="meatanimal" class="form-control" placeholder="Meat(1 to 800)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="milkanimal">Milk (Liters per day)</label>
                                                                    <input type="text" name="milkanimal" id="milkanimal" class="form-control" placeholder="Milk">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Q7">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>7. What is the rate of <b>[**Livestock**]</b> for <b>[**Benefit**]</b>? </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratebabyanimal">Sell  of 1 baby of [**Livestock**]</label>
                                                                    <input type="text" name="ratebabyanimal" id="ratebabyanimal" class="form-control" placeholder="Rupees per Baby(25 to 2500)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratefullgrownanimal">Sell  of 1 Full grown of[**Livestock**]</label>
                                                                    <input type="text" name="ratefullgrownanimal" id="ratefullgrownanimal" class="form-control" placeholder="Rupees per Full Grown livestock(25 to 2500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratemeatanimal">Per KG meat of [**Livestock**]</label>
                                                                    <input type="text" name="ratemeatanimal" id="ratemeatanimal" class="form-control" placeholder="per kg Meat(10 to 2500)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratemilkanimal">Per liter milk of  [**Livestock**]</label>
                                                                    <input type="text" name="ratemilkanimal" id="ratemilkanimal" class="form-control" placeholder="per litter Milk(10 to 150)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q8">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>8. Is market easily accessible in the vicinity to sell things received from <b>[**Livestock**]?</b> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value=" Within village" type="radio">
                                                                    Within village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 1 KM peripheral from village" type="radio">
                                                                    Within 1 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 5 KM peripheral from village" type="radio">
                                                                    Within 5 KM peripheral from village
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="More than 5 KM peripheral from village" type="radio">
                                                                    More than 5 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Don't know" type="radio">
                                                                    Don't know
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q9">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>9. Do you have past experience of livestock management? (Cattle Rearing)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="Yes" type="radio">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bird -->
                                                <div id="hidebird">
                                                    <div class="row" id="Q2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>2. How many existing <b>[**Livestock**]</b> you have in the home?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="indigenousnreedbird">A. Indigenous Breed</label>
                                                                <input type="text" name="indigenousnreedbird" id="indigenousnreedbird" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="crossbreedbird">B. Cross breed</label>
                                                                <input type="text" name="crossbreedbird" id="crossbreedbird" class="form-control" placeholder="Range(0 to 25)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="incomebird">3. How much income you have received from <b>[**Livestock**]</b> in last 1 year?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="incomebird" id="incomebird" class="form-control" placeholder="Rupees(1000 to 300000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q4">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="expenditurebird">4. In last one month, how much expenditure you spend on the <b>[**Livestock**]</b> activity (cost includes all inputs and transportation, labor cost may excluded with assumption that family members is the main labor for the activity)?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="expenditurebird" id="expenditurebird" class="form-control" placeholder="Rupees(0 to 25000)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q5">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>5. What benefits you got from the <b>[**Livestock**]</b> in last 1 year? </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="multi-select-full">
                                                                    <label><b>Sell in the market</b></label>
                                                                    <select style="display: none;" class="multiselect-filtering" multiple="multiple" name="benefitsgot[]" id="benefitsgot">
                                                                        <option value="Home purpose use">Home purpose use</option>
                                                                        <option value="livestock-Baby">livestock-Baby</option>
                                                                        <option value="livestock-Fully grown">livestock-Fully grown</option>
                                                                        <option value="livestock-Meat">livestock-Meat</option>
                                                                        <option value="livestock-Egg">livestock-Egg</option>
                                                                        <option value="livestock-Milk">livestock-Milk</option>
                                                                        <option value="livestock-Fur">livestock-Fur</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="Q6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>6. How much quantity of [**Benefit**] you get from [**Livestock**] in a day/ month?</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="meatbird">Meat (kgs per month)</label>
                                                                    <input type="text" name="meatbird" id="meatbird" class="form-control" placeholder="Meat(1 to 800)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="eggsbird">Eggs (No. per day)</label>
                                                                    <input type="text" name="eggsbird" id="eggsbird" class="form-control" placeholder="Eggs(1 to 500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="Q7">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>7. What is the rate of <b>[**Livestock**]</b> for <b>[**Benefit**]</b>? </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratebabybird">Sell  of 1 baby of [**Livestock**]</label>
                                                                    <input type="text" name="ratebabybird" id="ratebabybird" class="form-control" placeholder="Rupees per Baby(25 to 2500)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratefullgrownbird">Sell  of 1 Full grown of[**Livestock**]</label>
                                                                    <input type="text" name="ratefullgrownbird" id="ratefullgrownbird" class="form-control" placeholder="Rupees per Full Grown livestock(25 to 2500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="ratemeatbird">Per KG meat of [**Livestock**]</label>
                                                                    <input type="text" name="ratemeatbird" id="ratemeatbird" class="form-control" placeholder="per kg Meat(25 to 2500)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="rateeggbird">1 dozen Eggs of [**Livestock**]</label>
                                                                    <input type="text" name="rateeggbird" id="rateeggbird" class="form-control" placeholder="1 dozen Eggs(10 to 500)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q8">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>8. Is market easily accessible in the vicinity to sell things received from <b>[**Livestock**]?</b> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value=" Within village" type="radio">
                                                                    Within village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 1 KM peripheral from village" type="radio">
                                                                    Within 1 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Within 5 KM peripheral from village" type="radio">
                                                                    Within 5 KM peripheral from village
                                                                </label>
                                                                <br/>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="More than 5 KM peripheral from village" type="radio">
                                                                    More than 5 KM peripheral from village
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="marketaccess" value="Don't know" type="radio">
                                                                    Don't know
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="Q9">
                                                        <div class="col-md-6">
                                                            <div class="content-group-lg">
                                                                <label>9. Do you have past experience of livestock management? (Cattle Rearing)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="No" type="radio">
                                                                    No
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input name="cattlereating" value="Yes" type="radio">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="text-left">
                                                    <button type="submit" class="btn btn-primary" name="btn-save" value="save">Add More <i class="icon-plus-circle2 position-right"></i></button>
                                                </div>
                                                <br/>
                                                <div class="text-right">
                                                    <button type="submit" name="btn-submit" class="btn btn-primary stepy-finish">Submit & Next <i class="icon-arrow-right14 position-right"></i></button>
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
