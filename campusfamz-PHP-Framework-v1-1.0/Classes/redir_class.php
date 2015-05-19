<?php
class redir_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
	
function redir_mobile(){ // redirect all mobile requests
			// get url first
    $url = $_SERVER['REQUEST_URI'];

// redirect using php  now 
$iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");
$opera1 = strpos($_SERVER['HTTP_USER_AGENT'], "OperaMini");
$opera2 = strpos($_SERVER['HTTP_USER_AGENT'], "OperaMobile");
$nokia = strpos($_SERVER['HTTP_USER_AGENT'], "Nokia");
$lg = strpos($_SERVER['HTTP_USER_AGENT'], "LG");
$samsung = strpos($_SERVER['HTTP_USER_AGENT'], "Samsung");
$htc = strpos($_SERVER['HTTP_USER_AGENT'], "HTC");
$motorola = strpos($_SERVER['HTTP_USER_AGENT'], "Motorola");
$sonyericsson = strpos($_SERVER['HTTP_USER_AGENT'], "SonyEricsson");
$bolt = strpos($_SERVER['HTTP_USER_AGENT'], "Bolt");
$palm = strpos($_SERVER['HTTP_USER_AGENT'], "Palm");
$tablet = strpos($_SERVER['HTTP_USER_AGENT'], "Tablet");

if($iphone || $android || $palmpre || $ipod || $berry || $opera1 || $opera2 || $nokia || $lg || $samsung || $htc
 || $motorola || $sonyericsson || $bolt || $palm || $tablet == true){
	
	header ('Location: http://m.campusfamz.com'.$url.'');
	
	echo '<script type="text/javascript">
document.location = "http://m.campusfamz.com'.$url.'";
</script>';
exit;
}
	}
	
	
function redir_home(){
	header ('Location: '.ROOT.'home.php');
		 echo '<script type="text/javascript">
document.location = "'.ROOT.'home.php";
</script>';
}

function redir_self(){
	header ('Location: '.ROOT.''.$_SERVER["HTTP_REFERER"].''); 
 echo '<script type="text/javascript">
document.location = "'.ROOT.''.$_SERVER["HTTP_REFERER"].'";
</script>';
}	
	
	
}

?>
