<?php
class message_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }

function send_message($user_id, $message_to, $message){
	$db = $this->registry->getObject('database');
	$mail = $this->registry->getObject('mail_class');
	
	if(trim($message) == "" || trim($message_to) == ""){
		
		$response["success"] = 0;
		$response["count"] = 0;
        $response["message"] = "empty fields";
		
	}else{
	
$db->my_sql("SELECT user_id FROM users WHERE phone='".$message_to."' OR email='".$message_to."' OR username='".$message_to."' OR user_id='".$message_to."'");
	if($db->num_rows() == 0){
		
		$response["success"] = 0;
		$response["count"] = 0;
        $response["message"] = "invalid recipient";
		
	}else{
		foreach($db->get_rows() as $t){
		$message_to = $t['user_id'];
		}
		
	   // check to see if there is an existing trend of messages between the users
		$db->my_sql("SELECT id FROM message_data WHERE message_to='".$message_to."' AND message_from='".$user_id."'
		 OR message_from='".$message_to."' AND message_to='".$user_id."'");
		
		if($db->num_rows() == 0){ // no thread, create one
	$db->my_sql("INSERT INTO message_data (message_to, message_from, last) VALUES ('".$message_to."', '".$user_id."', now())", 1);
	
	        $threadid = $db->last_id();
			
		}else{ // there is a thread, get the id
			foreach($db->get_rows() as $t){
			$threadid = $t['id'];
			}
		}
		
		
	$db->my_sql("INSERT INTO messaging (message_id, message_to, message_from, message_subject, message_content, message_time) VALUES ('".$threadid."', '".$message_to."', '".$user_id."', '', '".$message."', now())", 1);
		
		$db->my_sql("UPDATE message_data SET last=now() WHERE id='".$threadid."'", 1);
		
		//formail sending
// get my friend username and email to send the email
$user_info_response = $user->profile_info($message_to);
$padi_user = $user_info_response["username"];
$padi_mail = $user_info_response["email"];

// get my username to add to the mail
$user_info_response = $user->profile_info($user_id);
$my_user = $user_info_response["username"];

$mail->friend_message_mail($padi_mail, $padi_user, $my_user);

        $response["success"] = 1;
		$response["count"] = 1;
        $response["message"] = "message sent successfully";
	}
}
	
return $response;
}


function read_message($message_id, $user_id){
	$db = $this->registry->getObject('database');
	
	//verify the message exists
 $db->my_sql("SELECT message_subject FROM messaging WHERE message_id='".$message_id."'");

 if ($db->num_rows() < 1) {
	 
    //this message does not exist
        $response["success"] = 0;
		$response["count"] = 0;
        $response["message"] = "message does not exist";
		
 }else{  // Message exists                                      PROCEED
	 
	 //authenthicate the message
$db->my_sql("SELECT id FROM message_data WHERE id='".$message_id."' AND (message_to='".$user_id."' OR message_from='".$user_id."')");
if($db->num_rows() == 0){
	
	//Message authenticity failed
	
        $response["success"] = 0;
		$response["count"] = 0;
        $response["message"] = "error viewing message";
		
}else{ // Message authenticity passed                          PROCEED
	
       //for recent messages
		$db->my_sql("SELECT message_to, message_from FROM messaging WHERE message_id='".$message_id."'");
		foreach($db->get_rows() as $t){
		$to = $t['message_to'];
		$from = $t['message_from'];
		}

 $db->my_sql("UPDATE messaging SET active='1' WHERE message_id='".$message_id."' AND message_to='".$user_id."'", 1);
 
 $db->my_sql("SELECT message_content, DATE_FORMAT(message_time, '%b %e %Y at %r') AS fmt_mess_time, message_from, message_to FROM messaging WHERE (message_to='".$to."' AND message_from='".$from."' OR message_from='".$to."' AND message_to='".$from."') ORDER BY message_time DESC");

 
if($db->num_rows() == 0){
	
	//no message available between the users yet
        $response["success"] = 0;
		$response["count"] = 0;
        $response["message"] = "no message available";
}else{
   
        $response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["read_message"] = $db->get_rows();

        }
        }
        }
		
 	
return $response;
}



function message_list($user_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
$db->my_sql("SELECT id, message_from, message_to FROM message_data WHERE message_to='".$user_id."' OR message_from='".$user_id."' ORDER BY last DESC");
	$response["all_count"] = $db->num_rows();


 $db->my_sql("SELECT id, message_from, message_to FROM message_data WHERE message_to='".$user_id."' OR message_from='".$user_id."' ORDER BY last DESC $limit");
 
     if($db->num_rows() == 0){
	        $response["success"] = 0;
	        $response["count"] = 1;
            $response["message"] = "inbox is empty";
     }else{
		    $response["success"] = 0;
	        $response["count"] = $db->num_rows();
            $response["message_list"] = $db->get_rows();
     }
	 
 return $response;
}


function message($property){
	 return $this->$property;
 }

}
?>
