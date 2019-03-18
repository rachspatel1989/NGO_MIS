<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
$db_handle = new DB_Functions();

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

error_reporting(0);

$query = "SELECT * FROM district_master";
$results = $db_handle->runQuery($query);

function ipCheck() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
//Is it a proxy address
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getid() {
    $result = mysql_query("SELECT * FROM register_master");
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
        $get = mysql_query("SELECT MAX(reg_unique_no) FROM register_master");
        $got = mysql_fetch_array($get);
        $next_id = $got['MAX(reg_unique_no)'] + 1;
        return $next_id;
    } else {
        $next_id = 1001;
        return $next_id;
    }
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

if (isset($_POST['btn-register'])) { // Has the image been uploaded?
    $reg_first_name = $_POST['reg_first_name'];
    $reg_last_name = $_POST['reg_last_name'];
    $reg_designation = $_POST['reg_designation'];
    $reg_user_email = $_POST['reg_user_email'];
    $reg_contact_no = $_POST['reg_contact_no'];
    $reg_address = $_POST['reg_address'];
    $reg_district = $_POST['district'];
    $reg_block = $_POST['block'];
    $reg_cluster = $_POST['cluster'];
    $tempid = "";
    $ip = ipCheck();

    $next_id = getid();
    $sql_query = "INSERT INTO register_master(reg_unique_no,reg_first_name,reg_last_name,reg_user_email,reg_designation,reg_district,reg_block,reg_cluster,reg_contact_no,reg_address,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$next_id','$reg_first_name','$reg_last_name','$reg_user_email','$reg_designation','$reg_district','$reg_block','$reg_cluster','$reg_contact_no','$reg_address','web','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')";
    mysql_query($sql_query);
    $sql_fetch = "SELECT reg_id FROM register_master where reg_user_email = '$reg_user_email'";
    if (!( $selectRes = mysql_query($sql_fetch) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        if (mysql_num_rows($selectRes) == 0) {
            echo 'No Rows Returned';
        } else {
            
        }
        while ($row = mysql_fetch_assoc($selectRes)) {
            $pwd = randomPassword();
            $regis_id = $row['reg_id'];
            $sql = "INSERT INTO login_master(login_uid,login_uname,login_password,login_type,status,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$regis_id','$reg_user_email','$pwd','$reg_designation','Active','web','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')";

            if (mysql_query($sql)) {
                ?>
                <script type="text/javascript">
                    window.location.href = 'index.php';
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    alert('error occured while inserting your data');
                </script>
                <?php
            }
        }
    }
}

if (isset($_POST['btn-update'])) { // Has the image been uploaded?
    $fname = $_POST['reg_first_name'];
    $lname = $_POST['reg_last_name'];
    $email = $_POST['reg_user_email'];
    $designation = $_POST['reg_designation'];
    $contact = $_POST['reg_contact_no'];
    $address = $_POST['reg_address'];
    $district = $_POST['district'];
    $block = $_POST['block'];
    $cluster = $_POST['cluster'];

    $ip = ipCheck();
    $sql_query = "update register_master set reg_first_name='$fname',reg_last_name='$lname',reg_designation='$designation',reg_district = '$district',reg_block = '$block',reg_cluster = '$cluster',reg_contact_no='$contact',reg_address='$address',reg_device_id= '$ip',reg_modified_date= STR_TO_DATE('$date', '%m/%d/%Y%h:%i') where reg_id='$login_uid'";
    mysql_query($sql_query);
    $sql_query1 = "update login_master set login_type='$designation',reg_device_id= '$ip',reg_modified_date= STR_TO_DATE('$date', '%m/%d/%Y%h:%i') where login_uid='$login_uid'";

    if (mysql_query($sql_query1)) {
        ?>
        <script type="text/javascript">
            window.location.href = 'dashboard.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert('error occured while updating your data');
        </script>
        <?php
    }
}
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
        <script type="text/javascript" src="assets/js/plugins/ui/nicescroll.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/drilldown.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/login.js"></script>
        <!-- /theme JS files -->

        <!-- /theme JS files -->
        <script type='text/javascript'>
    function showhide()
    {
        var e = document.getElementById("reg_designation");
        var select = e.options[e.selectedIndex].value;
        var div = document.getElementById("survey");
        if (select === "surveyors")
        {
            div.style.display = "block";
        } else if (select === "null")
        {
            div.style.display = "none";
        } else
        {
            div.style.display = "none";
        }
    }
        </script>
    </head>

    <body>
        <input type="hidden" name="userType" id="userType" value=<?php echo $login_type; ?> >
        <!-- Main navbar -->
        <?php include 'include/header.php'; ?>
        <!-- /main navbar -->

        <!-- Page container -->
        <div class="page-container login-container" style="min-height:933px">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main sidebar -->
                <?php include 'include/sidemenu.php'; ?>
                <!-- /main sidebar -->

                <!-- Content area -->
                <div class="content">

                    <?php
                    $officer_sql = mysql_query("SELECT * FROM register_master");
                    $officer_row = mysql_fetch_array($officer_sql);
                    if ($_GET['r_id']) {
                        $regid = $officer_row['reg_id'];
                        $fname = $officer_row['reg_first_name'];
                        $lname = $officer_row['reg_last_name'];
                        $email = $officer_row['reg_user_email'];
                        $designation = $officer_row['reg_designation'];
                        $contact = $officer_row['reg_contact_no'];
                        $address = $officer_row['reg_address'];
                        ?>

                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="text-left">
                                                <h5 class="content-group-lg">Update account <small class="display-block">All fields are required</small></h5>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <input type="text" class="form-control" id="reg_first_name" value="<?php echo $fname; ?>" placeholder="First name" name="reg_first_name">
                                                        <div class="form-control-feedback">
                                                            <i class="icon-user-check text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <input type="text" class="form-control" value="<?php echo $lname; ?>" placeholder="Second name" id="reg_last_name" name="reg_last_name">
                                                        <div class="form-control-feedback">
                                                            <i class="icon-user-check text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                       

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <input type="email" class="form-control" value="<?php echo $email; ?>" name="reg_user_email" id="reg_user_email" placeholder="Your email">
                                                        <div class="form-control-feedback">
                                                            <i class="icon-mention text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <input type="text" name="reg_contact_no" id="reg_contact_no" value="<?php echo $contact; ?>" class="form-control" placeholder="Your number">
                                                        <div class="form-control-feedback">
                                                            <i class="icon-phone2 text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <textarea name="reg_address" name="reg_address" id="reg_address" rows="1" cols="4" placeholder="Address" class="form-control"><?php echo $address; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <select name="reg_designation" class="form-control" id="reg_designation" onchange="showhide()">
                                                            <option value="<?php echo $designation; ?>"><?php
                                                                if ($designation == 'projectmanager'):
                                                                    echo "Project Manager";
                                                                elseif ($designation == 'administrator'):
                                                                    echo "Administrator";
                                                                elseif ($designation == 'blockcoordinator'):
                                                                    echo "Block Coordinator";
                                                                elseif ($designation == 'guest'):
                                                                    echo "Guest";
                                                                elseif ($designation == 'surveyors'):
                                                                    echo "Surveyors";
                                                                else:
                                                                    echo "None";
                                                                endif;
                                                                ?></option>
                                                            <option value="null">Choose Designation</option>
                                                            <option value="administrator">Administrator</option>
                                                            <option value="projectmanager">Project Manager</option>
                                                            <option value="blockcoordinator">Block Coordinator</option>
                                                            <option value="guest">Guest</option>
                                                            <option value="surveyors">Surveyors</option>
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <i class="text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            </div>
                                            <div class="row" id="survey" name="survey" style="display: none">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="district" id="district-list" class="form-control" onChange="getBlock(this.value);">  
                                                            <option value="<?php echo $district ?>"><?php echo $district ?></option>
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="block" id="block-list" class="form-control" onChange="getCluster(this.value);">
                                                            <option value="<?php echo $block ?>"><?php echo $block ?></option>
                                                            <option value="">Select Block</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="cluster" id="cluster-list" class="form-control" onChange="getGP(this.value);">
                                                            <option value="<?php echo $cluster ?>"><?php echo $cluster ?></option>
                                                            <option value="select">--Select--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">											
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="styled">
                                                        Accept <a href="#">terms of service</a>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <a href="list_of_officers.php" class="btn btn-link"><i class="icon-arrow-left13 position-left"></i> Back to List..</a>
                                                <button type="submit" name="btn-update" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-10"><b><i class="icon-plus3"></i></b> Update account</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <!-- Registration form -->
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel registration-form">
                                        <div class="panel-body">
                                            <div class="text-left">
                                                <h5 class="content-group-lg">Create account <small class="display-block">All fields are required</small></h5>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <input type="text" class="form-control" id="reg_first_name" placeholder="First name" name="reg_first_name">
                                                        <div class="form-control-feedback">
                                                            <i class="icon-user-check text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <input type="text" class="form-control" placeholder="Second name" id="reg_last_name" name="reg_last_name">
                                                        <div class="form-control-feedback">
                                                            <i class="icon-user-check text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <input type="email" class="form-control" name="reg_user_email" id="reg_user_email" placeholder="Your email">
                                                        <div class="form-control-feedback">
                                                            <i class="icon-mention text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <input type="text" name="reg_contact_no" id="reg_contact_no" class="form-control" placeholder="Your number">
                                                        <div class="form-control-feedback">
                                                            <i class="icon-phone2 text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <textarea name="reg_address" name="reg_address" id="reg_address" rows="1" cols="4" placeholder="Address" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <select name="reg_designation" class="form-control" id="reg_designation" onchange="showhide()">
                                                            <option value="null">Choose Designation</option>
                                                            <option value="administrator">Administrator</option>
                                                            <option value="projectmanager">Project Manager</option>
                                                            <option value="blockcoordinator">Block Coordinator</option>
                                                            <option value="guest">Guest</option>
                                                            <option value="surveyors">Surveyors</option>
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <i class="text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="survey" name="survey" style="display: none">
                                                <div class="col-md-4">
                                                    <div class="form-group">
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="block" id="block-list" class="form-control" onChange="getCluster(this.value);">
                                                            <option value="">Select Block</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="cluster" id="cluster-list" class="form-control" onChange="getGP(this.value);">
                                                            <option value="select">--Select--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">											
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="styled">
                                                        Accept <a href="#">terms of service</a>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <a href="list_of_officers.php" class="btn btn-link"><i class="icon-arrow-left13 position-left"></i> Back to List..</a>
                                                <button type="submit" name="btn-register" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-10"><b><i class="icon-plus3"></i></b> Create account</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /registration form -->
                        <?php
                    }
                    ?>
                    <!-- Footer -->
                    <?php include 'include/footer.php'; ?>
                    <!-- /footer -->
                </div>
                <!-- /content area -->              
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->        

        <!--<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>-->
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

                                                        function selectDistrict(val) {
                                                            $("#search-box").val(val);
                                                            $("#suggesstion-box").hide();
                                                        }
        </script>
    </body>
</html>
