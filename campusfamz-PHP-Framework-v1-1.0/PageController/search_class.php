<?php
class search_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function user_list($user_id, $criteria, $page){
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
$my_city = $user_info_response["city"];
$my_sex = $user_info_response["sex"];
$my_country = $user_info_response["country"];

if($my_sex == "Male"){
	$opp_sex = "Female";
}else{
	$opp_sex = "Male";
}
	  
      $user_network_response = $friend->user_network($user_id);
	  $my_network = $user_network_response["network"];
 
 if($criteria == "newest"){ // newest users in my country not my friend
  $db->my_sql("SELECT matric FROM users WHERE country='".$my_country."' AND matric NOT IN (".$my_network.") ORDER BY user_id DESC");
	$response["all_count"] = $db->num_rows();
	
 $db->my_sql("SELECT matric FROM users WHERE country='".$my_country."' AND matric NOT IN (".$my_network.") ORDER BY user_id DESC $limit");
 
 }else if($criteria == "online"){ // online users in my country not my friend
  $db->my_sql("SELECT online.users_online FROM online RIGHT JOIN users ON online.users_online=users.user_id WHERE (users.country='".$my_country."') AND users.matric NOT IN (".$my_network.") ORDER BY online.active DESC");
	$response["all_count"] = $db->num_rows();
	
	 $db->my_sql("SELECT online.users_online FROM online RIGHT JOIN users ON online.users_online=users.user_id WHERE (users.country='".$my_country."') AND users.matric NOT IN (".$my_network.") ORDER BY online.active DESC $limit");
	 
 }else if($criteria == "city"){ // users from my city not my friend
  $db->my_sql("SELECT matric FROM users WHERE (country='".$my_country."' AND city='".$my_city."') AND matric NOT IN (".$my_network.") ORDER BY user_id DESC");
	$response["all_count"] = $db->num_rows();
	
  $db->my_sql("SELECT matric FROM users WHERE (country='".$my_country."' AND city='".$my_city."') AND matric NOT IN (".$my_network.") ORDER BY user_id DESC $limit");
	 
 }else if($criteria == "sex"){ // opposite sex users not my friend
 $db->my_sql("SELECT matric FROM users WHERE (country='".$my_country."' AND sex='".$opp_sex."') AND matric NOT IN (".$my_network.") ORDER BY user_id DESC");
	$response["all_count"] = $db->num_rows();
	
  $db->my_sql("SELECT matric FROM users WHERE (country='".$my_country."' AND sex='".$opp_sex."') AND matric NOT IN (".$my_network.") ORDER BY user_id DESC $limit");
	 
 }else{ // get all users
  $db->my_sql("SELECT matric FROM users ORDER BY user_id DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT matric FROM users ORDER BY user_id DESC $limit"); 
 }
 
 if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "no result found";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["user_list"] = $db->get_rows();
	}
	
	return $response;
}


function search_user($query, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1]; 
		 $end = $page_num * PAG;
         $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
 $db->my_sql("SELECT matric FROM users WHERE username LIKE '%".$query."%' OR user_id='".$query."' OR institution LIKE '%".$query."%' OR location='".$query."' OR matric='".$query."' OR email='".$query."' OR phone='".$query."'");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT matric FROM users WHERE username LIKE '%".$query."%' OR user_id='".$query."' OR institution LIKE '%".$query."%' OR location='".$query."' OR matric='".$query."' OR email='".$query."' OR phone='".$query."' $limit");
	
	 if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "no result found";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["search_user"] = $db->get_rows();
	}
	
	return $response;
	
}

function search($property){
	 return $this->$property;
 }

}
?>
