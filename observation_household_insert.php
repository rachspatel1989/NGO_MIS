<?php

include_once 'include/DB_Functions.php';
$db = new DB_Functions();

$login_id = $_SESSION['login_id'];

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
    $tempid = "";
    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    echo $date = date('m/d/Y h:i:s a', time());
    echo $timestamp = strtotime($date);

    $sql_fet = "SELECT MAX(family_id) as family_id FROM family_master";
    if (!( $selectResp = mysql_query($sql_fet) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        if (mysql_num_rows($selectResp) == 0) {
            echo 'No Rows Returned';
        } else {
            
        }
        while ($rows = mysql_fetch_assoc($selectResp)) {
            $family_id = $rows['family_id'];
            $floor_string = implode(', ', $_POST['floor']);
            $walls_string = implode(', ', $_POST['walls']);
            $roof_string = implode(', ', $_POST['roof']);
            $sql = "INSERT INTO family_housematerials_master (login_id,family_id,mat_for_floor,mat_for_walls,mat_for_roof,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES ('$login_id','$family_id','$floor_string','$walls_string','$roof_string','Web','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')";
            mysql_query($sql) OR die(mysql_error());
        }
    }

// receiving the post params
    $ht_no_of_rooms = $_POST['roomno'];
    $ht_kitchen_location = $_POST['kitchenlocated'];
    $ht_cooking_stove_type = $_POST['stovetype'];
    $ht_have_toilet = $_POST['havetoilet'];
    $ht_have_piped_water_connection = $_POST['havepipedwater'];
    $ht_have_electricity_meter = $_POST['haveelectricity'];
    $ht_space_around_house = $_POST['haveland'];

    $materialsql = "SELECT mat_id FROM family_housematerials_master where family_housematerials_master.family_id = $family_id";
    while ($matrow = mysql_fetch_assoc($materialsql)) {
        $mat_id = $matrow['mat_id'];

        $user = $db->insertHouseType($login_id, $mat_id, $ht_no_of_rooms, $ht_kitchen_location, $ht_cooking_stove_type, $ht_have_toilet, $ht_have_piped_water_connection, $ht_have_electricity_meter, $ht_space_around_house, $ip, $date, $timestamp, $tempid);
        if ($user) {
            ?>
            <script type="text/javascript">
                alert('Data Are Inserted Successfully ');
                window.location.href = 'list_of_families.php';
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
