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
        <script type="text/javascript" src="assets/js/plugins/ui/nicescroll.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/drilldown.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="assets/js/plugins/uploaders/fileinput.min.js"></script>

        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.file-input-custom').fileinput({
                    //previewFileType: 'image',
                    browseLabel: 'Select',
                    browseClass: 'btn bg-slate-700',
                    browseIcon: '<i class="icon-plus22 position-left"></i> ',
                    removeLabel: 'Remove',
                    removeClass: 'btn btn-danger',
                    removeIcon: '<i class="icon-cancel-square position-left"></i> ',
                    uploadClass: 'btn bg-teal-400',
                    uploadIcon: '<i class="icon-file-upload position-left"></i> ',
                    layoutTemplates: {
                        caption: '<div tabindex="-1" class="form-control file-caption {class}">\n' + '<span class="icon-file-plus kv-caption-icon"></span><div class="file-caption-name"></div>\n' + '</div>'
                    },
                    initialCaption: "No file selected"
                });
            });</script>
        <!-- /theme JS files -->
        <script type="text/javascript">
            function ShowHideDiv() {
                var ddlpt = document.getElementById("datatable");
                var dvpt = document.getElementById("progresstracker");
                var dvptd = document.getElementById("progresstrackerdetails");
                dvpt.style.display = ddlpt.value === "progresstracker" ? "block" : "none";
                dvptd.style.display = ddlpt.value === "progresstrackerdetails" ? "block" : "none";
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
                    </div>
                    <!-- /page header -->

                    <div class="content">
                        <!-- Toolbar -->
                        <div class="navbar navbar-default navbar-component navbar-xs">
                            <ul class="nav navbar-nav visible-xs-block">
                                <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
                            </ul>

                            <div class="navbar-collapse collapse" id="navbar-filter">
                                <ul class="nav navbar-nav element-active-slate-400">
                                    <li><a href="#activity" data-toggle="tab"><i class="icon-menu7 position-left"></i> <b>Data Upload..</b></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Media library -->
                        <div class="content">
                            <div class="panel-bordered">
                                <?php
                                include_once 'include/DB_Functions.php';
                                $db = new DB_Functions();

                                //Connect to Database
                                //$deleterecords = "TRUNCATE TABLE exp_data"; //empty the table of its current records
                                //mysql_query($deleterecords);
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

                                $reg_via = "Web";
                                $ip = ipCheck();

                                date_default_timezone_set('Asia/Kolkata');
                                $date_cr = date('m/d/Y');
                                $dt = date("Y/m/d", strtotime($date_cr));
                                $St_Time = "01:00:00";
                                $date = date('m/d/Y h:i:s a', time());
                                $timestamp = strtotime($date);

                                if (isset($_POST['progresstracker'])) {

                                    if (is_uploaded_file($_FILES['pfilename']['tmp_name'])) {
                                        //Import uploaded file to Database
                                        //exclude the first row
                                        $csv_file = $_FILES['pfilename']['tmp_name'];
                                        if (($handle = fopen($csv_file, "r")) !== FALSE) {
                                            fgetcsv($handle);
                                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                                $num = count($data);
                                                for ($c = 0; $c < $num; $c++) {
                                                    $col[$c] = $data[$c];
                                                }

                                                $col1 = $col[0];
                                                $col2 = $col[1];
                                                $col3 = $col[2];
                                                $col4 = $col[3];
                                                $col5 = $col[4];
                                                $col6 = $col[5];
                                                $col7 = $col[6];

                                                // SQL Query to insert data into DataBase
                                                $query = "INSERT INTO activity_progress_master(login_id,family_id,allocate_id,benificiary_id,indicator_id,action_recorded,visit_date,remarks,reg_via,reg_device_id,reg_created_date,reg_timestamp) VALUES('$login_id','" . $col1 . "','" . $col2 . "','" . $col3 . "','" . $col4 . "','" . $col5 . "','" . $col6 . "','" . $col7 . "','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')";
                                                $s = mysql_query($query);
                                            }
                                            fclose($handle);
                                        }
                                        ?>
                                        <script type="text/javascript">
                                            window.location.href = 'csv_upload.php';
                                        </script>
                                        <?php
                                        mysql_close($connect);
                                    } else {
                                        ?>
                                        <script type="text/javascript">
                                            alert("No File Selected");
                                            window.location.href = 'csv_upload.php';
                                        </script>
                                        <?php
                                    }
                                } else if (isset($_POST['prtrackerdetails'])) {
                                    if (is_uploaded_file($_FILES['pdfilename']['tmp_name'])) {
                                        //Import uploaded file to Database
                                        //exclude the first row
                                        $csv_file = $_FILES['pdfilename']['tmp_name'];
                                        if (($handle = fopen($csv_file, "r")) !== FALSE) {
                                            fgetcsv($handle);
                                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                                $num = count($data);
                                                for ($c = 0; $c < $num; $c++) {
                                                    $col[$c] = $data[$c];
                                                }

                                                $col1 = $col[0];
                                                $col2 = $col[1];
                                                $col3 = $col[2];
                                                $col4 = $col[3];
                                                $col5 = $col[4];
                                                $col6 = $col[5];
                                                $col7 = $col[6];
                                                $col8 = $col[7];
                                                $col9 = $col[8];
                                                $col10 = $col[9];
                                                $col11 = $col[10];
                                                $col12 = $col[11];
                                                $col13 = $col[12];
                                                $col14 = $col[13];
                                                $col15 = $col[14];
                                                $col16 = $col[15];
                                                $col17 = $col[16];
                                                $col18 = $col[17];
                                                $col19 = $col[18];
                                                $col20 = $col[19];
                                                $col21 = $col[20];
                                                $col22 = $col[21];
                                                $col23 = $col[22];
                                                $col24 = $col[23];
                                                $col25 = $col[24];
                                                $col26 = $col[25];
                                                $col27 = $col[26];
                                                $col28 = $col[27];
                                                $col29 = $col[28];
                                                $col30 = $col[29];
                                                $col31 = $col[30];
                                                $col32 = $col[31];
                                                $col33 = $col[32];
                                                $col34 = $col[33];
                                                $col35 = $col[34];

                                                // SQL Query to insert data into DataBase
                                                $query = "INSERT INTO activity_progress_details_master(login_id,beneficiary_id,activity_name,other_activity,fertilizer_name,fertilizer_qty,fertilizer_total_cost,seed_qty,seed_variety_name,seed_total_cost,dbmgf_grant,lhwrf_grant,mf_grant,beneficiary_contribution,farmers_contribution,nabard,other_grants,mf_availed,land_levelled_area,total_no,species_name,variety,survival_no,insurance_amt,contribution_amt,enterprise_verification,equipment_name,equipment_no,IGA_name,SHG_name,training_name,training_duration,agency_venue,financial_institute,loan_amt,rate_of_interest,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id','" . $col1 . "','" . $col2 . "','" . $col3 . "','" . $col4 . "','" . $col5 . "','" . $col6 . "','" . $col7 . "','" . $col8 . "','" . $col9 . "','" . $col10 . "','" . $col11 . "','" . $col12 . "','" . $col13 . "','" . $col14 . "','" . $col15 . "','" . $col16 . "','" . $col17 . "','" . $col18 . "','" . $col19 . "','" . $col20 . "','" . $col21 . "','" . $col22 . "','" . $col23 . "','" . $col24 . "','" . $col25 . "','" . $col26 . "','" . $col27 . "','" . $col28 . "','" . $col29 . "','" . $col30 . "','" . $col31 . "','" . $col32 . "','" . $col33 . "','" . $col34 . "','" . $col35 . "','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')";
                                                $s = mysql_query($query);
                                            }
                                            fclose($handle);
                                        }
                                        ?>
                                        <script type="text/javascript">
                                            window.location.href = 'csv_upload.php';
                                        </script>
                                        <?php
                                        mysql_close($connect);
                                    } else {
                                        ?>
                                        <script type="text/javascript">
                                            alert("No File Selected");
                                            window.location.href = 'csv_upload.php';
                                        </script>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <form enctype="multipart/form-data" action="csv_upload.php" method="post">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Data Table:</label>
                                                    <select name="datatable" id="datatable" class="form-control" onchange = "ShowHideDiv()">
                                                        <option value="">Select Activity</option>
                                                        <option value="progresstracker">Progress Tracker</option>
                                                        <option value="progresstrackerdetails">Progress Tracker Details</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>                                        
                                        <div id="progresstracker" style="display: none">
                                            <div class="form-group">
                                                <div class="col-lg-12 text-right">
                                                    <button class="btn bg-success-400"><i class="icon-file-download position-left"></i><a href="csv_download.php?link=progress_tracker.csv" style="color:white">Download Template here</a></button>
                                                </div>   
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label text-semibold">File to import:</label>
                                                <div class="col-lg-12">
                                                    <input type="file" name="pfilename" class="file-input-custom" data-show-preview="false" data-show-upload="false">
                                                    <span class="help-block">Upload csv.</span><br/>
                                                    <button type="submit" name="progresstracker" class="btn bg-teal-400 kv-fileinput-upload"><i class="icon-file-upload position-left"></i> Upload</button>
                                                </div>   
                                            </div>  
                                        </div>
                                        <div id="progresstrackerdetails" style="display: none">
                                            <div class="form-group">
                                                <div class="col-lg-12 text-right">
                                                    <button class="btn bg-success-400"><i class="icon-file-download position-left"></i><a href="csv_download.php?link=progress_tracker_details.csv" style="color:white">Download Template here</a></button>
                                                </div>   
                                            </div><br/><br/>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label text-semibold">File to import:</label>
                                                <div class="col-lg-12">
                                                    <input type="file" name="pdfilename" class="file-input-custom" data-show-preview="false" data-show-upload="false">
                                                    <span class="help-block">Upload csv.</span><br/>
                                                    <button type="submit" name="prtrackerdetails" class="btn bg-teal-400 kv-fileinput-upload"><i class="icon-file-upload position-left"></i> Upload</button>
                                                </div>   
                                            </div>  
                                        </div>
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

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


