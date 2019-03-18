<?php
include_once 'include/DB_Functions.php';
$db = new DB_Functions();
$login_id = $_SESSION['login_id'];

$allocate_id = $_GET['allocate_id'];
$family_id = $_GET['family_id'];

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
    $result = mysql_query("SELECT * FROM activity_verification_master");
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
        $get = mysql_query("SELECT MAX(bn_id) FROM activity_verification_master");
        $got = mysql_fetch_array($get);
        $next_id = $got['MAX(bn_id)'] + 1;
        return $next_id;
    } else {
        $next_id = "1";
        return $next_id;
    }
}

$tempid = "";
date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

if (isset($_POST['btn-save'])) {
// receiving the post params
    
    $reason = $_POST['reason'];
    $tempid = "";
    $ip = ipCheck();

    if ($reason == "") {
        $app_status = $_POST['approval'];
        $user = $db->UpdateActivity($allocate_id, $app_status);
        $sql_update = $db->UpdateActivityEligibilityStatus($family_id, $date, $timestamp);
        if ($user) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php
        }
    } else {
        $user1 = $db->insertActivityReason($login_id, $family_id, $reason, $ip, $date, $timestamp, $tempid);
        $sql_update = $db->UpdateActivityEligibilityStatus($family_id, $date, $timestamp);
        if ($user1) {
            
        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php
        }
    }

    $sql_fet = "SELECT village_master.village_name FROM activity_allocation_master INNER JOIN family_master ON activity_allocation_master.family_id = family_master.family_id INNER JOIN village_master ON family_master.village_id = village_master.village_id WHERE activity_allocation_master.allocate_id = $allocate_id";
    if (!( $selectRes = mysql_query($sql_fet) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        if (mysql_num_rows($selectRes) == 0) {
            echo 'No Rows Returned';
        } else {
            
        }
        while ($rows = mysql_fetch_assoc($selectRes)) {
            $_SESSION['village_name'] = $rows['village_name'];
            $village_name = $_SESSION['village_name'];
        }
    }

    $benificiary_id = $village_name . getid();

    $user2 = $db->insertFamilyVerification($login_id, $family_id, $allocate_id, $benificiary_id, $ip, $date, $timestamp, $tempid);
    if ($user2) {
        $response["response"] = 1;
        json_encode($response);
        
        $sql = "SELECT activity_allocation_master.activity_id FROM activity_allocation_master WHERE activity_allocation_master.allocate_id = $allocate_id";
        $select = mysql_query($sql);
        $row1 = mysql_fetch_assoc($select);
        $activity_id = $row1['activity_id'];
        if ($activity_id == "Rice cultivation with SRI") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_rice_cultivation.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Soyabean/Moong cultivation") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_soyabean_moong.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Gram/Toor Cultivation") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_gram_toor.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Vegetable Cultivation") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_vegetable_cultivation.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Land Levelling") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_land_levelling.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Orchard Development") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_orchard_development.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Cattle Induction") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_cattle_induction.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Poultry") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_poultry.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Goat Rearing") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_goat_rearing.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Skill Training") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_skill_training.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Grant support for self-employment") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_grant_support.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Credit support for self-employment") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_credit_support.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Group dug well irrigation scheme") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_dugwell_irrigation.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Group bore well irrigation scheme") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_borewell_irrigation.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Mini Lift irrigation scheme") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_minilift_irrigation.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "Pipe/Pump support") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_pipepump_support.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else if ($activity_id == "IGA through SHG programme") {
            ?>
            <script type="text/javascript">
                window.location.href = 'activity_incomegeneration.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                window.location.href = 'progress_tracker_insert.php?allocate_id=<?php echo $allocate_id ?>';
            </script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            alert('error occured while inserting your data');
        </script>
        <?php
    }
}       