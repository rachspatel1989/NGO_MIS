<?php
include_once 'include/DB_Functions.php';
$users = new DB_Functions();
$base_url = 'http://mis.yogintechnologies.com/portal/';
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST["forgot-password"])) {

    if (!empty($_POST["user-email"])) {

        $email = $_POST["user-email"];
        $sql = "Select * from login_master where login_uname = '" . $email . "'";
        $result = mysql_query($sql);
        $user = mysql_fetch_assoc($result);

        if (!empty($user)) {
            $to = $_POST["user-email"];
            require 'mailer/Send_Mail.php';
            $subject = "Password Recovery";
            $body = "<div>" . $user["login_uname"] . ",<br><br><p>Click this link to recover your password<br><a href='" . $base_url . "reset_password.php?uname=" . $user["login_uid"] . "'>" . $base_url . "reset_password.php?uname=" . $user["login_uid"] . "</a><br><br></p>Regards,<br> Admin.</div>";
            Send_Mail($to, $subject, $body);
            $message = "Password Recovery Link has been sent to your Mail";
        } else {
            $message = 'No User Found';
        }
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

    </head>

    <body>
        <!-- Page container -->
        <div class="page-container login-container">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Password recovery -->
                    <form method="post" action="">
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
                                <h5 class="content-group">Password recovery <small class="display-block">We'll send you instructions in email</small></h5>
                                <h5 class="content-group"><div class="message"><?php
                                        if (isset($message)) {
                                            echo $message;
                                        }
                                        ?></div></h5>
                            </div>

                            <div class="form-group has-feedback">
                                <input type="email" name="user-email" id="user-email" class="form-control" placeholder="Your email">
                                <div class="form-control-feedback">
                                    <i class="icon-mail5 text-muted"></i>
                                </div>
                            </div>

                            <button type="submit" name="forgot-password" id="forgot-password" class="btn bg-blue btn-block">Reset password <i class="icon-arrow-right14 position-right"></i></button>
                            <div class="text-right">
                                <a href="index.php" class="btn btn-link"><i class="icon-arrow-left13 position-left"></i> Back to Login..</a>
                            </div>
                        </div>
                    </form>
                    <!-- /password recovery -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

            <!-- Footer -->
<?php include 'include/footer.php'; ?>
            <!-- /footer -->
        </div>
        <!-- /page container -->

    </body>
</html>
