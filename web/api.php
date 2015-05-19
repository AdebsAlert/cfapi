<?php
error_reporting(0); session_start();
$array_url = split("/", $_SERVER['REQUEST_URI']); // get page model
$page = explode(".php", $array_url[2]); // change 2 to 1 in live server
$version = $array_url[3]; // change this 3 to 2 in live server
$function = $array_url[4]; // change this 4 to 3 in live server
$param = $array_url[5]; // change this 5 to 4 in live server

// work on the version changing
if(isset($_GET['ver'])){
	header ('location: '.API_URL.'api/'.$_GET['ver'].'');
		echo '<script type="text/javascript">document.location = "'.API_URL.'api/'.$_GET['ver'].'";
    </script>';exit;
}else{
	
}


if(!isset($version)){
	$version = "v1";
	header ('location: '.API_URL.'api/'.$version.'');
		echo '<script type="text/javascript">document.location = "'.API_URL.'api/'.$version.'";
    </script>';exit;
}elseif(isset($function) && isset($param) && !isset($_SERVER['PHP_AUTH_PW'])){
	header ('location: '.API_URL.'api/'.$version.'');
		echo '<script type="text/javascript">document.location = "'.API_URL.'api/'.$version.'";
    </script>';exit;
	
}else{
	
}


// check if it is someone trying to access the api doc page
if(isset($function) && isset($param) && isset($_SERVER['PHP_AUTH_USER'])){// its a full request, CONTINUE
$apiAuth->model($_SERVER['REQUEST_METHOD'], $version, $function, $param, $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], $_GET['ext'], $_GET['page']);
exit;
// return the whole process

}else{ // it is not a full request, SHOW THE API DOC PAGE
include("indexhead.php");	
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <title>Campusfamz | API Reference <?php echo strtolower($version); ?></title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
	<link href="<?php echo API_URL; ?>web/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo API_URL; ?>web/css/alert.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="shortcut icon" href="<?php echo API_URL; ?>web/images/campusfamz.jpg" />
    <meta name="HandheldFriendly" content="True" />
    <meta http-equiv="Cache-control" content="public">
	</head>
	<body>
    
<div class="content">
			<div class="wrap">
				<div class="content-grid">
			
				</div>
				<div class="grid">
		<p class="logo_name"><a href="<?php echo CF_URL; ?>" style="color:white">CF</a> 
        <a href="<?php echo API_URL; ?>api/<?php echo $version; ?>">API <?php echo $version; ?></a></p>
       
        </div>
        
		
		<div class="signup_container">
        
        <form>
        <select name="ver" class="text-center signup-title" style="margin:auto; font-size:16px; padding:4px;" onChange="this.form.submit()">
        <option value="v1" <?php if($version == "v1"){ echo "selected"; } ?>>v1.0</option>
        <option value="v2" <?php if($version == "v2"){ echo "selected"; } ?>>v2.0</option>
        </select>
        </form>
       
        <!-- main body here -->
       
          <div  class="form">
          
         <!-- main body here -->
</div> 
<div style="clear:both"></div>     
   
</div>


								<div class="clear"></div>
								</div>
		<div class="clear"></div>
		<div class="footer">
		
        <p>
       
        <a href="<?php echo CF_URL; ?>privacy.php">Privacy Policy</a> &middot; <a href="<?php echo $devurl; ?>">Developers</a> &middot; 
        <a href="<?php echo CF_URL; ?>career.php">Career</a> &middot; <a href="<?php echo API_URL; ?>api/<?php echo $version; ?>">API</a>
        </p>
        	
		<p>Copyright 2013 - <?php echo date("Y"); ?> | Campusfamz Inc. </p>
		</div>
		<div class="clear"></div>
		</div>
		</div>
		<div class="clear"></div>
        <?php include("apps_activator.php"); ?>
    </body>
</html>

<?php
}// end of the checking of full request
?>

