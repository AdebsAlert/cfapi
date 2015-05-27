<?php 
error_reporting(0); session_start();
$array_url = split("/", $_SERVER['REQUEST_URI']); // get page model
$version = $array_url[3]; // change this 3 to 2 in live server
$function = $array_url[4]; // change this 4 to 3 in live server
$param = $array_url[5]; // change this 5 to 4 in live server

//check if the version has aa attachement
if(isset($_GET['ver'])){
	$v = explode("?ver", $version);
	$version = $v[0];
}


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
