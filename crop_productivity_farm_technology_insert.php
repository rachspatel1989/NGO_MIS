<?php
$login_id = $_SESSION['login_id'];
include_once 'include/DB_Functions.php';
$db = new DB_Functions();

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

if (isset($_POST['btn-save'])) {

    $ip = ipCheck();
    // variables for input data
    $crop_id = $_POST['crop_id'];
    $consumed_crop = $_POST['consumed_crop'];
    $landarea = $_POST['landarea'];
    $landunit = $_POST['landunit'];
    $totalproductionamount = $_POST['totalproductionamount'];
    $totalproductionunit = $_POST['totalproductionunit'];
    $soldamount = $_POST['soldamount'];
    $soldunit = $_POST['soldunit'];
    $expenditure = $_POST['expenditure'];
    $marketrate = $_POST['marketrate'];
    $marketrateunit = $_POST['marketrateunit'];
    $productionamount = $_POST['productionamount'];
    $productionunit = $_POST['productionunit'];
    $ispaddy = $_POST['ispaddy'];
    $newtech = $_POST['newtech'];
    $technology = implode(', ', $_POST['technology']);
    $techsupport = $_POST['techsupport'];
    $techsupportsecond = $_POST['techsupportsecond'];
    $techsupportthird = $_POST['techsupportthird'];
    $wellirrigation = $_POST['wellirrigation'];
    $irrigation = implode(', ', $_POST['irrigation']);
    $gwsource = $_POST['gwsource'];
    $landavailable = $_POST['landavailable'];
    $nolandreasone = implode(', ', $_POST['nolandreasone']);
    $tempid = "";

    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);

    $sql_fetch = "SELECT MAX(family_id) as family_id FROM family_master";
    if (!( $selectRes = mysql_query($sql_fetch) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        if (mysql_num_rows($selectRes) == 0) {
            echo 'No Rows Returned';
        } else {
            
        }
        while ($row = mysql_fetch_assoc($selectRes)) {
            $family_id = $row['family_id'];
            if ($crop_id == "None") {

                $user = $db->insertCropMasterNo($login_id, $family_id, $crop_id, $consumed_crop, $ip, $date, $timestamp, $tempid);

                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'self_employment.php';
                    </script>
                    <?php
                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php
                }
            } else {
                $user = $db->insertCropMaster($login_id, $family_id, $crop_id, $consumed_crop, $landarea, $landunit, $totalproductionamount, $totalproductionunit, $soldamount, $soldunit, $expenditure, $marketrate, $marketrateunit, $productionamount, $productionunit, $ispaddy, $newtech, $technology, $techsupport, $techsupportsecond, $techsupportthird, $wellirrigation, $irrigation, $gwsource, $landavailable, $nolandreasone, $ip, $date, $timestamp, $tempid);

                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                    <?php
                    $sql_fet_sql = mysql_query("SELECT family_id FROM family_master ORDER BY family_id DESC");
                    $row_data = mysql_fetch_array($sql_fet_sql);
                    $fam_id = $row_data['family_id'];
                    $sql_fet_sql1 = mysql_query("SELECT * FROM family_crop_master ,family_farmtech_master WHERE family_crop_master.family_id = family_farmtech_master.family_id AND family_crop_master.family_id = '$fam_id'");
                    $sql_fm_rows = mysql_num_rows($sql_fet_sql1);
                    //$row_data1 = mysql_fetch_array($sql_fet_sql1);
                    if ($sql_fm_rows == 5) {
                        ?>
                            window.location.href = 'self_employment.php';
                        <?php
                    } else {
                        
                    }
                    ?>
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
}
?>








