<?php
include_once 'DB_Functions.php';
$db_handle = new DB_Functions();
if(!empty($_POST["block"])) {
	$query ="SELECT DISTINCT(cluster) FROM village_level_activity WHERE cluster != '' AND block = '" . $_POST["block"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select Cluster</option>
<?php
	foreach($results as $cluster) {
?>
	<option value="<?php echo $cluster["cluster"]; ?>"><?php echo $cluster["cluster"]; ?></option>
<?php
	}
}
?>