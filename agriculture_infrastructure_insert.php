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
    $havefarmland = $_POST['havefarmland'];

    $owntype = $_POST['owntype'];
    $ownarea = $_POST['ownarea'];
    $ownareaunit = $_POST['ownareaunit'];
    $owncost = $_POST['owncost'];
    $ownirrigatedarea = $_POST['ownirrigatedarea'];
    $ownirrigatedunit = $_POST['ownirrigatedunit'];
    $ownundulatingarea = $_POST['ownundulatingarea'];
    $ownundulatingunit = $_POST['ownundulatingunit'];
    $ownwastearea = $_POST['ownwastearea'];
    $ownwasteunit = $_POST['ownwasteunit'];
    $ownleveledarea = $_POST['ownleveledarea'];
    $ownleveledunit = $_POST['ownleveledunit'];
    $ownunderirrigationarea = $_POST['ownunderirrigationarea'];
    $ownunderirrigationunit = $_POST['ownunderirrigationunit'];

    $leasetype = $_POST['leasetype'];
    $leasearea = $_POST['leasearea'];
    $leaseareaunit = $_POST['leaseareaunit'];
    $leasecost1 = $_POST['leasecost1'];
    $leaseirrigatedarea = $_POST['leaseirrigatedarea'];
    $leaseirrigatedunit = $_POST['leaseirrigatedunit'];
    $leaseundulatingarea = $_POST['leaseundulatingarea'];
    $leaseundulatingunit = $_POST['leaseundulatingunit'];
    $leasewastearea = $_POST['leasewastearea'];
    $leasewasteunit = $_POST['leasewasteunit'];
    $leaseleveledarea = $_POST['leaseleveledarea'];
    $leaseleveledunit = $_POST['leaseleveledunit'];
    $leaseunderirrigationarea = $_POST['leaseunderirrigationarea'];
    $leaseunderirrigationunit = $_POST['leaseunderirrigationunit'];

    $tempid = "";

    $source_type1 = $_POST['source_type1'];
    $source_usability_dug = $_POST['source_usability_dug'];
    $issource_own_lease_dug = $_POST['issource_own_lease_dug'];
    $havesource_type_dug = $_POST['havesource_type_dug'];
    $own_source_dug = $_POST['own_source_dug'];
    $iswater_own_kharif_dug = $_POST['iswater_own_kharif_dug'];
    $iswater_own_rabi_dug = $_POST['iswater_own_rabi_dug'];
    $iswater_own_summer_dug = $_POST['iswater_own_summer_dug'];
    $lease_source_dug = $_POST['lease_source_dug'];
    $iswater_lease_kharif_dug = $_POST['iswater_lease_kharif_dug'];
    $iswater_lease_rabi_dug = $_POST['iswater_lease_rabi_dug'];
    $iswater_lease_summer_dug = $_POST['iswater_lease_summer_dug'];
    $group_source_dug = $_POST['group_source_dug'];
    $iswater_group_kharif_dug = $_POST['iswater_group_kharif_dug'];
    $iswater_group_rabi_dug = $_POST['iswater_group_rabi_dug'];
    $iswater_group_summer_dug = $_POST['iswater_group_summer_dug'];

    $source_type2 = $_POST['source_type2'];
    $source_usability_bore = $_POST['source_usability_bore'];
    $issource_own_lease_bore = $_POST['issource_own_lease_bore'];
    $havesource_type_bore = $_POST['havesource_type_bore'];
    $own_source_bore = $_POST['own_source_bore'];
    $iswater_own_kharif_bore = $_POST['iswater_own_kharif_bore'];
    $iswater_own_rabi_bore = $_POST['iswater_own_rabi_bore'];
    $iswater_own_summer_bore = $_POST['iswater_own_summer_bore'];
    $lease_source_bore = $_POST['lease_source_bore'];
    $iswater_lease_kharif_bore = $_POST['iswater_lease_kharif_bore'];
    $iswater_lease_rabi_bore = $_POST['iswater_lease_rabi_bore'];
    $iswater_lease_summer_bore = $_POST['iswater_lease_summer_bore'];
    $group_source_bore = $_POST['group_source_bore'];
    $iswater_group_kharif_bore = $_POST['iswater_group_kharif_bore'];
    $iswater_group_rabi_bore = $_POST['iswater_group_rabi_bore'];
    $iswater_group_summer_bore = $_POST['iswater_group_summer_bore'];

    $source_type3 = $_POST['source_type3'];
    $source_usability_pipe = $_POST['source_usability_pipe'];
    $issource_own_lease_pipe = $_POST['issource_own_lease_pipe'];
    $havesource_type_pipe = $_POST['havesource_type_pipe'];
    $own_source_pipe = $_POST['own_source_pipe'];
    $iswater_own_kharif_pipe = $_POST['iswater_own_kharif_pipe'];
    $iswater_own_rabi_pipe = $_POST['iswater_own_rabi_pipe'];
    $iswater_own_summer_pipe = $_POST['iswater_own_summer_pipe'];
    $lease_source_pipe = $_POST['lease_source_pipe'];
    $iswater_lease_kharif_pipe = $_POST['iswater_lease_kharif_pipe'];
    $iswater_lease_rabi_pipe = $_POST['iswater_lease_rabi_pipe'];
    $iswater_lease_summer_pipe = $_POST['iswater_lease_summer_pipe'];
    $group_source_pipe = $_POST['group_source_pipe'];
    $iswater_group_kharif_pipe = $_POST['iswater_group_kharif_pipe'];
    $iswater_group_rabi_pipe = $_POST['iswater_group_rabi_pipe'];
    $iswater_group_summer_pipe = $_POST['iswater_group_summer_pipe'];


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
        if ($havefarmland == 'No') {
            $rowf = mysql_fetch_assoc($selectRes);
            $family_id = $rowf['family_id'];
            $user = $db->insertAgricultureOwnLandNo($login_id, $family_id, $havefarmland, $ip, $date, $timestamp, $tempid);
            if ($user) {
                $family_id
                ?>
                <script type="text/javascript">
                    alert('Data Are Inserted Successfully ');
                    window.location.href = 'crop_productivity_farm_technology.php';
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

            while ($row = mysql_fetch_assoc($selectRes)) {
                $family_id = $row['family_id'];
                if ($_POST['ownfarmland'] == "Own") {
                    $user = $db->insertAgricultureOwnLand($login_id, $family_id, $havefarmland, $owntype, $ownarea, $ownareaunit, $owncost, $ownirrigatedarea, $ownirrigatedunit, $ownundulatingarea, $ownundulatingunit, $ownwastearea, $ownwasteunit, $ownleveledarea, $ownleveledunit, $ownunderirrigationarea, $ownunderirrigationunit, $reg_via, $ip, $date, $timestamp, $tempid);
                } elseif ($_POST['leasefarmland'] == "Lease") {
                    $user1 = $db->insertAgricultureLeaseLand($login_id, $family_id, $havefarmland, $leasetype, $leasearea, $leaseareaunit, $leasecost1, $leaseirrigatedarea, $leaseirrigatedunit, $leaseundulatingarea, $leaseundulatingunit, $leasewastearea, $leasewasteunit, $leaseleveledarea, $leaseleveledunit, $leaseunderirrigationarea, $leaseunderirrigationunit, $reg_via, $ip, $date, $timestamp, $tempid);
                } elseif ($_POST['source_usabilitydug'] == "Yes") {
                    
                } elseif ($_POST['source_usability_bore'] == "Yes") {
                    
                } elseif ($_POST['source_usability_pipe'] == "Yes") {
                    
                } elseif ($_POST['source_usability_dug'] == "No") {
                    $user2 = $db->insertAgriculturedugNo($login_id, $family_id, $source_type1, $ip, $date, $timestamp, $tempid);
                } elseif ($_POST['source_usability_bore'] == "No") {
                    $user3 = $db->insertAgricultureboreNo($login_id, $family_id, $source_type2, $ip, $date, $timestamp, $tempid);
                } elseif ($_POST['source_usability_pipe'] == "No") {
                    $user4 = $db->insertAgriculturepipeNo($login_id, $family_id, $source_type3, $ip, $date, $timestamp, $tempid);
                }
                if ($user || $user1 || $user2 || $user3 || $user4) {
                    $family_id
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'crop_productivity_farm_technology.php';
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








