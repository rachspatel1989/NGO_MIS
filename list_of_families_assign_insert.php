<?php
include_once 'include/DB_Functions.php';
$db = new DB_Functions();

if (isset($_POST['btn-save'])) {
    
    $allocate_id = $_POST['allocateid'];
    $sql = "SELECT activity_allocation_master.activity_id FROM activity_allocation_master WHERE activity_allocation_master.allocate_id = $allocate_id";
    $select = mysql_query($sql);
    $row1 = mysql_fetch_assoc($select);
    $activity_id = $row1['activity_id'];
    if ($activity_id == "Rice cultivation with SRI") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_rice_cultivation.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Soyabean/Moong cultivation") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_soyabean_moong.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Gram/Toor Cultivation") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_gram_toor.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Vegetable Cultivation") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_vegetable_cultivation.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Land Levelling") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_land_levelling.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Orchard Development") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_orchard_development.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Cattle Induction") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_cattle_induction.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Poultry") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_poultry.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Goat Rearing") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_goat_rearing.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Skill Training") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_skill_training.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Grant support for self-employment") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_grant_support.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Credit support for self-employment") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_credit_support.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Group dug well irrigation scheme") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_dugwell_irrigation.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Group bore well irrigation scheme") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_borewell_irrigation.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Mini Lift irrigation scheme") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_minilift_irrigation.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "Pipe/Pump support") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_pipepump_support.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else if ($activity_id == "IGA through SHG programme") {
        ?>
        <script type="text/javascript">
            window.location.href = 'activity_incomegeneration.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            window.location.href = 'progress_tracker_insert.php?allocate_id=<?php echo $allocate_id ?>';
        </script>
        <?php
    }
}
