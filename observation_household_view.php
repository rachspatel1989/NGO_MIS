<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
include_once './observation_household_insert.php';

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
        <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/effects.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/notifications/jgrowl.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/form_multiselect.js"></script>

        <!-- /theme JS files -->
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
                                    <li class="active"><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>H. Observation Household</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /toolbar -->
                    </div>
                    <!-- /page header -->
                    <?php
                    $get_family_id = $_GET["getid"];

                    $select_fami_sql1 = mysql_query("SELECT * FROM family_housematerials_master where family_id='$get_family_id'");
                    $row_fam1 = mysql_fetch_array($select_fami_sql1);
                    $floor_string = implode(', ', $row_fam1['mat_for_floor']);
                    $walls_string = implode(', ', $row_fam1['mat_for_walls']);
                    $roof_string = implode(', ', $row_fam1['mat_for_roof']);

                    $select_fami_sql = mysql_query("SELECT * FROM family_housetype_master where family_id='$get_family_id'");
                    $row_fam = mysql_fetch_array($select_fami_sql);
                    $ht_no_of_rooms = $row_fam['ht_no_of_rooms'];
                    $ht_kitchen_location = $row_fam['ht_kitchen_location'];
                    $ht_cooking_stove_type = $row_fam['ht_cooking_stove_type'];
                    $ht_have_toilet = $row_fam['ht_have_toilet'];
                    $ht_have_piped_water_connection = $row_fam['ht_have_piped_water_connection'];
                    $ht_have_electricity_meter = $row_fam['ht_have_electricity_meter'];
                    $ht_space_around_house = $row_fam['ht_space_around_house'];
                    ?>
                    <!-- /page header -->
                    <!-- Content area -->
                    <div class="content">
                        <!-- Clickable title -->
                        <form action="#" method="post" id="frmform">
                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="text-semibold">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>1. What is the material used for roof, floor and walls of the house? (OBSERVE / ASK.)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>a. Floor</label>
                                                            <div class="multi-select-full">
                                                                <select class="multiselect" name="floor[]" multiple="multiple"> 
                                                                    <option value="<?php echo $floor_string; ?>"><?php echo $floor_string; ?></option>
                                                                    <option value="Brick">Brick</option>
                                                                    <option value="Concrete">Concrete</option>
                                                                    <option value="Unbaked Brick, Adobe">Un-baked Brick, Adobe</option>
                                                                    <option value="Wood, Logs">Wood, Logs</option>
                                                                    <option value="Mud">Mud</option>
                                                                    <option value="Tiles / slate">Tiles / slate</option>
                                                                    <option value="Stone">Stone</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>b. Walls</label>
                                                            <div class="multi-select-full">
                                                                <select class="multiselect" name="walls[]" multiple="multiple">
                                                                    <option value="<?php echo $walls_string; ?>"><?php echo $walls_string; ?></option>
                                                                    <option value="Brick">Brick</option>
                                                                    <option value="Concrete">Concrete</option>
                                                                    <option value="Unbaked Brick, Adobe">Un-baked Brick, Adobe</option>
                                                                    <option value="Wood, Logs">Wood, Logs</option>
                                                                    <option value="Tin, Zinc Sheeting">Tin, Zinc Sheeting</option>
                                                                    <option value="Mud">Mud</option>
                                                                    <option value="Canvas, Felt">Canvas, Felt</option>
                                                                    <option value="Dried Grass / Thatch">Dried Grass / Thatch</option>
                                                                    <option value="Stone">Stone</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>c. Roof</label>
                                                            <div class="multi-select-full">
                                                                <select class="multiselect" name="roof[]" multiple="multiple">
                                                                    <option value="<?php echo $roof_string; ?>"><?php echo $roof_string; ?></option>
                                                                    <option value="Brick">Brick</option>
                                                                    <option value="Concrete">Concrete</option>
                                                                    <option value="Unbaked Brick, Adobe">Un-baked Brick, Adobe</option>
                                                                    <option value="Wood, Logs">Wood, Logs</option>
                                                                    <option value="Tin, Zinc Sheeting">Tin, Zinc Sheeting</option>
                                                                    <option value="Canvas, Felt">Canvas, Felt</option>
                                                                    <option value="Dried Grass / Thatch">Dried Grass / Thatch</option>
                                                                    <option value="Tiles / slate">Tiles / slate</option>
                                                                    <option value="Stone">Stone</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>2. Number of rooms in the house. Room has at least one entry/door.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <!--<input type="hidden" name="matid" class="form-control" value='<?php echo $matid; ?>'>-->
                                                            <input type="text" name="roomno" class="form-control" value="<?php echo $ht_no_of_rooms; ?>" placeholder="Total number of rooms" onkeyup="this.value = fnc(this.value, 1, 25)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="display-block">3. Where is the kitchen located?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="radio-inline">
                                                                <input name="kitchenlocated" type="radio" <?php if (isset($ht_kitchen_location) && $ht_kitchen_location == "Inside the house with no partition") echo "checked"; ?> value="Inside the house with no partition">
                                                                Inside the house with no partition
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="kitchenlocated" type="radio" <?php if (isset($ht_kitchen_location) && $ht_kitchen_location == "Inside the house with partition") echo "checked"; ?> value="Inside the house with partition">
                                                                Inside the house with partition
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="kitchenlocated" type="radio" <?php if (isset($ht_kitchen_location) && $ht_kitchen_location == "Inside the house with separate room") echo "checked"; ?> value="Inside the house with separate room">
                                                                Inside the house with separate room
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="kitchenlocated" type="radio" <?php if (isset($ht_kitchen_location) && $ht_kitchen_location == "Attached room outside the house with separate entrance") echo "checked"; ?> value="Attached room outside the house with separate entrance">
                                                                Attached room outside the house with separate entrance
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="kitchenlocated" type="radio" <?php if (isset($ht_kitchen_location) && $ht_kitchen_location == "Outside the house in a standalone room") echo "checked"; ?> value="Outside the house in a standalone room">
                                                                Outside the house in a standalone room
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="kitchenlocated" type="radio" <?php if (isset($ht_kitchen_location) && $ht_kitchen_location == "Outside the house; open air") echo "checked"; ?> value="Outside the house; open air">
                                                                Outside the house; open air
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                Other 
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="text" name="backsupportcheckingname" value="<?php echo $ht_kitchen_location; ?>" class="form-control" placeholder="Specify">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="display-block">4. What type of stove is used for main cooking?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="radio-inline">
                                                                <input name="stovetype" type="radio" <?php if (isset($ht_cooking_stove_type) && $ht_cooking_stove_type == "Open fire / Rudimentary 3 stones") echo "checked"; ?> value="Open fire / Rudimentary 3 stones">
                                                                Open fire / Rudimentary 3 stones
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="stovetype" type="radio" <?php if (isset($ht_cooking_stove_type) && $ht_cooking_stove_type == "Chulha") echo "checked"; ?> value="Chulha">
                                                                Chulha
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="stovetype" type="radio" <?php if (isset($ht_cooking_stove_type) && $ht_cooking_stove_type == "Kerosene burner") echo "checked"; ?> value="Kerosene burner">
                                                                Kerosene burner 
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="stovetype" type="radio" <?php if (isset($ht_cooking_stove_type) && $ht_cooking_stove_type == "Gas burner") echo "checked"; ?> value="Gas burner">
                                                                Gas burner
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="display-block">5. Does house has a toilet?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="radio-inline">
                                                                <input name="havetoilet" type="radio" <?php if (isset($ht_have_toilet) && $ht_have_toilet == "Yes") echo "checked"; ?> value="Yes">
                                                                Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="havetoilet" type="radio" <?php if (isset($ht_have_toilet) && $ht_have_toilet == "No") echo "checked"; ?> value="No">
                                                                No
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="display-block">6. Does HH have piped water connection?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="radio-inline">
                                                                <input name="havepipedwater" type="radio" <?php if (isset($ht_have_piped_water_connection) && $ht_have_piped_water_connection == "No") echo "checked"; ?> value="No">
                                                                No
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="havepipedwater" type="radio" <?php if (isset($ht_have_piped_water_connection) && $ht_have_piped_water_connection == "Yes") echo "checked"; ?> value="Yes">
                                                                Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="display-block">7. Does HH have an electricity meter?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="radio-inline">
                                                                <input name="haveelectricity" type="radio" <?php if (isset($ht_have_electricity_meter) && $ht_have_electricity_meter == "No") echo "checked"; ?> value="No">
                                                                No
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="haveelectricity" type="radio" <?php if (isset($ht_have_electricity_meter) && $ht_have_electricity_meter == "Yes, but not in working condition") echo "checked"; ?> value="Yes, but not in working condition">
                                                                Yes, but not in working condition
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="haveelectricity" type="radio" <?php if (isset($ht_have_electricity_meter) && $ht_have_electricity_meter == "Yes, working") echo "checked"; ?> value="Yes, working">
                                                                Yes, working 
                                                            </label><br/>
                                                            <label class="radio-inline">
                                                                <input name="haveelectricity" type="radio" <?php if (isset($ht_have_electricity_meter) && $ht_have_electricity_meter == "HH has un-official electric connection") echo "checked"; ?> value="HH has un-official electric connection">
                                                                HH has un-official electric connection
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="display-block">8. Does your family have the land/space more than 200 Sq.Feet around the house?</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="content-group-lg">
                                                            <label class="radio-inline">
                                                                <input name="haveland" type="radio" <?php if (isset($ht_space_around_house) && $ht_space_around_house == "No") echo "checked"; ?> value="No">
                                                                No
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input name="haveland" type="radio" <?php if (isset($ht_space_around_house) && $ht_space_around_house == "Yes") echo "checked"; ?> value="Yes">
                                                                Yes
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-right stepy-finish">
                                                    <button type="submit" name="btn-save" class="btn btn-primary stepy-finish">Submit<i class="icon-arrow-right14 position-right"></i></button>
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
