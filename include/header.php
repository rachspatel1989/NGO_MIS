<?php

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
}
?> 


<div class="navbar navbar-default header-highlight">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><img src="assets/images/logo.png" alt=""></a>

                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>

                <p class="navbar-text">
                    <span class="label bg-success">Online</span>
                </p>

                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="assets/images/placeholder.jpg" alt="">
                                <span><?php echo $reg_name; ?></span>
                                <i class="caret"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="registration_update.php"><i class="icon-user-plus">&nbsp;My Profile</i></a></li>  
                                <li class="divider"></li>
                                <li><a href="change_password.php"><i class="icon-reset">&nbsp;Change Password</i></a></li>
                                <li class="divider"></li>
                                <li><a href="include/logout.php"><i class="icon-switch2"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>