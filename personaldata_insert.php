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

function getid() {
    $result = mysql_query("SELECT * FROM family_master");
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
        $get = mysql_query("SELECT MAX(family_unique_id) FROM family_master");
        $got = mysql_fetch_array($get);
        $next_id = $got['MAX(family_unique_id)'] + 1;
        return $next_id;
    } else {
        $next_id = 1001;
        return $next_id;
    }
}

if (isset($_POST['btn-save'])) {

    $ip = ipCheck();
    $next_id = getid();
// receiving the post params
    $family_habitation = $_POST['family_habitation'];
    $family_phone = $_POST['family_phone'];
    $family_head_name = $_POST['family_head_name'];
    $family_address = $_POST['family_address'];
    $district_id = $_POST['district'];
    $block_id = $_POST['block'];
    $cluster_id = $_POST['cluster'];
    $gp_id = $_POST['gp'];
    $village_id = $_POST['village'];
    $tempid = "";

    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);

    // check if patient already exists 
    if ($db->isFamilyExisted($family_phone, $family_head_name)) {
        // user already exists
        ?>
        <script type="text/javascript">
            alert('Already Exists.');
        </script>
        <?php

    } else {
        $user = $db->insertPersonalData($login_id, $next_id, $family_habitation, $family_phone, $family_head_name, $family_address, $district_id, $block_id, $cluster_id, $gp_id, $village_id, $ip, $date, $timestamp, $tempid);
        if ($user) {
            ?>
            <script type="text/javascript">
                alert('Data Are Inserted Successfully ');
                window.location.href = 'household_roster_new.php';
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
?>



