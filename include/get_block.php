<?php
include_once 'DB_Functions.php';
$db_handle = new DB_Functions();
if(!empty($_POST["district_id"])) {
	$query ="SELECT * FROM block_master WHERE district_id = '" . $_POST["district_id"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select Block</option>
<?php
	foreach($results as $block) {
?>
	<option value="<?php echo $block["block_id"]; ?>"><?php echo $block["block_name"]; ?></option>
<?php
	}
}
?>