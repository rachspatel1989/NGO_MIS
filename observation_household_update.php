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
    $floor_string = implode(', ', $_POST['floor']);
    $walls_string = implode(', ', $_POST['walls']);
    $roof_string = implode(', ', $_POST['roof']);
    $ht_no_of_rooms = $_POST['roomno'];
    $ht_kitchen_location = $_POST['kitchenlocated'];
    $ht_cooking_stove_type = $_POST['stovetype'];
    $ht_have_toilet = $_POST['havetoilet'];
    $ht_have_piped_water_connection = $_POST['havepipedwater'];
    $ht_have_electricity_meter = $_POST['haveelectricity'];
    $ht_space_around_house = $_POST['haveland'];
    $tempid = "";

    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);


    $user = $db->HouseTypeUpdate($login_id, $mat_id, $floor_string, $walls_string, $roof_string, $ht_no_of_rooms, $ht_kitchen_location, $ht_cooking_stove_type, $ht_have_toilet, $ht_have_piped_water_connection, $ht_have_electricity_meter, $ht_space_around_house, $ip, $date, $timestamp, $tempid);
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



