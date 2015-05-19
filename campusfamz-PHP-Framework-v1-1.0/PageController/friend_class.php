<?php
class friend_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
 

function friend_list($user_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND active='1' ORDER BY id DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND active='1' ORDER BY id DESC $page");
	if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user has no friend";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["friends"] = $db->get_rows();
	}
	
	return $response;
}


function famz_list($user_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND active='5' ORDER BY id DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND active='5' ORDER BY id DESC $limit");
	if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user has no friend";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["friends"] = $db->get_rows();
	}
	
	return $response;
}


function famzer_list($user_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT my_matric FROM friends WHERE my_friend_matric='".$user_id."' AND active='5' ORDER BY id DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT my_matric FROM friends WHERE my_friend_matric='".$user_id."' AND active='5' ORDER BY id DESC $limit");
	if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user has no friend";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["friends"] = $db->get_rows();
	}
	
	return $response;
}
 
 
function add_friend($user_id, $friend_id){
	  $db = $this->registry->getObject('database');
	  $friend = $this->registry->getObject('friend_class');
	  $user = $this->registry->getObject('user_class');
	  $mail = $this->registry->getObject('mail_class');
	  
	  $request_limit_response = $friend->request_limit($user_id);
	 
	 
	  if(($request_limit_response["today_add"] <= $request_limit_response["daily_add_limit"]) && $request_limit_response["total_friend"] < 150){
		  
		  $response["success"] = 1; // success in adding the two friends
	  
 $db->my_sql("DELETE FROM friends WHERE my_matric='".$user_id."' AND my_friend_matric='".$friend_id."'", 1);
 $db->my_sql("INSERT INTO friends (my_matric, my_friend_matric, time) VALUES ('".$user_id."', '".$friend_id."', now())", 1);
// for user notification
$db->my_sql("INSERT INTO friends_notification (mymatric, friendmatric, active, time) VALUES ('".$user_id."', '".$friend_id."', '0', now())", 1);$response["message"] = "<span style='color:red'><input type='button' class='but' style='background-color:#ABABD6' disabled value='Friend Request Sent' /></span><br>";

//formail
// get my friend username and email to send the email
$user_info_response = $user->profile_info($friend_id);
$padi_user = $user_info_response["username"];
$padi_mail = $user_info_response["email"];

// get my username to add to the mail
$user_info_response = $user->profile_info($user_id);
$my_user = $user_info_response["username"];

$mail->friend_request_mail($padi_mail, $padi_user, $my_user);
	  }
	  else{ // daily requests exceeded display the error
	$response["success"] = 0; // failure in adding the two friends 
	$response["message"] = "error adding friend";
	  }
	  
	  return $response;
}



function famz_friend($user_id, $friend_id){
	  $db = $this->registry->getObject('database');
	  $friend = $this->registry->getObject('friend_class');
	  $user = $this->registry->getObject('user_class');
	  $mail = $this->registry->getObject('mail_class');
	  
	  $request_limit_response = $friend->request_limit($user_id);
	 
	 
	  if($request_limit_response["today_famz"] <= $request_limit_response["daily_famz_limit"]){
		  
		  $response["success"] = 1; // success in famzing the two friends
	  

 $db->my_sql("INSERT INTO friends (my_matric, my_friend_matric, active, time) VALUES ('".$user_id."', '".$friend_id."', '5', now())", 1);
// for user notification
$db->my_sql("INSERT INTO friends_notification (mymatric, friendmatric, active, time) VALUES ('".$user_id."', '".$friend_id."', '5', now())", 1);$response["message"] = "<span style='color:red'><input type='button' class='but' style='background-color:#ABABD6' disabled value='Friend Request Sent' /></span><br>";

//formail
// get my friend username and email to send the email
$user_info_response = $user->profile_info($friend_id);
$padi_user = $user_info_response["username"];
$padi_mail = $user_info_response["email"];

// get my username to add to the mail
$user_info_response = $user->profile_info($user_id);
$my_user = $user_info_response["username"];

$mail->friend_famz_mail($padi_mail, $padi_user, $my_user);
	  }
	  else{ // daily requests exceeded display the error
	$response["success"] = 0; // failure in adding the two friends 
	$response["message"] = "error famzing friend";
	  }
	  
	  return $response;
}


function unfamz_friend($user_id, $friend_id){
	 $db = $this->registry->getObject('database');
	 
	 $db->my_sql("DELETE FROM friends WHERE my_matric='".$user_id."' AND my_friend_matric='".$friend_id."' AND active='5'", 1);
	 $db->my_sql("DELETE FROM friends_notification WHERE mymatric='".$user_id."' AND friendmatric='".$friend_id."' AND active='5'", 1);
	 
	 $response["success"] = 1; // success in un-famzing the two friends$response["message"] = "friend un-famzed successfully";
	 
	 return $response;
		
}


function unfriend_friend($user_id, $friend_id){
	 $db = $this->registry->getObject('database');
	 
	 $db->my_sql("DELETE FROM friends WHERE my_matric='".$user_id."' AND my_friend_matric='".$friend_id."' AND active='1'", 1);
	 $db->my_sql("DELETE FROM friends WHERE my_friend_matric='".$user_id."' AND my_matric='".$friend_id."' AND active='1'", 1);
	 
	 $response["success"] = 1; // success in un-friending the two friends$response["message"] = "friend un-friended successfully";
	 
	 return $response;
}


function block_friend($user_id, $friend_id){
	  $db = $this->registry->getObject('database');
	 
	 $db->my_sql("INSERT INTO block (my_matric, friend_matric, time) VALUES ('".$user_id."', '".$friend_id."', now())", 1);
     $db->my_sql("DELETE FROM friends WHERE my_matric='".$user_id."' AND my_friend_matric='".$friend_id."' OR my_matric='".$friend_id."' AND my_friend_matric='".$user_id."'", 1);
	 
	  $response["success"] = 1; // success in blocking the two friends$response["message"] = "friend blocked successfully";
	  
	  return $response;
	 
 }
 
 
function accept_friend($user_id, $friend_id){
	  $db = $this->registry->getObject('database');
	  $friend = $this->registry->getObject('friend_class');
	  $user = $this->registry->getObject('user_class');
	  $mail = $this->registry->getObject('mail_class');
	 
	 $request_limit_response = $friend->request_limit($user_id);
	 	 
	  if($request_limit_response["total_friend"] < 150){
	 
	$db->my_sql("UPDATE friends SET active='1' WHERE my_friend_matric='".$user_id."' AND my_matric='".$friend_id."' AND active='0'", 1);
	$db->my_sql("UPDATE friends SET active='1' WHERE my_matric='".$friend_id."' AND my_friend_matric='".$user_id."' AND active='5'", 1);
	$db->my_sql("DELETE FROM friends WHERE my_friend_matric='".$friend_id."' AND my_matric='".$user_id."' AND active='3'", 1);


$db->my_sql("INSERT INTO friends_notification (mymatric, friendmatric, active, time) VALUES ('".$user_id."', '".$friend_id."', '2', now())", 1);
$db->my_sql("INSERT INTO friends (my_matric, my_friend_matric, active, time) VALUES ('".$user_id."', '".$friend_id."', '1', now())", 1);

//formail
// get my friend username and email to send the email
$user_info_response = $user->profile_info($friend_id);
$padi_user = $user_info_response["username"];
$padi_mail = $user_info_response["email"];

// get my username to add to the mail
$user_info_response = $user->profile_info($user_id);
$my_user = $user_info_response["username"];

$mail->friend_accept_mail($padi_mail, $padi_user, $my_user);

$response["success"] = 1; // success in accepting the friend request$response["message"] = "friend un-famzed successfully";

	  }else{
		  // daily requests exceeded display the error
	$response["success"] = 0; // failure in accepting the friend request 
	$response["message"] = "error accepting friend request";
	  }
	  
	  return $response;
 }
 
 
function reject_friend($user_id, $friend_id){	 
    $db = $this->registry->getObject('database');

     $db->my_sql("UPDATE friends SET active='5' WHERE my_friend_matric='".$user_id."' AND my_matric='".$friend_id."'", 1);
     $db->my_sql("INSERT INTO friends (my_matric, my_friend_matric, active) VALUES ('".$user_id."', '".$friend_id."', '3')", 1);
	 
	 $response["success"] = 1; // success in rejecting the friend request$response["message"] = "friend request rejected";
	 
	 return $response;
 }
 
 
 function pend_list($user_id, $ext, $page){
	 $db = $this->registry->getObject('database');
	 
	 if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND active='0' ORDER BY id DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND active='0' ORDER BY id DESC $limit");
	if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user has no friend";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["friends"] = $db->get_rows();
	}
	
	return $response;

}


function block_list($user_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT friend_matric FROM block WHERE my_matric='".$user_id."' ORDER BY id DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT friend_matric FROM block WHERE my_matric='".$user_id."' ORDER BY id DESC $limit");
	if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user has no friend";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["friends"] = $db->get_rows();
	}
	
	return $response;
	
}


function unblock_friend($user_id, $friend_id){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("DELETE FROM block WHERE my_matric='".$user_id."' AND friend_matric='".$friend_id."'", 1);
	
	$response["success"] = 1; // success in unblocking the friend$response["message"] = "friend unblocked successfully";
	
	return $response;
	
}


function friend_suggestion($user_id, $ext, $page){
	  $db = $this->registry->getObject('database');
	  $user = $this->registry->getObject('user_class');
	  $friend = $this->registry->getObject('friend_class');
	  
	  if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	  
$user_info_response = $user->profile_info($user_id);
$my_inst = $user_info_response["institution"];
$my_city = $user_info_response["city"];
$my_location = $user_info_response["location"];
	  
      $user_network_response = $friend->user_network($user_id);
	  $my_network = $user_network_response["network"];
	  
$db->my_sql("SELECT users.matric FROM users RIGHT JOIN image ON users.matric=image.matric WHERE (users.institution='".$my_inst."' OR users.city='".$my_city."' OR users.location='".$my_location."') AND (image.active='1') AND users.matric NOT IN (".$my_network.") ORDER BY RAND()");
	$response["all_count"] = $db->num_rows();
 
 $db->my_sql("SELECT users.matric FROM users RIGHT JOIN image ON users.matric=image.matric WHERE (users.institution='".$my_inst."' OR users.city='".$my_city."' OR users.location='".$my_location."') AND (image.active='1') AND users.matric NOT IN (".$my_network.") ORDER BY RAND() $limit");
 
 if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user has no suggestion";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["friend_suggestion"] = $db->get_rows();
	}
	
	return $response;
}


function mutual_friends($user_id, $friend_id, $page){
	$db = $this->registry->getObject('database');
	$friend = $this->registry->getObject('friend_class');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	 
	 
	 $user_network_response = $friend->user_network($user_id);
	 $my_friends = $user_network_response["friends"];
	
$db->my_sql("SELECT my_friend_matric FROM friends WHERE (my_matric='".$friend_id."' AND my_friend_matric IN ($my_friends)) AND (active='3' OR active='1' OR active='4')");
	$response["all_count"] = $db->num_rows();
 
 $db->my_sql("SELECT my_friend_matric FROM friends WHERE (my_matric='".$friend_id."' AND my_friend_matric IN ($my_friends)) AND (active='3' OR active='1' OR active='4') $limit");
 
 if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user has no suggestion";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["mutual_friends"] = $db->get_rows();
	}
	
	return $response;
}


function user_network($user_id){
	 $db = $this->registry->getObject('database');
	 $user = $this->registry->getObject('user_class');
	 
$user_info_response = $user->profile_info($user_id);
$my_inst = $user_info_response["institution"];
$my_city = $user_info_response["city"];
$my_hometown = $user_info_response["hometown"];
	 
	 // get friend network
$fm_res = mysql_query("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND (active='1' OR active='5')");
 while ($network  = mysql_fetch_array($fm_res, MYSQL_NUM)) {
	  foreach ($network as $network) { 
	  $friends .= $network.",";
        $net .= $network. ",";
    }	 
 }
 
 // get institution mates
$fm_res = mysql_query("SELECT matric FROM users WHERE institution='".$my_inst."'");
 while ($network  = mysql_fetch_array($fm_res, MYSQL_NUM)) {
	  foreach ($network as $instnetwork) { 
	  $instfriends .= $instnetwork.",";
    }	 
 }
 
 // get city mates
$fm_res = mysql_query("SELECT matric FROM users WHERE city='".$my_city."'");
 while ($network  = mysql_fetch_array($fm_res, MYSQL_NUM)) {
	  foreach ($network as $citynetwork) { 
	  $cityfriends .= $citynetwork.",";
    }	 
 }
 
 // get hometown mates
$fm_res = mysql_query("SELECT matric FROM users WHERE hometown='".$my_hometown."'");
 while ($network  = mysql_fetch_array($fm_res, MYSQL_NUM)) {
	  foreach ($network as $homenetwork) { 
	  $homefriends .= $homenetwork.",";
    }	 
 }
 
$response["instfriends"] = $instfriends."-1";
$response["cityfriends"] = $cityfriends."-1";
$response["homefriends"] = $homefriends."-1";
$response["friends"] = $friends."-1";
$response["network"] = str_replace(",,", ",", $net). $user_id;

return $response;

 }
 

function request_limit($user_id){
	  $db = $this->registry->getObject('database');
	  $friend = $this->registry->getObject('friend_class');
	   
	  $today = date("Y-m-d");
	  
	  $response["daily_add_limit"] = 20;
	  $response["daily_famz_limit"] = 50;
	  

	  $db->my_sql("SELECT id FROM friends WHERE my_matric='".$user_id."' AND active='0' AND time LIKE '%".$today."%'"); // dialy friend add
	  $response["today_add"] = $db->num_rows();
	  
	  $db->my_sql("SELECT id FROM friends WHERE my_matric='".$user_id."' AND active='5' AND time LIKE '%".$today."%'"); // daily friend famz
	  $response["today_famz"] = $db->num_rows();
	  
	  $user_friend_response = $friend->friend_list($user_id); // friend count already have
	  $response["total_friend"] = $user_friend_response["count"];
	  
	  return $response;	
}


function pending_requests($user_id, $ext, $page){
	 $db = $this->registry->getObject('database');
	 
	 if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND active='3'");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT my_friend_matric FROM friends WHERE my_matric='".$user_id."' AND active='3' $limit");
	if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "no pending friend requests";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["friends"] = $db->get_rows();
	}
	
	return $response;

}


function check_friend($user_id, $friend_id){
	 $db = $this->registry->getObject('database');
	 
	 if($user_id == $friend_id){
		 $response["count"] = 1;
	 }else{	 
	  $db->my_sql("SELECT id FROM friends WHERE (my_matric='".$user_id."' AND my_friend_matric='".$friend_id."' AND active='1')");
	  $response["count"] = $db->num_rows();
	 }
	 
	 return $response;
 }
 
function check_famz($user_id, $friend_id){
      $db = $this->registry->getObject('database');
	  
      $db->my_sql("SELECT id FROM friends WHERE my_matric='".$user_id."' AND my_friend_matric='".$friend_id."' AND active='5'");
       if($user_id == $friend_id){
		 $response["count"] = 1;
	 }else{	 
	  $db->my_sql("SELECT id FROM friends WHERE (my_matric='".$user_id."' AND my_friend_matric='".$friend_id."' AND active='1')");
	  $response["count"] = $db->num_rows();
	 }
	 
	 return $response;
 
 }
 
 
function friend_requests($user_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
$db->my_sql("SELECT my_matric FROM friends WHERE my_friend_matric='".$user_id."' AND active='0'");
	$response["all_count"] = $db->num_rows();
 
 $db->my_sql("SELECT my_matric FROM friends WHERE my_friend_matric='".$user_id."' AND active='0' $limit");
 
 
 	if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "no friend requests";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["friend_requests"] = $db->get_rows();
	}
	
	return $response;

}


function friend($property){
	 return $this->$property;
 }

}
?>
