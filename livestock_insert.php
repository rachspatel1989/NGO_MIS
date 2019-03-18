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

$ip = ipCheck();
// variables for input data
$hormfarm = $_POST['hormfarm'];
$livestocktype = $_POST['livestocktype'];
$tempid = "";
//Cow
$indigenousnreed = $_POST['indigenousnreed'];
$crossbreed = $_POST['crossbreed'];
$income = $_POST['income'];
$expenditure = $_POST['expenditure'];
$benefitsgot = implode(', ', $_POST['benefitsgot']);
$milk = $_POST['milk'];
$ratebaby = $_POST['ratebaby'];
$ratefullgrown = $_POST['ratefullgrown'];
$ratemilk = $_POST['ratemilk'];
$marketaccess = $_POST['marketaccess'];
$cattlereating = $_POST['cattlereating'];
//Buffaloes
$indigenousnreedbuff = $_POST['indigenousnreedbuff'];
$crossbreedbuff = $_POST['crossbreedbuff'];
$incomebuff = $_POST['incomebuff'];
$expenditurebuff = $_POST['expenditurebuff'];
$milkbuff = $_POST['milkbuff'];
$ratebabybuff = $_POST['ratebabybuff'];
$ratefullgrownbuff = $_POST['ratefullgrownbuff'];
$ratemilkbuff = $_POST['ratemilkbuff'];
//Goat
$indigenousnreedgoat = $_POST['indigenousnreedgoat'];
$crossbreedgoat = $_POST['crossbreedgoat'];
$incomegoat = $_POST['incomegoat'];
$expendituregoat = $_POST['expendituregoat'];
$meatgoat = $_POST['meatgoat'];
$milkgoat = $_POST['milkgoat'];
$ratebabygoat = $_POST['ratebabygoat'];
$ratefullgrowngoat = $_POST['ratefullgrowngoat'];
$ratemeatgoat = $_POST['ratemeatgoat'];
$ratemilkgoat = $_POST['ratemilkgoat'];
//Sheep
$indigenousnreedsheep = $_POST['indigenousnreedsheep'];
$crossbreedsheep = $_POST['crossbreedsheep'];
$incomesheep = $_POST['incomesheep'];
$expendituresheep = $_POST['expendituresheep'];
$meatsheep = $_POST['meatsheep'];
$milksheep = $_POST['milksheep'];
$fursheep = $_POST['fursheep'];
$ratebabysheep = $_POST['ratebabysheep'];
$ratefullgrownsheep = $_POST['ratefullgrownsheep'];
$ratemeatsheep = $_POST['ratemeatsheep'];
$ratemilksheep = $_POST['ratemilksheep'];
$ratefursheep = $_POST['ratefursheep'];
//Poultry Birds
$indigenousnreedpoultry = $_POST['indigenousnreedpoultry'];
$crossbreedpoultry = $_POST['crossbreedpoultry'];
$incomepoultry = $_POST['incomepoultry'];
$expenditurepoultry = $_POST['expenditurepoultry'];
$meatpoultry = $_POST['meatpoultry'];
$eggspoultry = $_POST['eggspoultry'];
$ratebabypoultry = $_POST['ratebabypoultry'];
$ratefullgrownpoultry = $_POST['ratefullgrownpoultry'];
$ratemeatpoultry = $_POST['ratemeatpoultry'];
$rateeggpoultry = $_POST['rateeggpoultry'];
//Animal
$indigenousnreedanimal = $_POST['indigenousnreedanimal'];
$crossbreedanimal = $_POST['crossbreedanimal'];
$incomeanimal = $_POST['incomeanimal'];
$expenditureanimal = $_POST['expenditureanimal'];
$meatanimal = $_POST['meatanimal'];
$milkanimal = $_POST['milkanimal'];
$ratebabyanimal = $_POST['ratebabyanimal'];
$ratefullgrownanimal = $_POST['ratefullgrownanimal'];
$ratemeatanimal = $_POST['ratemeatanimal'];
$ratemilkanimal = $_POST['ratemilkanimal'];
//Bird
$indigenousnreedbird = $_POST['indigenousnreedbird'];
$crossbreedbird = $_POST['crossbreedbird'];
$incomebird = $_POST['incomebird'];
$expenditurebird = $_POST['expenditurebird'];
$meatbird = $_POST['meatbird'];
$eggsbird = $_POST['eggsbird'];
$ratebabybird = $_POST['ratebabybird'];
$ratefullgrownbird = $_POST['ratefullgrownbird'];
$ratemeatbird = $_POST['ratemeatbird'];
$rateeggbird = $_POST['rateeggbird'];


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

        if (isset($_POST['btn-save'])) {
            if ($livestocktype == "Cow") {
                $user = $db->insertLiveStock($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreed, $crossbreed, $income, $expenditure, $benefitsgot, $milk, $ratebaby, $ratefullgrown, $ratemilk, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'livestock.php';
                        //window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($livestocktype == "Buffaloes") {
                $user1 = $db->insertLiveStockBuff($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedbuff, $crossbreedbuff, $incomebuff, $expenditurebuff, $benefitsgot, $milkbuff, $ratebabybuff, $ratefullgrownbuff, $ratemilkbuff, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user1) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'livestock.php';
                        //window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($livestocktype == "Goat") {
                $user2 = $db->insertLiveStockGoat($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedgoat, $crossbreedgoat, $incomegoat, $expendituregoat, $benefitsgot, $meatgoat, $milkgoat, $ratebabygoat, $ratefullgrowngoat, $ratemilkgoat, $ratemeatgoat, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user2) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'livestock.php';
                        //window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($livestocktype == "Sheep") {
                $user3 = $db->insertLiveStockSheep($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedsheep, $crossbreedsheep, $incomesheep, $expendituresheep, $benefitsgot, $meatsheep, $milksheep, $fursheep, $ratebabysheep, $ratefullgrownsheep, $ratemeatsheep, $ratemilksheep, $ratefursheep, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user3) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'livestock.php';
                        //window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($livestocktype == "Poultry Birds") {
                $user4 = $db->insertLiveStockPoultry($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedpoultry, $crossbreedpoultry, $incomepoultry, $expenditurepoultry, $benefitsgot, $meatpoultry, $eggspoultry, $ratebabypoultry, $ratefullgrownpoultry, $ratemeatpoultry, $rateeggpoultry, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user4) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'livestock.php';
                        //window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($livestocktype == "Other Domestic Animal") {
                $user5 = $db->insertLiveStockAnimal($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedanimal, $crossbreedanimal, $incomeanimal, $expenditureanimal, $benefitsgot, $meatanimal, $milkanimal, $ratebabyanimal, $ratefullgrownanimal, $ratemeatanimal, $ratemilkanimal, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user5) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'livestock.php';
                        //window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($livestocktype == "Other Domestic Bird") {
                $user6 = $db->insertLiveStockBird($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedbird, $crossbreedbird, $incomebird, $expenditurebird, $benefitsgot, $meatbird, $eggsbird, $ratebabybird, $ratefullgrownbird, $ratemeatbird, $rateeggbird, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user6) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'livestock.php';
                        //window.location.href = 'agriculture_infrastructure.php';
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
        } else if (isset($_POST['btn-submit'])) {

            if ($hormfarm == "Yes" && $livestocktype == "Cow") {
                $user = $db->insertLiveStock($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreed, $crossbreed, $income, $expenditure, $benefitsgot, $milk, $ratebaby, $ratefullgrown, $ratemilk, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($hormfarm == "Yes" && $livestocktype == "Buffaloes") {
                $user1 = $db->insertLiveStockBuff($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedbuff, $crossbreedbuff, $incomebuff, $expenditurebuff, $benefitsgot, $milkbuff, $ratebabybuff, $ratefullgrownbuff, $ratemilkbuff, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user1) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($hormfarm == "Yes" && $livestocktype == "Goat") {
                $user2 = $db->insertLiveStockGoat($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedgoat, $crossbreedgoat, $incomegoat, $expendituregoat, $benefitsgot, $meatgoat, $milkgoat, $ratebabygoat, $ratefullgrowngoat, $ratemilkgoat, $ratemeatgoat, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user2) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($hormfarm == "Yes" && $livestocktype == "Sheep") {
                $user3 = $db->insertLiveStockSheep($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedsheep, $crossbreedsheep, $incomesheep, $expendituresheep, $benefitsgot, $meatsheep, $milksheep, $fursheep, $ratebabysheep, $ratefullgrownsheep, $ratemeatsheep, $ratemilksheep, $ratefursheep, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user3) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($hormfarm == "Yes" && $livestocktype == "Poultry Birds") {
                $user4 = $db->insertLiveStockPoultry($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedpoultry, $crossbreedpoultry, $incomepoultry, $expenditurepoultry, $benefitsgot, $meatpoultry, $eggspoultry, $ratebabypoultry, $ratefullgrownpoultry, $ratemeatpoultry, $rateeggpoultry, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user4) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($hormfarm == "Yes" && $livestocktype == "Other Domestic Animal") {
                $user5 = $db->insertLiveStockAnimal($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedanimal, $crossbreedanimal, $incomeanimal, $expenditureanimal, $benefitsgot, $meatanimal, $milkanimal, $ratebabyanimal, $ratefullgrownanimal, $ratemeatanimal, $ratemilkanimal, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user5) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'agriculture_infrastructure.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else if ($hormfarm == "Yes" && $livestocktype == "Other Domestic Bird") {
                $user6 = $db->insertLiveStockBird($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedbird, $crossbreedbird, $incomebird, $expenditurebird, $benefitsgot, $meatbird, $eggsbird, $ratebabybird, $ratefullgrownbird, $ratemeatbird, $rateeggbird, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid);
                if ($user6) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'agriculture_infrastructure.php';
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
                $user = $db->insertLiveStockNo($login_id, $family_id, $hormfarm, $ip, $date, $timestamp, $tempid);
                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'agriculture_infrastructure.php';
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








