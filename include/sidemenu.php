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
<script type="text/javascript">
    $(function () {
        var userType = document.getElementById("userType").value;
        $("#userType").hide();
        if (userType === "projectmanager")
        {
            $("#projectmanager").show();
            $("#administrator").hide();
            $("#blockcoordinator").hide();
            $("#guest").hide();
        }
        if (userType === "administrator")
        {
            $("#projectmanager").hide();
            $("#administrator").show();
            $("#blockcoordinator").hide();
            $("#guest").hide();
        }
        if (userType === "blockcoordinator")
        {
            $("#projectmanager").hide();
            $("#administrator").hide();
            $("#blockcoordinator").show();
            $("#guest").hide();
        }
        if (userType === "guest")
        {
            $("#projectmanager").hide();
            $("#administrator").hide();
            $("#blockcoordinator").hide();
            $("#guest").show();
        }
//        alert(userType);
    });

</script>
<input type="hidden" name="userType" id="userType" value=<?php echo $login_type; ?> >
<?php $page_id = basename($_SERVER['PHP_SELF']); ?>
<div class="sidebar sidebar-main">
    <div class="sidebar-content" id="projectmanager">
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li> 
                        <a class="<?php echo ($page_id == "dashboard.php" ? "active" : ""); ?>" href="dashboard.php">
                            <i class="icon-home"></i> 
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_officers.php" ? "active" : ""); ?>" href="list_of_officers.php">
                            <i class="icon-user-tie"></i> 
                            <span>Officers</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a class="<?php echo ($page_id == "b.php" ? "active" : ""); ?>" href="javascript:;" >
                            <i class="icon-envelope"></i>
                            <span>Baseline</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php echo ($page_id == "personal_data.php" ? "active" : ""); ?>"  href="personal_data.php">
                                    <i class="icon-list-unordered"></i><span>New Baseline</span></a></li>
                            <li><a class="<?php echo ($page_id == "families_list_update.php" ? "active" : ""); ?>"  href="families_list_update.php">
                                    <i class="icon-list-unordered"></i><span>View All Baseline</span></a></li>
                        </ul>
                    </li> 
<!--                    <li> 
                        <a class="<?php echo ($page_id == "list_of_activities.php" ? "active" : ""); ?>" href="list_of_activities.php">
                            <i class="icon-file-empty2"></i> 
                            <span>Activities</span>
                        </a>
                    </li>-->
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families.php" ? "active" : ""); ?>" href="list_of_families.php">
                            <i class="icon-file-check2"></i> 
                            <span>Activity Approval</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families_assign.php" ? "active" : ""); ?>" href="list_of_families_assign.php">
                            <i class="icon-file-plus2"></i> 
                            <span>Progress Tracker</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families_reeligibility.php" ? "active" : ""); ?>" href="list_of_families_reeligibility.php">
                            <i class="icon-reset"></i> 
                            <span>Activity Re-eligibility</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "village_level_physical_activity.php" ? "active" : ""); ?>" href="village_level_physical_activity.php">
                            <i class="icon-file-empty2"></i> 
                            <span>Village Level Intervention</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "csv_upload.php" ? "active" : ""); ?>" href="csv_upload.php">
                            <i class="icon-database"></i> 
                            <span>Data Upload</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a class="<?php echo ($page_id == "o.php" ? "active" : ""); ?>" href="javascript:;" >
                            <i class="icon-envelope"></i>
                            <span>Old Data</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php echo ($page_id == "village_level_activity_list.php" ? "active" : ""); ?>"  href="village_level_activity_list.php">
                                    <i class="icon-list-unordered"></i><span>Village Level Activity List</span></a></li>
                            <li><a class="<?php echo ($page_id == "families_list.php" ? "active" : ""); ?>"  href="families_list.php">
                                    <i class="icon-user-block"></i><span>List of Families</span></a></li>
                        </ul>
                    </li>                    
                </ul>
                <!-- /main -->
            </div>
        </div>
        <!-- /main navigation -->
    </div>
    
    <div class="sidebar-content" id="administrator">
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li> 
                        <a class="<?php echo ($page_id == "dashboard.php" ? "active" : ""); ?>" href="dashboard.php">
                            <i class="icon-home"></i> 
                            <span>Dashboard</span>
                        </a>
                    </li>
<!--                    <li> 
                        <a class="<?php echo ($page_id == "list_of_officers.php" ? "active" : ""); ?>" href="list_of_officers.php">
                            <i class="icon-user-tie"></i> 
                            <span>Officers</span>
                        </a>
                    </li>-->
                    <li class="sub-menu">
                        <a class="<?php echo ($page_id == "b.php" ? "active" : ""); ?>" href="javascript:;" >
                            <i class="icon-envelope"></i>
                            <span>Baseline</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php echo ($page_id == "personal_data.php" ? "active" : ""); ?>"  href="personal_data.php">
                                    <i class="icon-list-unordered"></i><span>New Baseline</span></a></li>
                            <li><a class="<?php echo ($page_id == "families_list_update.php" ? "active" : ""); ?>"  href="families_list_update.php">
                                    <i class="icon-list-unordered"></i><span>View All Baseline</span></a></li>
                        </ul>
                    </li> 
<!--                    <li> 
                        <a class="<?php echo ($page_id == "list_of_activities.php" ? "active" : ""); ?>" href="list_of_activities.php">
                            <i class="icon-file-empty2"></i> 
                            <span>Activities</span>
                        </a>
                    </li>-->
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families.php" ? "active" : ""); ?>" href="list_of_families.php">
                            <i class="icon-file-check2"></i> 
                            <span>Activity Approval</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families_assign.php" ? "active" : ""); ?>" href="list_of_families_assign.php">
                            <i class="icon-file-plus2"></i> 
                            <span>Progress Tracker</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families_reeligibility.php" ? "active" : ""); ?>" href="list_of_families_reeligibility.php">
                            <i class="icon-reset"></i> 
                            <span>Activity Re-eligibility</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "village_level_physical_activity.php" ? "active" : ""); ?>" href="village_level_physical_activity.php">
                            <i class="icon-file-empty2"></i> 
                            <span>Village Level Intervention</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "csv_upload.php" ? "active" : ""); ?>" href="csv_upload.php">
                            <i class="icon-database"></i> 
                            <span>Data Upload</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a class="<?php echo ($page_id == "o.php" ? "active" : ""); ?>" href="javascript:;" >
                            <i class="icon-envelope"></i>
                            <span>Old Data</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php echo ($page_id == "village_level_activity_list.php" ? "active" : ""); ?>"  href="village_level_activity_list.php">
                                    <i class="icon-list-unordered"></i><span>Village Level Activity List</span></a></li>
                            <li><a class="<?php echo ($page_id == "families_list.php" ? "active" : ""); ?>"  href="families_list.php">
                                    <i class="icon-user-block"></i><span>List of Families</span></a></li>
                        </ul>
                    </li>                    
                </ul>
                <!-- /main -->
            </div>
        </div>
        <!-- /main navigation -->
    </div>
    
    <div class="sidebar-content" id="blockcoordinator">
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li> 
                        <a class="<?php echo ($page_id == "dashboard.php" ? "active" : ""); ?>" href="dashboard.php">
                            <i class="icon-home"></i> 
                            <span>Dashboard</span>
                        </a>
                    </li>
<!--                    <li> 
                        <a class="<?php echo ($page_id == "list_of_officers.php" ? "active" : ""); ?>" href="list_of_officers.php">
                            <i class="icon-user-tie"></i> 
                            <span>Officers</span>
                        </a>
                    </li>-->
                    <li class="sub-menu">
                        <a class="<?php echo ($page_id == "b.php" ? "active" : ""); ?>" href="javascript:;" >
                            <i class="icon-envelope"></i>
                            <span>Baseline</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php echo ($page_id == "personal_data.php" ? "active" : ""); ?>"  href="personal_data.php">
                                    <i class="icon-list-unordered"></i><span>New Baseline</span></a></li>
                            <li><a class="<?php echo ($page_id == "families_list_update.php" ? "active" : ""); ?>"  href="families_list_update.php">
                                    <i class="icon-list-unordered"></i><span>View All Baseline</span></a></li>
                        </ul>
                    </li> 
<!--                    <li> 
                        <a class="<?php echo ($page_id == "list_of_activities.php" ? "active" : ""); ?>" href="list_of_activities.php">
                            <i class="icon-file-empty2"></i> 
                            <span>Activities</span>
                        </a>
                    </li>-->
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families.php" ? "active" : ""); ?>" href="list_of_families.php">
                            <i class="icon-file-check2"></i> 
                            <span>Activity Approval</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families_assign.php" ? "active" : ""); ?>" href="list_of_families_assign.php">
                            <i class="icon-file-plus2"></i> 
                            <span>Progress Tracker</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families_reeligibility.php" ? "active" : ""); ?>" href="list_of_families_reeligibility.php">
                            <i class="icon-reset"></i> 
                            <span>Activity Re-eligibility</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "village_level_physical_activity.php" ? "active" : ""); ?>" href="village_level_physical_activity.php">
                            <i class="icon-file-empty2"></i> 
                            <span>Village Level Intervention</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "csv_upload.php" ? "active" : ""); ?>" href="csv_upload.php">
                            <i class="icon-database"></i> 
                            <span>Data Upload</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a class="<?php echo ($page_id == "o.php" ? "active" : ""); ?>" href="javascript:;" >
                            <i class="icon-envelope"></i>
                            <span>Old Data</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php echo ($page_id == "village_level_activity_list.php" ? "active" : ""); ?>"  href="village_level_activity_list.php">
                                    <i class="icon-list-unordered"></i><span>Village Level Activity List</span></a></li>
                            <li><a class="<?php echo ($page_id == "families_list.php" ? "active" : ""); ?>"  href="families_list.php">
                                    <i class="icon-user-block"></i><span>List of Families</span></a></li>
                        </ul>
                    </li>                    
                </ul>
                <!-- /main -->
            </div>
        </div>
        <!-- /main navigation -->
    </div>
    
    <div class="sidebar-content" id="guest">
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li> 
                        <a class="<?php echo ($page_id == "dashboard.php" ? "active" : ""); ?>" href="dashboard.php">
                            <i class="icon-home"></i> 
                            <span>Dashboard</span>
                        </a>
                    </li>
<!--                    <li> 
                        <a class="<?php echo ($page_id == "list_of_officers.php" ? "active" : ""); ?>" href="list_of_officers.php">
                            <i class="icon-user-tie"></i> 
                            <span>Officers</span>
                        </a>
                    </li>-->
                    <li class="sub-menu">
                        <a class="<?php echo ($page_id == "b.php" ? "active" : ""); ?>" href="javascript:;" >
                            <i class="icon-envelope"></i>
                            <span>Baseline</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php echo ($page_id == "personal_data.php" ? "active" : ""); ?>"  href="personal_data.php">
                                    <i class="icon-list-unordered"></i><span>New Baseline</span></a></li>
                            <li><a class="<?php echo ($page_id == "families_list_update.php" ? "active" : ""); ?>"  href="families_list_update.php">
                                    <i class="icon-list-unordered"></i><span>View All Baseline</span></a></li>
                        </ul>
                    </li> 
<!--                    <li> 
                        <a class="<?php echo ($page_id == "list_of_activities.php" ? "active" : ""); ?>" href="list_of_activities.php">
                            <i class="icon-file-empty2"></i> 
                            <span>Activities</span>
                        </a>
                    </li>-->
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families.php" ? "active" : ""); ?>" href="list_of_families.php">
                            <i class="icon-file-check2"></i> 
                            <span>Activity Approval</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families_assign.php" ? "active" : ""); ?>" href="list_of_families_assign.php">
                            <i class="icon-file-plus2"></i> 
                            <span>Progress Tracker</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "list_of_families_reeligibility.php" ? "active" : ""); ?>" href="list_of_families_reeligibility.php">
                            <i class="icon-reset"></i> 
                            <span>Activity Re-eligibility</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "village_level_physical_activity.php" ? "active" : ""); ?>" href="village_level_physical_activity.php">
                            <i class="icon-file-empty2"></i> 
                            <span>Village Level Intervention</span>
                        </a>
                    </li>
                    <li> 
                        <a class="<?php echo ($page_id == "csv_upload.php" ? "active" : ""); ?>" href="csv_upload.php">
                            <i class="icon-database"></i> 
                            <span>Data Upload</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a class="<?php echo ($page_id == "o.php" ? "active" : ""); ?>" href="javascript:;" >
                            <i class="icon-envelope"></i>
                            <span>Old Data</span>
                        </a>
                        <ul class="sub">
                            <li><a class="<?php echo ($page_id == "village_level_activity_list.php" ? "active" : ""); ?>"  href="village_level_activity_list.php">
                                    <i class="icon-list-unordered"></i><span>Village Level Activity List</span></a></li>
                            <li><a class="<?php echo ($page_id == "families_list.php" ? "active" : ""); ?>"  href="families_list.php">
                                    <i class="icon-user-block"></i><span>List of Families</span></a></li>
                        </ul>
                    </li>                    
                </ul>
                <!-- /main -->
            </div>
        </div>
        <!-- /main navigation -->
    </div>
</div>
