<?php
class photo_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function profile_photo($user_id){
	$db = $this->registry->getObject('database');
	
	// get the user profile photo
		$db->my_sql("SELECT image_id, image_type, image_name FROM image WHERE matric='".$user_id."' AND active='1'");
		if($db->num_rows() == 1){ // means the user has a profile pics
    foreach($db->get_rows() as $n){
	$response["count"] = $db->num_rows();
    $response["image_link"] = "".IMAGE_PATH."album/large_".$n['image_name'];
    $response["image_type"] = $n['image_type'];
	$response["image_id"] = $n['image_id'];
	}
	
   }else{ // user does not have a profile photo
   $response["count"] = 0;
   $response["image_link"] = "".IMAGE_PATH."icon/no_photo.png";
   $response["image_type"] = "";
   $response["image_id"] = "";
   } 
	
	return $response;
}


function all_photo($user_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1]; 
		 $end = $page_num * PAG;
        $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
$db->my_sql("SELECT image_id, image_type, image_name FROM image WHERE matric='".$user_id."' AND (active='1' OR active='4' OR active='3')");
	$response["all_count"] = $db->num_rows();
	
	// get the user profile photo
	$db->my_sql("SELECT image_id, image_type, image_name FROM image WHERE matric='".$user_id."' AND (active='1' OR active='4' OR active='3') $limit");
	$response["count"] = $db->num_rows();
	
	foreach($db->get_rows() as $n){
    $response["image_link"] = "".IMAGE_PATH."album/large_".$n['image_name'];
    $response["image_type"] = $n['image_type'];
	$response["image_id"] = $n['image_id'];
	}
	
	
	return $response;
	
}


function cover_photo($user_id){
	 $db = $this->registry->getObject('database');
	 $this->defaultcover = "".IMAGE_PATH."cover/default3.jpg";
	
	$db->my_sql("SELECT image_name FROM cover_photo WHERE matric='".$user_id."' AND active='1'"); 
	if($db->num_rows() == 1){
    foreach($db->get_rows() as $n){
    $response["count"] = $db->num_rows();
    $response["image_link"] = "".IMAGE_PATH."cover/".$n['image_name'];
	}
	}else{
   $response["count"] = 0;
   $response["image_link"] = "".IMAGE_PATH."icon/defaultcover.jpg";	
	}	
	return $response;

		 
 }



function upload_photo($user_id, $type, $error, $size, $name, $tmp, $caption, $loc, $album_name, $privacy){
        $db = $this->registry->getObject('database');
	  
$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $name));

if ((($type == "image/jpeg") || ($type == "image/jpg") || ($type == "image/gif") || ($type == "image/png")) && ($size < 1500000)){
  if ($error > 0){
	  
    $response["success"] = 0;
	$response["count"] = 0;
    $response["message"] = "error uploading photo";
	
    }else{
    $file_name = rand(1,99999999999)."_".$user_id."_".rand(1,99999999999).".".$extension[0].$extension[1].$extension[2].$extension[3]; 
    $file_size = $size; 
    $file_type = $type;
	
	$handle = fopen($tmp, "r");
	$data = fread($handle, filesize($tmp));
	$POST_DATA = array('file'=>base64_encode($data), 'name'=>$file_name, 'folder'=>$loc);
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, ''.IMAGE_PATH.''.$loc.'_handle.php');
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);

	  curl_exec($curl);
	  curl_close($curl);
	  

  /** now work on the db record of the photo in its respective album **/ 

	  if($loc == "album"){ // it is an album photo
	  
	  if($album_name != "profile"){
	  $relalert = "added a new photo";
	  $via = "album photo";
	  $loc_id = 3;
	  }else{
	  $relalert = "new profile photo";
	  $via = "profile photo";
	  $loc_id = 1;
	  }
	
	$db->my_sql("DELETE FROM shout WHERE matric='".$user_id."' AND shouting='".$relalert."'", 1);
	$db->my_sql("INSERT INTO shout (matric, shouting, time, active, via) VALUES ('".$user_id."', '".$relalert."', now(), '2', '".$via."')", 1);
	  // get image_id
$db->my_sql("SELECT image_id, image_name, matric FROM image WHERE matric='".$user_id."' AND (active='1' OR active='2')");
foreach($db->get_rows() as $i){
$image_mat = $i['matric'];
$image_id = $i['image_id'];
$image_name = $i['image_name'];
}
$db->my_sql("DELETE FROM image_comments WHERE image_id='".$image_id."'", 1);

$db->my_sql("DELETE FROM image WHERE matric='".$user_id."' AND active='2'", 1);

$db->my_sql("UPDATE image SET active='4' WHERE active='1' AND matric='".$user_id."'", 1);

$db->my_sql("INSERT INTO image (matric, image_type, image_size, image_name, image_date, active, privacy, country, caption)
VALUES ('".$user_id."', '".$file_type."', '".$file_size."', '".$file_name."', NOW(), '".$loc_id."', '".$privacy."',
'".$my_country."', '".$caption."')", 1);

 
    $response["success"] = 1;
	$response["count"] = 1;
    $response["message"] = "photo uploaded successfully";
	  }
	  
	  
	  elseif($loc == "shout"){ // it is a shout photo
	$today = date("Y-m-d");
	$daily_limit = 5;
	
	// check if already made 5 shouts today
	$db->my_sql("SELECT id FROM shout WHERE time LIKE '%".$today."%' AND s_id='' AND matric='".$user_id."'");
	$left = $daily_limit - $db->num_rows();
	
	if($left == 0){ // daily limits exceeded ABORT
		$response["success"] = 0;
		$response["count"] = 0;
        $response["message"] = "daily limit $daily_limit exceeded";
		
	}else{ // daily limits not exceeded               PROCEED
	
	  $picshout = $caption;
	  $via = "via PicsStory";
	
	if(preg_match_all('/#(\w+)/',  $picshout, $url)){ // there is an hash tag...put in trend table
$trend = str_replace("#", "", $url[0][0]);
$db->my_sql("INSERT INTO trends (trend, date) VALUES ('".$trend."', now())", 1);
	}else{}
	$db->my_sql("INSERT INTO shout (matric, shouting, time, active, via, privacy) VALUES 
	('".$user_id."', '".$picshout."', now(), '2', '".$via."', '".$privacy."')", 1);
	$shid = $db->last_id();

$db->my_sql("INSERT INTO pic_story (matric, shout_id, image_type, image_size, image_name, image_date) VALUES 
('".$user_id."', '".$shid."', '".$file_type."', '".$file_size."', '".$file_name."', NOW())", 1);

    $response["success"] = 1;
	$response["count"] = 1;
    $response["message"] = "photo posted successfully";
		
	}
		  
	  }elseif($loc == "forum"){ // it is a forum photo
		 
		 $db->my_sql("INSERT INTO forum_pics (topic_id, image_type, image_size, image_name, image_date) VALUES 
		 ('".$user_id."', '".$file_type."', '".$file_size."', '".$file_name."', now())", 1);
		 
    $response["success"] = 1;
	$response["count"] = 1;
    $response["message"] = "photo posted successfully";	
		  
	  }elseif($loc == "cover"){
		  
	 $db->my_sql("UPDATE cover_photo SET active='0' WHERE matric='".$user_id."'", 1);
   
	  $db->my_sql("INSERT INTO cover_photo (matric, image_type, image_size, image_name, image_date, active) VALUES ('".$user_id."', '".$file_type."', '".$file_size."', '".$file_name."', now(), '1')", 1);
		  
	  }elseif($loc == "cover"){
		  
	  }


    }
  }
  
  return $response; 
 }
 
 
 
function rate_photo($user_id, $image_id, $addrate){
$db = $this->registry->getObject('database');

$db->my_sql("SELECT id FROM rate WHERE user_id='".$user_id."' AND image_id='".$image_id."'");
if($db->num_rows() == 1){
	$response["success"] = 0;
	$response["count"] = 1;
    $response["message"] = "you already rated this";
}else{

$db->my_sql("SELECT rate FROM image WHERE image_id='".$image_id."'"); 
foreach($db->get_rows() as $r){
	$rating = $r['rate'];
}
$newrate = $addrate + $rating;

$db->my_sql("UPDATE image SET rate='$newrate' WHERE image_id='".$image_id."'", 1);
$db->my_sql("INSERT INTO rate (user_id, image_id) VALUES ('".$user_id."', '".$image_id."')", 1);

    $response["success"] = 1;
	$response["count"] = 1;
    $response["message"] = "rating made successfully";
}
	
return $response; 
 }
 



 function get_photos($folder, $user_id, $page){
	 $db = $this->registry->getObject('database');
	 
	 if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1]; 
		 $end = $page_num * PAG;
         $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	 
	 if($folder == "album"){
		 $db->my_sql("SELECT * FROM image WHERE matric='".$user_id."' AND active='3' ORDER BY image_id DESC");
	$response["all_count"] = $db->num_rows();
	
		 $db->my_sql("SELECT * FROM image WHERE matric='".$user_id."' AND active='3' ORDER BY image_id DESC $limit");
		 
         if($db->num_rows() == 0){
			$response["success"] = 0;
	        $response["count"] = 1;
            $response["message"] = "no photo found in album"; 
		 }else{
			$response["success"] = 1;
		    $response["count"] = $db->num_rows();
           foreach($db->get_rows() as $a){
				$response["image_link"] = "".IMAGE_PATH."album/large_".$a['image_name'];
                $response["image_type"] = $a['image_type'];
			} 
		 }
		 
	 }elseif($folder == "profile"){
		 $db->my_sql("SELECT * FROM image WHERE matric='".$user_id."' AND (active='1' OR active='4') ORDER BY image_id DESC");
	$response["all_count"] = $db->num_rows();
	
		 $db->my_sql("SELECT * FROM image WHERE matric='".$user_id."' AND (active='1' OR active='4') ORDER BY image_id DESC $limit");
		 
         if($db->num_rows() == 0){
			$response["success"] = 0;
	        $response["count"] = 1;
            $response["message"] = "no photo found in album"; 
		 }else{
			$response["success"] = 1;
		    $response["count"] = $db->num_rows();
            foreach($db->get_rows() as $p){
				$response["image_link"] = "".IMAGE_PATH."album/large_".$p['image_name'];
                $response["image_type"] = $p['image_type'];
			}
		 }
		 
	 }elseif($folder == "shout"){
		 $db->my_sql("SELECT * FROM pic_story WHERE matric='".$user_id."' ORDER BY image_date DESC");
	$response["all_count"] = $db->num_rows();
	
		 $db->my_sql("SELECT * FROM pic_story WHERE matric='".$user_id."' ORDER BY image_date DESC $limit");
          
		  if($db->num_rows() == 0){
			$response["success"] = 0;
	        $response["count"] = 1;
            $response["message"] = "no photo found in album"; 
		 }else{
			$response["success"] = 1;
		    $response["count"] = $db->num_rows();
           foreach($db->get_rows() as $s){
				$response["image_link"] = "".IMAGE_PATH."shout/".$s['image_name'];
                $response["image_type"] = $s['image_type'];
			} 
		 }
		 
	 }elseif($folder == "forum"){
		  $db->my_sql("SELECT * FROM forum_pics WHERE topic_id='".$user_id."'");
	$response["all_count"] = $db->num_rows();
	
		 $db->my_sql("SELECT * FROM forum_pics WHERE topic_id='".$user_id."' $limit");
          
		  if($db->num_rows() == 0){
			$response["success"] = 0;
	        $response["count"] = 1;
            $response["message"] = "no photo found in album"; 
		 }else{
			$response["success"] = 1;
		    $response["count"] = $db->num_rows();
            foreach($db->get_rows() as $t){
					
				$response["image_link"] = "".IMAGE_PATH."forum/".$t['image_name'];
				
                $response["image_type"] = $t['image_type'];
				$response["image_ext_link"] = $t['image_link'];
			}
		 }
		 
	 }else{
		 
	 }
	 
return $response; 
	 
 }
 
 
 
function view_photo($folder, $photo_id){
	 	 $db = $this->registry->getObject('database');
	 
	 if($folder == "album"){
		 $db->my_sql("SELECT image_name FROM image WHERE image_id='".$photo_id."'");
		 
         if($db->num_rows() == 0){
			$response["success"] = 0;
	        $response["count"] = 1;
            $response["message"] = "no photo found"; 
		 }else{
			 foreach($db->get_rows() as $i){
				 $image_name = $i['image_name'];
			 }
			$response["success"] = 1;
		    $response["count"] = $db->num_rows();
            $response["image_link"] = "".IMAGE_PATH."album/large_".$image_name;
		 }
		 
	 }elseif($folder == "shout"){
		 $db->my_sql("SELECT image_name FROM pic_story WHERE shout_id='".$user_id."'");
          
		  if($db->num_rows() == 0){
			$response["success"] = 0;
	        $response["count"] = 1;
            $response["message"] = "no photo found"; 
		 }else{
			foreach($db->get_rows() as $i){
				 $image_name = $i['image_name'];
			 }
			$response["success"] = 1;
		    $response["count"] = $db->num_rows();
            $response["image_link"] = "".IMAGE_PATH."shout/".$image_name; 
		 }
		 
	 }elseif($folder == "forum"){
		 $db->my_sql("SELECT image_name FROM forum_pics WHERE topic_id='".$photo_id."'");
          
		  if($db->num_rows() == 0){
			$response["success"] = 0;
	        $response["count"] = 1;
            $response["message"] = "no photo found"; 
		 }else{
			foreach($db->get_rows() as $i){
				 $image_name = $i['image_name'];
			 }
			$response["success"] = 1;
		    $response["count"] = $db->num_rows();
            $response["image_link"] = "".IMAGE_PATH."forum/".$image_name; 
		 }
		 
	 }else{
		 
	 }
	 
return $response;
 }
 
 
 
function photo_comments($image_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1]; 
		 $end = $page_num * PAG;
         $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
 $db->my_sql("SELECT id, commentor, comment, comment_time, DATE_FORMAT(comment_time, '%b %e %Y at %r') AS fmt_comment_time FROM image_comments WHERE image_id='".$image_id."' ORDER BY comment_time ASC");
	$response["all_count"] = $db->num_rows();

$db->my_sql("SELECT id, commentor, comment, comment_time, DATE_FORMAT(comment_time, '%b %e %Y at %r') AS fmt_comment_time FROM image_comments WHERE image_id='".$image_id."' ORDER BY comment_time ASC $limit");
 
        if($db->num_rows() == 0){
			$response["success"] = 0;
	        $response["count"] = 0;
            $response["message"] = "no comment on photo"; 
		 }else{
			$response["success"] = 1;
	        $response["count"] = $db->num_rows();
            $response["photo_comments"] = $db->get_rows();
		 }
		 	 
 return $response;
}


function delete_photo_comment($comment_id){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("DELETE FROM image_comments WHERE id='".$comment_id."'", 1);
	
	       $response["success"] = 1;
	       $response["count"] = 1;
           $response["message"] = "comment deleted successfully"; 
	
	return $response;
}


function comment_photo($user_id, $image_id, $comment){
	$db = $this->registry->getObject('database');
	$user = $this->registry->getObject('user_class');
	
	$user_info_response = $user->profile_info($user_id);
    $username = $user_info_response["username"];

	  if($comment == ""){
		  $response["success"] = 0;
	       $response["count"] = 0;
           $response["message"] = "empty comment"; 
	  }else{
   //add the comment
   $db->my_sql("INSERT INTO image_comments (image_id, commentor, comment, comment_time, active) VALUES 
   ('".$image_id."', '".$username."', '".$comment."', now(), '0')", 1);
	
	 
	 	// get all other commentor too so they all get to see the notification
    $db->my_sql("SELECT * FROM image_comments WHERE image_id='".$image_id."'");
	foreach($db->get_rows() as $p){
	$peeps_username = $p['commentor'];
	
	// get image_id and owner
    $db->my_sql("SELECT matric FROM image WHERE image_id='".$image_id."'");
    foreach($db->get_rows() as $i){ 
    $owner = $i['matric'];
    }

	//insert the commentor, owner, date, and all other infos
	$db->my_sql("INSERT INTO picscom_notification (owner, notifier, not_id, active, not_time) VALUES 
	('".$owner."', '".$peeps_username."', '".$image_id."', 0, now())", 1);
	
	//update my own row so i wont get to see the notification
	$db->my_sql("UPDATE picscom_notification SET active='1' WHERE not_id='".$image_id."' AND notifier='".$username."'", 1);
	}
	
	       $response["success"] = 1;
	       $response["count"] = 1;
           $response["message"] = "comment posted successfully";
 } 
 
return $response;
}


function report_photo($user_id, $image_id, $report){
	$db = $this->registry->getObject('database');
	$photo = $this->registry->getObject('photo_class');
	
	 if($report == ""){
	  $response["success"] = 0;
	  $response["count"] = 0;
      $response["message"] = "error reporting photo";
	 }else{
	// check for exsisting report
	$db->my_sql("SELECT id FROM inapp WHERE reporter='".$user_id."' AND pics_id='".$image_id."'");
	if($db->num_rows() == 0){ // first time reporting this photo
   //add the post
   $db->my_sql("INSERT INTO inapp (pics_id, reporter, message, time) VALUES ('".$image_id."', '".$user_id."', '".$report."',  now())", 1);
	 
	 // now count the reports, if its 5, delete the pics automatically
	 $db->my_sql("SELECT id FROM inapp WHERE pics_id='".$image_id."'");
	 
	 if($db->num_rows() >= 5){
		$photo->delete_photo($image_id);
	 }else{ // do not take del action yet
		 } 
	 $response["success"] = 1;
	  $response["count"] = 1;
      $response["message"] = "report sent successfully";
	}else{ // already reported the image
	}
	 }
	 
	 return $response;
}


function delete_photo($image_id){
     $db = $this->registry->getObject('database');

    $db->my_sql("SELECT image_name FROM image WHERE image_id='".$image_id."'"); 
foreach($db->get_rows() as $n){
 $name = $n['image_name'];
}
 $plarge = "".IMAGE_PATH."album/large_".$name; 
 $pmedium = "".IMAGE_PATH."album/medium_".$name; 
 $pthumb = "".IMAGE_PATH."album/thumb_".$name;  
 
 unlink($plarge); unlink($pmedium); unlink($pthumb);
 
 $db->my_sql("DELETE FROM image WHERE image_id='".$image_id."'", 1);
 $db->my_sql("DELETE FROM image_comments WHERE image_id='".$image_id."'", 1);
 $db->my_sql("DELETE FROM picscom_notification WHERE not_id='".$image_id."'", 1);
 
      $response["success"] = 1;
	  $response["count"] = 1;
      $response["message"] = "photo deleted successfully";

 return $response;	 
 }


function update_profile_photo($user_id, $image_id){
	$db = $this->registry->getObject('database');
	
	//get ex profile image and turn active to zero before we replace with new 
	$db->my_sql("SELECT image_id FROM image WHERE matric='".$user_id."' AND active='1'");
	foreach($db->get_rows() as $ex){
	$eximgid= $ex['image_id'];
	}
	// delete its comments too
	// if found, replace active to zero
	$db->my_sql("UPDATE image SET active='4' WHERE image_id='".$eximgid."'", 1);

	$db->my_sql("UPDATE image SET active='1' WHERE image_id='".$image_id."'", 1);
	$relalert = "new profile photo";
	$via = "profile photo";
$db->my_sql("DELETE FROM shout WHERE matric='".$user_id."' AND shouting='".$relalert."'", 1);
$db->my_sql("INSERT INTO shout (matric, shouting, time, active, via) VALUES ('".$user_id."', '".$relalert."', now(), '2', '".$via."')", 1);


      $response["success"] = 1;
	  $response["count"] = 1;
      $response["message"] = "profile photo changed successfully";

 return $response;	    
}


function update_photo_caption($user_id, $image_id, $caption){
	  $db = $this->registry->getObject('database');
	  
	  $db->my_sql("UPDATE image SET caption='$caption' WHERE image_id='".$image_id."' AND matric='".$user_id."'", 1);
	  
	  $response["success"] = 1;
	  $response["count"] = 1;
      $response["message"] = "caption edited successfully";
	
return $response;	 
 }
 
 
 function update_cover_photo($user_id, $image_name){
	$db = $this->registry->getObject('database');
	
	//get ex profile image and turn active to zero before we replace with new 
	$db->my_sql("SELECT id FROM cover_photo WHERE image_name='".$name."' AND matric='".$user_id."'");
	if($db->num_rows() == 1){
	$db->my_sql("UPDATE cover_photo SET active='0' WHERE active='1' AND matric='".$user_id."'", 1);
	$db->my_sql("UPDATE cover_photo SET active='1' WHERE image_name='".$name."' AND matric='".$user_id."'", 1);
	}else{ 
	// inserting those default cover
	$db->my_sql("UPDATE cover_photo SET active='0' WHERE active='1' AND matric='".$user_id."'", 1);
	 $db->my_sql("INSERT INTO cover_photo (matric, image_name, image_date, active) 
	 VALUES ('".$_SESSION['matric']."', '".$name."', now(), '1')", 1);
			}
			
			
      $response["success"] = 1;
	  $response["count"] = 1;
      $response["message"] = "cover photo changed successfully";
	
return $response;	 
 
}


function photo_info($image_id){
	$db = $this->registry->getObject('database');
	
	// get image_id and owner
$db->my_sql("SELECT image_id, matric, image_name, rate, active, privacy, DATE_FORMAT(image_date, '%b %e %Y at %r') AS fmt_image_date, caption FROM image WHERE image_id='".$image_id."'");

if($db->num_rows() == 0){
	$response["success"] = 0;
	  $response["count"] = $db->num_rows();
      $response["message"] = "photo does not exist";
}else{

      $response["success"] = 1;
	  $response["count"] = $db->num_rows();
      $response["photo_info"] = $db->get_rows();
}
	
return $response;

}


function photo_nav($image_id){
	$db = $this->registry->getObject('database');
	$photo = $this->registry->getObject('photo_class');
	
	
	$photo_info_response = $photo->photo_info($image_id);
	foreach($photo_info_response["photo_info"] as $p){
	$owner = $p["matric"];
	$active = $p["active"];
	}
	
	// for next and previous
	if($active == 1 || $active == 4){
		$act = "(active='1' OR active='4')";
	}else{
		$act = "active='3'";
	}
	
	$db->my_sql("SELECT image_id FROM image WHERE image_id > ".$image_id." AND matric='".$owner."' AND $act ORDER BY image_id DESC");  // next
	$nexcount = $db->num_rows();
	
	foreach($db->get_rows() as $n){
	$next = $n['image_id'];
	}
	
	$db->my_sql("SELECT image_id FROM image WHERE image_id < ".$image_id." AND matric='".$owner."' AND $act ORDER BY image_id ASC");
	$prevcount = $db->num_rows();
	
	foreach($db->get_rows() as $p){
	$prev = $p['image_id'];
	}
	
	 $response["next_count"] = $nexcount;
	 $response["next_id"] = $next;
	 $response["previous_count"] = $prevcount;
	 $response["previous_id"] = $prev;
		
	return $response;
	
}
 
 
 

function photo($property){
	 return $this->$property;
 }

}
?>
