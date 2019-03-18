<?php
include_once 'DB_Functions.php';
$db_handle = new DB_Functions();
if(!empty($_POST["cluster"])) {
	$query ="SELECT DISTINCT(village) FROM village_level_activity WHERE cluster = '" . $_POST["cluster"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select Village</option>
<?php
	foreach($results as $village) {
?>
	<option value="<?php echo $village["village"]; ?>"><?php echo $village["village"]; ?></option>
<?php
	}
}
?>