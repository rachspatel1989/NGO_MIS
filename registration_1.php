<?php
session_start();
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
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

if (isset($_POST['btn-register']) and ! empty($_FILES)) { // Has the image been uploaded?
    include './include/getextension.php';

    $reg_first_name = $_POST['reg_first_name'];
    $reg_last_name = $_POST['reg_last_name'];
    $reg_designation = $_POST['reg_designation'];
    $reg_user_email = $_POST['reg_user_email'];
    $reg_contact_no = $_POST['reg_contact_no'];
    $reg_address = $_POST['reg_address'];

    $ip = ipCheck();
    $file = $_FILES['image_file'];

    $file_name = $file['name'];

    $error = ''; // Empty
// Get File Extension (if any)

    $ext = strtolower(substr(strrchr($file_name, "."), 1));

// Check for a correct extension. The image file hasn't an extension? Add one

    if ($validation_type == 1) {
        $file_info = getimagesize($_FILES['image_file']['tmp_name']);

        if (empty($file_info)) { // No Image?
            $error .= "The uploaded file doesn't seem to be an image.";
        } else { // An Image?
            $file_mime = $file_info['mime'];

            if ($ext == 'jpc' || $ext == 'jpx' || $ext == 'jb2') {
                $extension = $ext;
            } else {
                $extension = ($mime[$file_mime] == 'jpeg') ? 'jpg' : $mime[$file_mime];
            }

            if (!$extension) {
                $extension = '';
                $file_name = str_replace('.', '', $file_name);
            }
        }
    } else if ($validation_type == 2) {
        if (!in_array($ext, $image_extensions_allowed)) {
            $exts = implode(', ', $image_extensions_allowed);
            $error .= "You must upload a file with one of the following extensions: " . $exts;
        }

        $extension = $ext;
    }

    if ($error == "") { // No errors were found?
        $new_file_name = strtolower($file_name);
        $new_file_name = str_replace(' ', '-', $new_file_name);
        $new_file_name = substr($new_file_name, 0, -strlen($ext));
        $new_file_name .= $extension;

        $random_digit = rand(0000, 9999);
        $new_file_name = $random_digit . $file_name;
// File Name
        $move_file = move_uploaded_file($file['tmp_name'], $upload_image_to_folder . $new_file_name);
        $img = $upload_image_to_folder . $new_file_name;
        if ($move_file) {
            $next_id = getid();
            $sql_query = "INSERT INTO register_master(reg_unique_no,reg_first_name,reg_last_name,reg_user_email,reg_designation,reg_contact_no,reg_address,reg_profile_img_path,reg_via,reg_device_id) VALUES('$next_id','$reg_first_name','$reg_last_name','$reg_user_email','$reg_designation','$reg_contact_no','$reg_address','$img','web','$ip')";
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
                    $sql = "INSERT INTO login_master(login_uid,login_uname,login_password,login_type,status,reg_via,reg_device_id) VALUES('$regis_id','$reg_user_email','$pwd','$reg_designation','Active','web','$ip')";

                    if (mysql_query($sql)) {
                        ?>
                        <script type="text/javascript">
                            window.location.href = 'list_of_officers.php';
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
    } else {
        @unlink($file['tmp_name']);
    }

    $file_uploaded = true;
}

if (isset($_POST['btn-update'])) { // Has the image been uploaded?
    $regid = $_GET['r_id'];
    $fname = $_POST['reg_first_name'];
    $lname = $_POST['reg_last_name'];
    $email = $_POST['reg_user_email'];
    $designation = $_POST['reg_designation'];
    $contact = $_POST['reg_contact_no'];
    $address = $_POST['reg_address'];

    $ip = ipCheck();
    $sql_query = "update register_master set reg_first_name='$fname',reg_last_name='$lname',reg_designation='$designation',reg_contact_no='$contact',reg_address='$address',reg_device_id= '$ip' where reg_id='$regid'";
    mysql_query($sql_query);
    $sql_query1 = "update login_master set login_type='$designation',reg_device_id= '$ip' where login_uid='$regid'";

    if (mysql_query($sql_query1)) {
        ?>
        <script type="text/javascript">
            window.location.href = 'list_of_officers.php';
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
                        <!-- Registration form -->
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
                                                    <div class="form-group has-feedback">
                                                        <select name="reg_designation" class="form-control" id="reg_designation">
                                                            <option value="<?php echo $designation; ?>"><?php
                                                                if ($designation == projectmanager):
                                                                    echo "Project Manager";
                                                                elseif ($designation == projectcoordinator):
                                                                    echo "Sr Project Co-ordinator";
                                                                elseif ($designation == blockcoordinator):
                                                                    echo "Block Co-ordinator";
                                                                elseif ($designation == clustercoordinator):
                                                                    echo "Cluster Co-ordinator";
                                                                elseif ($designation == fieldcoordinator):
                                                                    echo "Field Co-ordinator";
                                                                else:
                                                                    echo "None";
                                                                endif;
                                                                ?></option>
                                                            <option value="null">Choose Designation</option>
                                                            <option value="projectmanager">Project Manager</option>
                                                            <option value="projectcoordinator">Sr Project Co-ordinator</option>
                                                            <option value="blockcoordinator">Block Co-ordinator</option>
                                                            <option value="clustercoordinator">Cluster Co-ordinator</option>
                                                            <option value="fieldcoordinator">Field Co-ordinator</option>
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <i class="text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <textarea name="reg_address" name="reg_address" id="reg_address" rows="1" cols="4" placeholder="Address" class="form-control"><?php echo $address; ?></textarea>
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
                        <!-- /registration form -->
                        <?php
                    } else {
                        ?>
                        <!-- Registration form -->
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel">
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
                                                    <div class="form-group has-feedback">
                                                        <select name="reg_designation" class="form-control" id="reg_designation">
                                                            <option value="null">Choose Designation</option>
                                                            <option value="projectmanager">Project Manager</option>
                                                            <option value="projectcoordinator">Sr Project Co-ordinator</option>
                                                            <option value="blockcoordinator">Block Co-ordinator</option>
                                                            <option value="clustercoordinator">Cluster Co-ordinator</option>
                                                            <option value="fieldcoordinator">Field Co-ordinator</option>
                                                        </select>
                                                        <div class="form-control-feedback">
                                                            <i class="text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <textarea name="reg_address" name="reg_address" id="reg_address" rows="1" cols="4" placeholder="Address" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Photograph:</label>
                                                        <!-- MAX_FILE_SIZE must be set before the input element -->
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="2048000" />

                                                        <!-- The name from the $_FILES array is determined by the input name -->  
                                                        <input type="file" class="file-styled" name="image_file" id="image_file" />
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
    </body>
</html>


