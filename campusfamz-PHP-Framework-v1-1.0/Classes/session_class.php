<?php
/**
 * Copyright 2015 Campusfamz.
 */

 
class session_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
	

function set_session($id, $pass, $login){
	$_SESSION['cfuser'] = $id;
	$_SESSION['cfpassword'] = $pass;
	
	setcookie("cfuser", $id, time()+3600*24*7);
	setcookie("cflogin", $login, time()+3600*24*7);
	setcookie("cfpassword", $pass, time()+3600*24*7);
	
	$response["success"] = 1;
    $response["count"] = 1;
    $response["success_message"] = "session setted"; 
	
return $response; 
}


function destroy_session(){	
	session_destroy();
    
	setcookie("cfuser", "", time()-60*60*24*7);
	setcookie("cfpassword", "", time()-60*60*24*7);
	

}
	
	
}

?>
