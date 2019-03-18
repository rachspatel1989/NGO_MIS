<?php

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
    $hhheadname = $_POST['hhheadname'];
    $participates = $_POST['participates'];
    $noofvisit = $_POST['noofvisit'];
    $interview_result = $_POST['interview_result'];
    $interview_date = $_POST['interview_date'];
    $time_begun = $_POST['time_begun'];
    $time_end = $_POST['time_end'];
    $time_duration = $_POST['time_duration'];
    $recievebenefit = $_POST['recievebenefit'];
    $schemereceive = implode(', ', $_POST['schemereceive']);
    $rate = $_POST['rate'];
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
            $user = $db->insertAdministrativeSurveyor($family_id, $hhheadname, $participates, $noofvisit, $interview_result, $ip, $date, $timestamp);
            if ($user) {
                
            } else {
                ?>
                <script type="text/javascript">
                    alert('error occured while inserting your data');
                </script>
                <?php

            }
        }
    }

    $sql_fetch = "SELECT MAX(survey_id) as survey_id FROM surveyor_master";
    if (!( $selectRes = mysql_query($sql_fetch) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        if (mysql_num_rows($selectRes) == 0) {
            echo 'No Rows Returned';
        } else {
            
        }
        while ($row = mysql_fetch_assoc($selectRes)) {
            $survey_id = $row['survey_id'];
            $user1 = $db->insertAdministrativeVisit($survey_id, $interview_date, $time_begun, $time_end, $time_duration, $ip);
            $user2 = $db->insertAdministrativeBenefits($recievebenefit, $schemereceive, $rate, $ip);

            if ($user2) {
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
}
?>




