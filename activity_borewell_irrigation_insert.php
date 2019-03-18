<?php

include_once 'include/DB_Functions.php';
$db = new DB_Functions();
$login_id = $_SESSION['login_id'];
$allocate_id = $_GET['allocate_id'];

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
// receiving the post params

    $sql_fetch = "SELECT activity_allocation_master.family_id,activity_verification_master.benificiary_id FROM activity_allocation_master INNER JOIN activity_verification_master ON activity_allocation_master.family_id = activity_verification_master.family_id WHERE activity_allocation_master.allocate_id = $allocate_id";
    $selectRes = mysql_query($sql_fetch);
    $row = mysql_fetch_assoc($selectRes);
    $family_id = $row['family_id'];
    $benificiary_id = $row['benificiary_id'];

    $ip = ipCheck();

    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);

    $sql = mysql_query("SELECT Count(activity_progress_master.pr_id) as cnt FROM activity_progress_master WHERE activity_progress_master.allocate_id = $allocate_id");
    $row = mysql_fetch_array($sql);
    $cnt = $row['cnt'];
    if ($cnt == 0) {
        $indicator = $_POST['L1'];
        $action = $_POST['A1'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark1'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 1) {
        $indicator = $_POST['L2'];
        $action = $_POST['A2'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark2'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 2) {
        $indicator = $_POST['L3'];
        $action = $_POST['A3'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark3'];
        $reg_via = "Web";
        $mf_availed = $_POST['microfinance_amount'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        $query1 = mysql_query("INSERT INTO activity_progress_details_master(login_id,beneficiary_id,mf_availed,reg_via,reg_device_id,reg_created_date,reg_timestamp) VALUES('$login_id','$benificiary_id','$mf_availed','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        if ($result and $query1) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 3) {
        $indicator = $_POST['L4'];
        $action = $_POST['A4'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark4'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 4) {
        $indicator = $_POST['L5'];
        $action = $_POST['A5'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark5'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 5) {
        $indicator = $_POST['L6'];
        $action = $_POST['A6'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark6'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 6) {
        $indicator = $_POST['L7'];
        $action = $_POST['A7'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark7'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 7) {
        $indicator = $_POST['L8'];
        $action = $_POST['A8'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark8'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 8) {
        $indicator = $_POST['L9'];
        $action = $_POST['A9'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark9'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 9) {
        $indicator = $_POST['L10'];
        $action = $_POST['A10'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark10'];
        $reg_via = "Web";
        $dbmgf = $_POST['amount_grant'];
        $lhwrf = $_POST['lhwrf_grant'];
        $mf = $_POST['mf'];
        $bfcont = $_POST['benifi_contribution'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        $query2 = mysql_query("Update activity_progress_details_master set dbmgf_grant= '$dbmgf', lhwrf_grant= '$lhwrf', mf_grant= '$mf', beneficiary_contribution= '$bfcont', reg_modified_date= STR_TO_DATE('$date','%m/%d/%Y%h:%i'), reg_timestamp= '$timestamp' WHERE beneficiary_id = '$benificiary_id'");
        if ($result and $query2) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    } else if ($cnt == 10) {
        $indicator = $_POST['L11'];
        $action = $_POST['A11'];
        $visit = date("d/m/Y");
        $remark = $_POST['remark11'];

        $result = $db->insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp);
        if ($result) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }
    }
}