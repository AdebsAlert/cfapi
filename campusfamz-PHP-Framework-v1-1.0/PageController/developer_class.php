<?php
class developer_class {
	
		protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
 
 
function registerDev($user_id){
	$db = $this->registry->getObject('database');
	
	$generated_key = md5($user_id.rand(1, 10000000000000)); 
	$generated_id = rand (1, 99999999999);
	
	$db->my_sql("INSERT INTO developers (user_id, developer_id, developer_key, active) VALUES 
	('".$user_id."', '".$generated_id."', '".$generated_key."', '1')");
	
   $response["success"] = 1; 
   $response["message"] = "developer registered successfully";
   $response["developer_id"] = $generated_id;
   $response["developer_key"] = $generated_key;
   
   return $response;
	 
}


function getDev($user_id){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("SELECT * FROM developers WHERE user_id='".$user_id."'");

	foreach($db->get_rows() as $d){
		$devID = $d['developer_id'];
		$devKey = $d['developer_key'];
		$active = $d['active'];
	}
	$response["count"] = $db->num_rows();
    $response["developer_id"] = $devID;
    $response["developer_key"] = $devKey;
	$response["developer_status"] = $active;
   
   return $response;
}


function retrieveDev($user_id){
	$db = $this->registry->getObject('database');
	$user = $this->registry->getObject('user_class');
	$mail = $this->registry->getObject('mail_class');
	
	$db->my_sql("SELECT * FROM developers WHERE user_id='".$user_id."'");
	foreach($db->get_rows() as $d){
		$devID = $d['developer_id'];
		$devKey = $d['developer_key'];
		$active = $d['active'];
	}
	
	// get username and email to send the email
$user_info_response = $user->profile_info($user_id);
$user_name = $user_info_response["username"];
$user_mail = $user_info_response["email"];

$message ='<p>Hi $user_mail,</p><br>
Here are your Developer credentials:<br><br>
Developer ID: <b>$devID</b><br>
Developer Key: <b>$devKey</b><br>

';

	$send_mail = $mail->send_email($user_mail, $subject, $message);
	
   $response["success"] = 1; 
   $response["email"] = $user_mail; 
   $response["message"] = "developer key reminder has been sent successfully";
   
   return $response;
}


function developer($property){
	 return $this->$property;
}

}
?>
