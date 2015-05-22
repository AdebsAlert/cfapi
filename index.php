<?php 
require_once("config.php"); // include the config file

require_once(SDK_PATH."campusfamz.php"); //include the sdk

$campusfamz = new CFapi; // call the SDK

$current_page_uri = $_SERVER['REQUEST_URI'];
$part_url = explode("/", $current_page_uri);
$page_name = end($part_url);

$browser_t = "web";

	include PHP_ROOT.$browser_t.'/api.php';
?>
<script type="text/javascript" src="<?php echo CF_URL; ?>web/js/jquery.min.js"></script>
