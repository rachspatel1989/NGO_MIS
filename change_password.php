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

if (isset($_POST['btn-submit'])) {
    $result = mysql_query("SELECT * from login_master WHERE login_uid = '" . $login_uid . "'");
    $row = mysql_fetch_array($result);
    if ($_POST["currentPassword"] == $row["login_password"]) {
        mysql_query("UPDATE login_master set login_password = '" . $_POST["newPassword"] . "' WHERE login_uid = '" . $login_uid . "'");
        $message = "Password Changed";
    } else {
        $message = "Current Password is not correct";
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
        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <!-- /theme JS files -->

        <script>
            function validatePassword() {
                var currentPassword, newPassword, confirmPassword, output = true;

                currentPassword = document.frmChange.currentPassword;
                newPassword = document.frmChange.newPassword;
                confirmPassword = document.frmChange.confirmPassword;

                if (!currentPassword.value) {
                    currentPassword.focus();
                    document.getElementById("currentPassword").innerHTML = "required";
                    output = false;
                } else if (!newPassword.value) {
                    newPassword.focus();
                    document.getElementById("newPassword").innerHTML = "required";
                    output = false;
                } else if (!confirmPassword.value) {
                    confirmPassword.focus();
                    document.getElementById("confirmPassword").innerHTML = "required";
                    output = false;
                }
                if (newPassword.value != confirmPassword.value) {
                    newPassword.value = "";
                    confirmPassword.value = "";
                    newPassword.focus();
                    document.getElementById("confirmPassword").innerHTML = "not same";
                    output = false;
                }
                return output;
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

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Password recovery -->
                    <form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
                        <div class="login-form">
                            <div class="text-center">
                                <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
                                <h5 class="content-group">Want to change your Password?</h5>
                                <h5 class="content-group"><div class="message"><?php if(isset($message)) { echo $message; } ?></div></h5>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" name="currentPassword" id="currentPassword" class="form-control input-lg" placeholder="Current Password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>                            
                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" name="newPassword" id="newPassword" class="form-control input-lg" placeholder="New Password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control input-lg" placeholder="Confirm Password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>

                            <button type="submit" name="btn-submit" class="btn bg-blue btn-block">Reset password <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </form>
                    <!-- /password recovery -->

                </div>
                <!-- Footer -->
<?php include 'include/footer.php'; ?>
                <!-- /footer -->
                <!-- /page container -->
            </div>
        </div>

    </body>
</html>
