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
// variables for input data
    $caste = isset($_POST['caste']);
    $povertyline = isset($_POST['povertyline']);
    $availability = $_POST['availability'];
    $housevalue = $_POST['housevalue'];
    $monthrent = $_POST['monthrent'];
    $buyfood = $_POST['buyfood'];
    $consumefood = $_POST['consumefood'];
    $quantityoffood = $_POST['quantityoffood'];
    $receivedwages = $_POST['receivedwages'];
    $costfood = $_POST['costfood'];
    $rainfall = $_POST['rainfall'];
    $migrated = $_POST['migrated'];
    $migrating = $_POST['migrating'];
    $totalmembers = $_POST['totalmembers'];
    $totaltime = $_POST['totaltime'];
    $totaldays = $_POST['totaldays'];
    $reducedtrips = $_POST['reducedtrips'];
    $reduceddays = $_POST['reduceddays'];
    $cost_per_year = $_POST['cost_per_year'];
    $expense_id = $_POST['expense_id'];
    $tempid = "";
    $incomedrop1 = $_POST['income1'];
    $incomedrop2 = $_POST['income2'];
    $incomedrop3 = $_POST['income3'];
    $incomedrop4 = $_POST['income4'];
    $incomedrop5 = $_POST['income5'];
    $incomedrop6 = $_POST['income6'];
    $incomedrop7 = $_POST['income7'];
    $incomedrop8 = $_POST['income8'];
    $incomedrop9 = $_POST['income9'];
    $incomedrop10 = $_POST['income10'];
    $incomedrop11 = $_POST['income11'];
    $incomedrop12 = $_POST['income12'];
    $incomedrop13 = $_POST['income13'];
    $incomedrop14 = $_POST['income14'];
    $income_textbox1 = $_POST['income_textbox1'];
    $income_textbox2 = $_POST['income_textbox2'];
    $income_textbox3 = $_POST['income_textbox3'];
    $income_textbox4 = $_POST['income_textbox4'];
    $income_textbox5 = $_POST['income_textbox5'];
    $income_textbox6 = $_POST['income_textbox6'];
    $income_textbox7 = $_POST['income_textbox7'];
    $income_textbox8 = $_POST['income_textbox8'];
    $income_textbox9 = $_POST['income_textbox9'];
    $income_textbox10 = $_POST['income_textbox10'];
    $income_textbox11 = $_POST['income_textbox11'];
    $income_textbox12 = $_POST['income_textbox12'];
    $income_textbox13 = $_POST['income_textbox13'];
    $income_textbox14 = $_POST['income_textbox14'];
    $asset_textbox1 = $_POST['asset_textbox1'];
    $asset_textbox2 = $_POST['asset_textbox2'];
    $asset_textbox3 = $_POST['asset_textbox3'];
    $asset_textbox4 = $_POST['asset_textbox4'];
    $asset_textbox5 = $_POST['asset_textbox5'];
    $asset_textbox6 = $_POST['asset_textbox6'];
    $asset_textbox7 = $_POST['asset_textbox7'];
    $asset_textbox8 = $_POST['asset_textbox8'];
    $asset_textbox9 = $_POST['asset_textbox9'];
    $asset_textbox10 = $_POST['asset_textbox10'];
    $asset_textbox11 = $_POST['asset_textbox11'];
    $asset_textbox12 = $_POST['asset_textbox12'];
    $asset_textbox13 = $_POST['asset_textbox13'];
    $asset_textbox14 = $_POST['asset_textbox14'];
    $sav_textbox1 = $_POST['sav_textbox1'];
    $sav_textbox2 = $_POST['sav_textbox2'];
    $sav_textbox3 = $_POST['sav_textbox3'];
    $sav_textbox4 = $_POST['sav_textbox4'];
    $sav_textbox5 = $_POST['sav_textbox5'];
    $sav_textbox6 = $_POST['sav_textbox6'];
    $sav_textbox7 = $_POST['sav_textbox7'];
    $sav_textbox8 = $_POST['sav_textbox8'];
    $sav_textbox9 = $_POST['sav_textbox9'];
    $savings1 = $_POST['savings1'];
    $savings2 = $_POST['savings2'];
    $savings3 = $_POST['savings3'];
    $savings4 = $_POST['savings4'];
    $savings5 = $_POST['savings5'];
    $savings6 = $_POST['savings6'];
    $savings7 = $_POST['savings7'];
    $savings8 = $_POST['savings8'];
    $savings9 = $_POST['savings9'];

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

            $user = $db->insertSocioHousehold($login_id, $family_id, $caste, $povertyline, $availability, $housevalue, $monthrent, $buyfood, $consumefood, $quantityoffood, $receivedwages, $costfood, $rainfall, $migrated, $migrating, $totalmembers, $totaltime, $totaldays, $reducedtrips, $reduceddays, $ip, $date, $timestamp, $tempid, $incomedrop1, $incomedrop2, $incomedrop3, $incomedrop4, $incomedrop5, $incomedrop6, $incomedrop7, $incomedrop8, $incomedrop9, $incomedrop10, $incomedrop11, $incomedrop12, $incomedrop13, $incomedrop14, $income_textbox1, $income_textbox2, $income_textbox3, $income_textbox4, $income_textbox5, $income_textbox6, $income_textbox7, $income_textbox8, $income_textbox9, $income_textbox10, $income_textbox11, $income_textbox12, $income_textbox13, $income_textbox14, $asset_textbox1, $asset_textbox2, $asset_textbox3, $asset_textbox4, $asset_textbox5, $asset_textbox6, $asset_textbox7, $asset_textbox8, $asset_textbox9, $asset_textbox10, $asset_textbox11, $asset_textbox12, $asset_textbox13, $asset_textbox14, $sav_textbox1, $sav_textbox2, $sav_textbox3, $sav_textbox4, $sav_textbox5, $sav_textbox6, $sav_textbox7, $sav_textbox8, $sav_textbox9, $savings1, $savings2, $savings3, $savings4, $savings5, $savings6, $savings7, $savings8, $savings9);
            if ($user) {
                ?>
                <script type="text/javascript">
                    alert('Data Are Inserted Successfully ');
                    window.location.href = 'livestock.php';
                </script>
                <?php

            } else {
                ?>
                <script type="text/javascript">
                    alert('error occured while inserting your data');
                </script>
                <?php

            }


            $sql_fetch = "SELECT expense_desc as expense_id FROM expense_master";
            if (!( $selectRes = mysql_query($sql_fetch) )) {
                echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
            } else {
                if (mysql_num_rows($selectRes) == 0) {
                    echo 'No Rows Returned';
                } else {
                    
                }
                while ($row = mysql_fetch_assoc($selectRes)) {
                    $num = $_POST['h'];
                    $expense_desc = $_POST['expense_desc'];
                    $expense_id = $_POST['expense_id'];
                    echo $expense_desc, $expense_id;
                    for ($i = 0; $i <= $num; $i++) {
                        //echo $expense_desc[$i];
                        $expense_desc = $_REQUEST["expense_desc$i"];
                        $expense_id = $_REQUEST["$expense_id$i"];
                        $carGroups = mysql_query("INSERT INTO family_nonfoodexp_master VALUES('$family_id','$expense_desc','$expense_id','$ip')");
                        //$user1 = $db->insertSocioNonFoodExp($family_id, $cars[$i], $ip);
                    }


                    if ($carGroups) {
                        ?>
                        <script type="text/javascript">
                            alert('Data Are Inserted Successfully ');
                            window.location.href = 'livestock.php';
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
}
?>










