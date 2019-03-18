<?php

include_once 'include/DB_Functions.php';
$db = new DB_Functions();

$regid = $_GET['r_id'];

$rsql = mysql_query("DELETE from register_master WHERE reg_id = '$regid'");
$lsql = mysql_query("DELETE from login_master WHERE login_uid = '$regid'");

if ($lsql and $rsql) {
    ?>
    <script type="text/javascript">
        alert("Deleted data successfully");
        window.location.href = 'list_of_officers.php';
    </script>
    <?php

} else {
    ?>
    <script type="text/javascript">
        alert('Could not delete data');
        window.location.href = 'list_of_officers.php';
    </script>
    <?php

}
?>
