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
    $get_family_id = $_POST['get_id'];
// receiving the post params
    $familymember = implode(', ', $_POST['familymember']);
    $trainingrequired = $_POST['trainingrequired'];
    $grantreceive = implode(', ', $_POST['grantreceive']);
    $investmentgrant = $_POST['investmentgrant'];
    $investmentcredit = $_POST['investmentcredit'];
    $tempid = "";

    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);


    $user = $db->SelfEmploymentUpdate($login_id, $family_id, $familymember, $trainingrequired, $grantreceive, $investmentgrant, $investmentcredit, $ip, $date, $timestamp, $tempid);
    if ($user) {
        ?>
        <script type="text/javascript">
            alert('Data Updated Successfully ');
            window.location.href = 'families_list_update.php';
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



