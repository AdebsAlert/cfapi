<?php
class feed_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function send_shout($user_id, $shout, $privacy){
	 $db = $this->registry->getObject('database');
	
	$today = date("Y-m-d");
	$daily_limit = 5;
	
	// check if already made 5 shouts today
	$db->my_sql("SELECT id FROM shout WHERE time LIKE '%".$today."%' AND s_id='' AND matric='".$user_id."'");
	$left = $daily_limit - $db->num_rows();
		
	if(!empty($shout)){ // shout is not empty              PROCEED
		$db->my_sql("SELECT time FROM shout WHERE shouting ='".$shout."' AND matric='".$user_id."'");
		foreach($db->get_rows() as $t){
		$time = $t['time'];
		}
		
		$dbtime = strtotime($time); $now = time();
        if($now < ( $dbtime + 60*60*24 ) || $left == 0){ // daily limits exceeded ABORT
		$response["success"] = 0;
		$response["count"] = 0;
        $response["message"] = "daily limit $daily_limit exceeded";
			}
			else{ // daily limits not exceeded               PROCEED
				
	if($_SERVER['HTTP_HOST']== "www.campusfamz.com"){
		$via = "via PC";
		}else{
			$via = "via mobile";
	}
	
	if(preg_match_all('/#(\w+)/', $shout, $url)){ // there is an hash tag...put in trend table
$trend = str_replace("#", "", $url[0][0]);
$db->my_sql("INSERT INTO trends (trend, date) VALUES ('".$trend."', now())", 1);
	}else{
	}
	
	$db->my_sql("INSERT INTO shout (matric, shouting, time, active, via, privacy) VALUES 
	('".$user_id."', '".$shout."', now(), '2', '".$via."', '".$privacy."')", 1);
	    $response["success"] = 1;
		$response["count"] = 1;
        $response["message"] = "shout posted successfully";
	}
	
	}else{ // shout is empty
	
	    $response["success"] = 0;
		$response["count"] = 0;
		$response["message"] = "field is empty";
		}
		
		return $response;
	
}



function user_shout($user_id, $ext, $page){
	$db = $this->registry->getObject('database');
	$user = $this->registry->getObject('user_class');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	  
$user_info_response = $user->profile_info($user_id);
$my_username = $user_info_response["username"];

$db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e') AS fmt_sh_time, via, share_id FROM shout WHERE matric='".$user_id."' AND s_id='' ORDER BY time DESC");
	$response["all_count"] = $db->num_rows();

$db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e') AS fmt_sh_time, via, share_id FROM shout WHERE matric='".$user_id."' AND s_id='' ORDER BY time DESC $limit");

if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();$response["message"] = "$my_username has no shout yet";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["user_shout"] = $db->get_rows();
	}
	
	return $response;
	
}


function all_shout($user_id, $criteria, $page){
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
	$my_network = $user_network_response["network"];
	$my_instfriend = $user_network_response["instfriends"];
	$my_cityfriend = $user_network_response["cityfriends"];
	$my_homefriend = $user_network_response["homefriends"];
	
if($criteria == "all"){
	$w = "matric IN (".$my_network.")"; $feed="";
}elseif($criteria == "photo"){
	$w = "matric IN (".$my_network.")"; $feed="AND (via ='via PicsStory' OR via='New Avatar')";
}elseif($criteria == "video"){
	$w = "matric IN (".$my_network.")"; $feed="AND via ='via vidTube'"; 
}elseif($criteria == "music"){
	$w = "matric IN (".$my_network.")"; $feed="AND via ='via musicShare'"; 
}elseif($criteria == "institution"){
	$w = "matric IN (".$my_instfriend.")"; $feed=""; 
}elseif($criteria == "city"){
	$w = "matric IN (".$my_cityfriend.")"; $feed=""; 
}elseif($criteria == "hometown"){
	$w = "matric IN (".$my_homefriend.")"; $feed=""; 
}else{
}

$db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e') AS fmt_sh_time, via, share_id FROM shout WHERE s_id='' AND $w $feed");
	$response["all_count"] = $db->num_rows();

 $db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e') AS fmt_sh_time, via, share_id FROM shout WHERE s_id='' AND $w $feed $limit");
 
 if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();$response["message"] = "no shout to display";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["all_shout"] = $db->get_rows();
	}
	
	return $response;	
}


function like_shout($user_id, $shout_id){
	$db = $this->registry->getObject('database');
	$user = $this->registry->getObject('user_class');
	 
$user_info_response = $user->profile_info($user_id);
$my_username = $user_info_response["username"];
	
	$db->my_sql("SELECT matric, shouting FROM shout WHERE id='".$shout_id."' AND s_id=''");
foreach($db->get_rows() as $s){
$sh_owner = $s['matric'];
$sh_name = $s['shouting'];
}

$user_info_response = $user->profile_info($sh_owner);
$shouter_username = $user_info_response["username"];


$db->my_sql("INSERT INTO sh_notification (owner, notifier, sh_id, sh_topic, active, slike, liker, time) VALUES 
('".$shouter_username."', '".$shouter_username."', '".$shout_id."', '".$sh_name."', '0', '1', '".$my_username."', now())", 1);

$db->my_sql("UPDATE sh_notification SET active='1' WHERE sh_id='".$shout_id."' AND notifier='".$my_username."' AND liker='".$my_username."' AND slike='1'", 1);
if(isset($shout_id)){
	$db->my_sql("SELECT likes FROM slike_dislike WHERE mood_id='".$shout_id."' AND likes='1' AND mooder='".$user_id."'");
 if($db->num_rows() == 0){
	 $db->my_sql("INSERT INTO slike_dislike (mood_id, likes, mooder) VALUES ('".$shout_id."', '1', '".$user_id."')", 1);
 }
}


		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["success_message"] = "shout liked";
	
	return $response;
	
}


function unlike_shout($user_id, $shout_id){
	$db = $this->registry->getObject('database');
	$db->my_sql("DELETE FROM slike_dislike WHERE mood_id='".$shout_id."' AND mooder='".$user_id."'", 1);
	
	    $response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["success_message"] = "shout disliked";
	
	return $response;
}

function delete_shout($shout_id){
	$db = $this->registry->getObject('database');
	$db->my_sql("DELETE FROM shout WHERE id='".$shout_id."'", 1);
	$db->my_sql("DELETE FROM pic_story WHERE shout_id='".$shout_id."'", 1);
	
	$response["success"] = 1;
    $response["count"] = $db->num_rows();
    $response["success_message"] = "shout deleted";
	
	return $response;
}


function share_shout($user_id, $shout_id){
	$db = $this->registry->getObject('database');
	$user = $this->registry->getObject('user_class');
	 
// get shout owner first
	$db->my_sql("SELECT matric, shouting FROM shout WHERE id='".$shout_id."' AND s_id=''");
	foreach($db->get_rows() as $s){
	$sh_owner = $s['matric'];
	$shout = $s['shouting'];
	}
	
	// get owner username
	$user_info_response = $user->profile_info($sh_owner);
    $oshusernames = $user_info_response["username"];

	$shout = "[$oshusernames] : ".$shout;  
		
		  
	if($_SERVER['HTTP_HOST']== "www.campusfamz.com"){$via = "via PC";}else{$via = "via mobile";}
	
	if(preg_match_all('/#(\w+)/', $shout, $url)){ // there is an hash tag...put in trend table
$trend = str_replace("#", "", $url[0][0]);
$db->my_sql("INSERT INTO trends (trend, date) VALUES ('".$trend."', now())", 1);
	}
	
$db->my_sql("INSERT INTO shout (matric, shouting, time, active, via, share_id) VALUES ('".$user_id."', '".$shout."', now(), '2', '".$via."', '".$shout_id."')", 1);

        $response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["success_message"] = "shout shared";
	
	return $response;

}



function shout_comment($shout_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	
$db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e %Y at %r') AS fmt_sh_time FROM shout WHERE s_id='".$shout_id."' ORDER BY time ASC");
	$response["all_count"] = $db->num_rows();
	
$db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e %Y at %r') AS fmt_sh_time FROM shout WHERE s_id='".$shout_id."' ORDER BY time ASC $limit");
if($db->num_rows() == 0){ // no comment on shout
	    $response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["error_message"] = "no comment found";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["shout_comment"] = $db->get_rows();
	}
}




function comment_shout($user_id, $shoutid, $comment){
		$db = $this->registry->getObject('database');
	    $user = $this->registry->getObject('user_class');
	
    $user_info_response = $user->profile_info($user_id);
    $username = $user_info_response["username"];
	
if(empty($comment)){
	
	    $response["success"] = 0;
		$response["count"] = 0;
        $response["error_message"] = "empty comment";
	
	return $response;
	
     }else{
//add the post
$db->my_sql("INSERT INTO shout (s_id, matric, shouting, time, active) VALUES ('".$shoutid."', '".$user_id."', '".$comment."',  now(), '0')", 1);

// get shout owner first
	$db->my_sql("SELECT matric, shouting FROM shout WHERE id='".$shoutid."' AND s_id=''");
	$sfcount = $db->num_rows();
	foreach($db->get_rows() as $s){
	$sh_owner = $s['matric'];
	$sh_name = $s['shouting'];
	}
	
	// get shouter username
	$user_info_response = $user->profile_info($sh_owner);
    $oshusername = $user_info_response["username"];
	
	// get all other commentor too so they all get to see the notification
$db->my_sql("SELECT time FROM shout WHERE s_id='".$shoutid."' OR id='".$shoutid."'");
$com_count= $db->num_rows();
foreach($db->get_rows() as $c){
    $co_comtime = $c['time'];
	
	// get those peeps who commented too
	$db->my_sql("SELECT matric FROM shout WHERE time='".$co_comtime."'");
	foreach($db->get_rows() as $p){
	$peeps_mat = $p['matric'];
	}
	
	// get shouter username
    $user_info_response = $user->profile_info($peeps_mat);
    $pshusername = $user_info_response["username"];
	
	// now add them to the notification table
	$db->my_sql("INSERT INTO sh_notification (owner, notifier, sh_id, sh_topic, active, time) VALUES ('".$oshusername."', '".$pshusername."', '".$shoutid."', '".$sh_name."', '0', now())", 1);
	
	//update my own row so i wont get to see the notification
	$db->my_sql("UPDATE sh_notification SET active='1' WHERE sh_id='".$shoutid."' AND notifier='".$username."'", 1);
	
	    $response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["success_message"] = "comment posted";
	
	return $response;
}
}
}


function delete_shout_comment($comment_id){
	$db = $this->registry->getObject('database');
		
	$db->my_sql("DELETE FROM shout WHERE id='".$comment_id."'", 1);
	
	 $response["success"] = 1;
	$response["count"] = $db->num_rows();
      $response["success_message"] = "comment deleted";
	
	return $response;
}


function report_shout($user_id, $shout_id, $report){
	$db = $this->registry->getObject('database');
	$feed = $this->registry->getObject('feed_class');

	 if(!empty($report)){
	
   //add the post
     $db->my_sql("INSERT INTO inapp (pics_id, reporter, message, time) VALUES ('".$shout_id."', '".$user_id."', '".$report."',  now())", 1); 
	 // now count the reports, if its 5, delete the shout automatically
	 $db->my_sql("SELECT id FROM inapp WHERE pics_id='s_".$shout_id."'");
	 
	  $response["success"] = 1;
	  $response["count"] = $db->num_rows();
      $response["success_message"] = "shout reported";
	
	return $response;
	 
	 if($db->num_rows() >= 5){
		$feed->delete_shout($shout_id);
	 }else{
	 }
	  
	 }else{
		  $response["success"] = 0;
	      $response["count"] = $db->num_rows();
          $response["error_message"] = "empty report";
	
	return $response;
		 
	 }
}



function shout_liker($shout_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT * FROM slike_dislike WHERE likes='1' AND mood_id='".$shout_id."'");
	$response["all_count"] = $db->num_rows();

    $db->my_sql("SELECT * FROM slike_dislike WHERE likes='1' AND mood_id='".$shout_id."' $limit");
	if($db->num_rows() == 0){
		   $response["success"] = 0;
	      $response["count"] = $db->num_rows();
          $response["error_message"] = "nobody likes this";
	}else{
		$response["success"] = 1;
		$response["count"] = $db->num_rows();
        $response["shout_liker"] = $db->get_rows();	
	}
	
	return $response;
 
}


function view_shout($shoutid, $user_id){
	$db = $this->registry->getObject('database');
	$user = $this->registry->getObject('user_class');
	
    $user_info_response = $user->profile_info($user_id);
    $username = $user_info_response["username"];
  
	
	//update not as soon as i don enta d page
	 $db->my_sql("UPDATE sh_notification SET active='2' WHERE sh_id='".$shoutid."' AND notifier='".$username."'", 1);

	//update the active in shout if them mention my name
	$db->my_sql("SELECT * FROM shout WHERE shouting LIKE '%".$username."%' AND id='".$shoutid."'");
	if($db->num_rows() != 0){
	$db->my_sql("UPDATE shout SET active='3' WHERE id='".$shoutid."' AND shouting LIKE '%".$username."%'", 1);
     }
	
	
	//verify the shout exists
 $db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e') AS fmt_sh_time, via, share_id FROM shout WHERE id = '".$shoutid."'");
 if ($db->num_rows() < 1) {
    $response["success"] = 0;
	$response["count"] = $db->num_rows();
    $response["error_message"] = "shout no longer exist";
 }
 else {
    $response["success"] = 1;
    $response["count"] = $db->num_rows();
    $response["view_shout"] = $db->get_rows();
	}
	
	return $response;
}


function trend_shout($trend, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e') AS fmt_sh_time, via, share_id FROM shout WHERE s_id='' AND shouting LIKE '%#".$trend."%' ORDER BY id DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT id, matric, shouting, time, DATE_FORMAT(time, '%b %e') AS fmt_sh_time, via, share_id FROM shout WHERE s_id='' AND shouting LIKE '%#".$trend."%' ORDER BY id DESC $limit");
	
	if ($db->num_rows() < 1) {
    $response["success"] = 0;
	$response["count"] = $db->num_rows();
    $response["error_message"] = "no trend found";
 }
 else {
    $response["success"] = 1;
    $response["count"] = $db->num_rows();
    $response["trend_shout"] = $db->get_rows();
	}
	
	return $response;
 
}



function feed($property){
	 return $this->$property;
 }

}
?>
