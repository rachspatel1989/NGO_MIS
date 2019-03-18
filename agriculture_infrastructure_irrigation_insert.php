<?php

if (!empty($_POST["btn-save"])) {

    $conn = mysql_connect("182.50.133.79", "yt_dbmg", "Ojaskikani27");
    mysql_select_db("yt_dbmg", $conn);
    $itemCount = count($_POST["source_name"]);
    $itemValues = 0;

    $query = "INSERT INTO family_irrigation_source (source_name,source_usability,issource_own_lease,havesource_type,own_source,iswater_own_kharif,iswater_own_rabi,iswater_own_summer,lease_source,iswater_lease_kharif,iswater_lease_rabi,iswater_lease_summer,group_source,iswater_group_kharif,iswater_group_rabi,iswater_group_summer) VALUES ";
    $queryValue = "";
    for ($i = 0; $i < $itemCount; $i++) {
        if (!empty($_POST["source_name"][$i]) || !empty($_POST["source_usability"][$i]) || !empty($_POST["issource_own_lease"][$i]) || !empty($_POST["havesource_type"][$i]) || !empty($_POST["own_source"][$i]) || !empty($_POST["iswater_own_kharif"][$i]) || !empty($_POST["iswater_own_rabi"][$i]) || !empty($_POST["iswater_own_summer"][$i]) || !empty($_POST["lease_source"][$i]) || !empty($_POST["iswater_lease_kharif"][$i]) || !empty($_POST["iswater_lease_rabi"][$i]) || !empty($_POST["iswater_lease_summer"][$i]) || !empty($_POST["group_source"][$i]) || !empty($_POST["iswater_group_kharif"][$i]) || !empty($_POST["iswater_group_rabi"][$i]) || !empty($_POST["iswater_group_summer"][$i])) {
            $itemValues++;
            if ($queryValue != "") {
                $queryValue .= ",";
            }
            $queryValue .= "('" . $_POST["source_name"][$i] . "', '" . $_POST["source_usability"][$i] . "', '" . $_POST["issource_own_lease"][$i] . "', '" . $_POST["havesource_type"][$i] . "', '" . $_POST["own_source"][$i] . "', '" . $_POST["iswater_own_kharif"][$i] . "', '" . $_POST["iswater_own_rabi"][$i] . "', '" . $_POST["iswater_own_summer"][$i] . "', '" . $_POST["lease_source"][$i] . "', '" . $_POST["iswater_lease_kharif"][$i] . "', '" . $_POST["iswater_lease_rabi"][$i] . "', '" . $_POST["iswater_lease_summer"][$i] . "', '" . $_POST["group_source"][$i] . "', '" . $_POST["iswater_group_kharif"][$i] . "', '" . $_POST["iswater_group_rabi"][$i] . "', '" . $_POST["iswater_group_summer"][$i] . "')";
        }
    }
    $sql = $query . $queryValue;
    if ($itemValues != 0) {
        $result = mysql_query($sql);
        if (!empty($result)) {
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
?>