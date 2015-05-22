<?php
class forum_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
 
function create_topic($user_id, $title, $body, $category, $photo_type, $photo_error, $photo_size, $photo_name, $photo_tmp){
	 $db = $this->registry->getObject('database');
	 $photo = $this->registry->getObject('photo_class');
	 
	 if((empty($title)) || (empty($body)) || (empty($category))){ // empty fields, cannot post the topic
		 
	$response["success"] = 0;
	$response["count"] = 0;
    $response["message"] = "error creating topic";
		 
	 }else{
		 
		//create and issue the first query
  $db->my_sql("INSERT INTO forum_topics (cat_id, topic_title, topic_create_time, topic_owner, views) VALUES ('".$category."', '".strtolower($title)."',now(),'".$user_id."','0')", 1);
 //get the id of the last query
  $topic_id = $db->last_id();
  
   //create and issue the second query
 $db->my_sql("INSERT INTO forum_posts (topic_id, post_text, post_create_time, post_owner, cat_id) VALUES ('".$topic_id."','".$body."', now(),'".$user_id."','".$category."')", 1);
 
 //create and issue the pics query
if ($photo_tmp != "") {  
$photo->upload_photo($topic_id, $photo_type, $photo_error, $photo_size, $photo_name, $photo_tmp, $caption, "forum", $album_name, $privacy);
}else{
}

    $title_link = str_replace(" ", "-", $title);

    $response["success"] = 1;
	$response["count"] = 1;
    $response["message"] = "topic created successfully <a href='".HUB_URL.$title_link."' style='color:blue; font-weight:bold'>view post</a>";
   
	 }
	 
	 return $response; 
}


function user_topics($admin, $ext, $page){
	$db = $this->registry->getObject('database');
	$user =  $this->registry->getObject('user_class');
	
	
// gets admin ID from the user table
$user_response = $user->profile_info($admin);
$admin_id = $user_response["user_id"];

	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT topic_id FROM forum_topics WHERE topic_owner='".$admin_id."' ORDER BY topic_create_time DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT topic_id FROM forum_topics WHERE topic_owner='".$admin_id."' ORDER BY topic_create_time DESC $limit");
	
	if($db->num_rows() == 0){
	   $response["success"] = 0;
	   $response["count"] = 0;
       $response["message"] = "no topic found";
	}else{
	   $response["success"] = 1;
	   $response["count"] = $db->num_rows();
	   $response["topics"] = $db->get_rows();	 
	}
	
	 return $response; 
}



function topic_listing($cat_id, $ext, $page){
	$db = $this->registry->getObject('database');
	
	if($cat_id == ""){
		$where = "";
	}elseif(!is_numeric($cat_id)){
		$cat_id = str_replace("-", " ", $cat_id);
		
    //case of a category as the search query
		$db->my_sql("SELECT cat_id FROM forum_cat WHERE cat_type LIKE '".$cat_id."%'");
		foreach($db->get_rows() as $c){
			$category_id = $c['cat_id'];
		}
		
		if($db->num_rows() == 0){
		$where = "WHERE topic_title LIKE '%".$cat_id."%'";
		}else{
		$where = "WHERE cat_id='".$category_id."'";
		}
		
	}else{
		$where = "WHERE cat_id='".$cat_id."'";
	}
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT topic_id FROM forum_topics $where ORDER BY topic_create_time DESC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT topic_id FROM forum_topics $where ORDER BY topic_create_time DESC $limit");
	
	if($db->num_rows() == 0){
	   $response["success"] = 0;
	   $response["count"] = 0;
       $response["message"] = "no topic found";
	}else{
	   $response["success"] = 1;
	   $response["count"] = $db->num_rows();
	   $response["topics"] = $db->get_rows();	 
	}
	
	 return $response; 
}


function topic_info($topic_id){
	$db = $this->registry->getObject('database');
	$photo = $this->registry->getObject('photo_class');
	
	$db->my_sql("SELECT post_text FROM forum_posts WHERE topic_id='".$topic_id."' ORDER BY post_id DESC");
	
	if($db->num_rows() == 0){
	   $response["success"] = 0;
	   $response["count"] = 0;
       $response["message"] = "invalid topic selected";
	}else{
		
	foreach($db->get_rows() as $t){
		$forum_posts = $t['post_text'];
	}
	
	$photo_response = $photo->get_photos($topic_id, "forum");
	
	$forum_pics = $photo_response['image_link'];
	$forum_ext_pics = $photo_response['image_ext_link'];
	
	$db->my_sql("SELECT topic_id, cat_id, topic_title, DATE_FORMAT(topic_create_time,  '%b %e %Y at %r') AS fmt_topic_create_time, topic_owner, views FROM forum_topics WHERE topic_id='".$topic_id."'");
	
	foreach($db->get_rows() as $t){
		$topic_id = $t['topic_id'];
		$cat_id = $t['cat_id'];
		$topic_title = $t['topic_title'];
		$topic_time = $t['fmt_topic_create_time'];
		$topic_owner = $t['topic_owner'];
		$topic_views = $t['views'];
	}
	
	//get cat name
	$db->my_sql("SELECT cat_type FROM forum_cat WHERE cat_id='".$cat_id."'");
	foreach($db->get_rows() as $c){
		$cat_name = $c['cat_type'];
	}
	
	$response["success"] = 1;
	$response["count"] = 1;
	$response["topic_post"] = $forum_posts;
	$response["topic_photo"] = $forum_pics;
	$response["topic_ext_photo"] = $forum_ext_pics;
	$response["topic_id"] = $topic_id;
	$response["topic_title"] = $topic_title;
	$response["topic_cat_id"] = $cat_id;
	$response["topic_cat_name"] = $cat_name;
	$response["topic_owner"] = $topic_owner;
	$response["topic_time"] = $topic_time;
	$response["topic_views"] = $topic_views;
	$response["topic_link"] = str_replace(" ", "-", $response["topic_title"]).".html";
	
	}
	
	
   return $response; 
	
	
}







function topic_view($title){
	$db = $this->registry->getObject('database');
	$forum = $this->registry->getObject('forum_class');
	
	$title = str_replace("-", " ", $title);
	
	$db->my_sql("SELECT topic_id FROM forum_topics WHERE topic_title LIKE '%".$title."%'");
	
	if($db->num_rows() == 0){
	   $response["success"] = 0;
	   $response["count"] = 0;
       $response["message"] = "invalid topic selected";
	}else{
		
	foreach($db->get_rows() as $t){
		$topic_id = $t['topic_id'];	
	}
	
	
	$forum_response = $forum->topic_info($topic_id);
	
	$cat_id = $forum_response['topic_cat_id'];
	$cat_name = $forum_response['topic_cat_name'];
	$topic_title = $forum_response['topic_title'];
	$topic_time = $forum_response['topic_time'];
	$topic_owner = $forum_response['topic_owner'];
	$topic_views = $forum_response['topic_views'];
	$forum_posts = $forum_response["topic_post"];
	$forum_pics = $forum_response["topic_photo"];
	$forum_ext_pics = $forum_response["topic_ext_photo"];
	
	
	
	
	$response["success"] = 1;
	$response["count"] = 1;
	$response["topic_id"] = $topic_id;
	$response["topic_title"] = $topic_title;
	$response["topic_cat_id"] = $cat_id;
	$response["topic_cat_name"] = $cat_name;
	$response["topic_post"] = $forum_posts;
	$response["topic_photo"] = $forum_pics;
	$response["topic_ext_photo"] = $forum_ext_pics;
	$response["topic_owner"] = $topic_owner;
	$response["topic_time"] = $topic_time;
	$response["topic_views"] = $topic_views;
	
	}
	
   return $response; 	
}


function update_topic($topic_id, $cat_id, $topic_title, $topic_views, $topic_posts, $topic_photo, $ext_topic_photo){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("UPDATE forum_topics SET cat_id='$cat_id', topic_title='$topic_title', views='$topic_views' WHERE topic_id='".$topic_id."'", 1);
	
	$db->my_sql("UPDATE forum_posts SET cat_id='$cat_id', post_text='$topic_posts' WHERE topic_id='".$topic_id."' AND cat_id NOT LIKE '0'", 1);
	
	// check if a photo is already in existence
	$db->my_sql("SELECT id FROM forum_pics WHERE topic_id='".$topic_id."'");
	if($db->num_rows() == 0){
		$db->my_sql("INSERT INTO forum_pics (topic_id, image_name, image_link) VALUES ('".$topic_id."', '".$topic_photo."', '".$ext_topic_photo."')");	
	}else{
	$db->my_sql("UPDATE forum_pics SET image_name='$topic_photo', image_link='$ext_topic_photo' WHERE topic_id='".$topic_id."'", 1);
	}
	
	 $title_link = str_replace(" ", "-", $topic_title);

    $response["success"] = 1;
	$response["count"] = 1;
    $response["message"] = "topic updated successfully <a href='".HUB_URL.$title_link."' style='color:blue; font-weight:bold'>view post</a>";
	
		
   return $response; 
	
}


function comment_post($user_id, $title, $comment){
	$db = $this->registry->getObject('database');
	$forum = $this->registry->getObject('forum_class');
	
	if($comment == ""){
	 $response["success"] = 0;
	 $response["count"] = 0;
     $response["message"] = "error posting comment";
	}else{
	
	//get topic_id
	$forum_response = $forum->topic_view($title);
	$topic_id = $forum_response["topic_id"];
	
	 //add the post
 $db->my_sql("INSERT INTO forum_posts (topic_id, post_text, post_create_time, post_owner) VALUES 
 ('".$topic_id."', '".$comment."', now(), '".$user_id."')", 1);
 
     $response["success"] = 1;
	 $response["count"] = 1;
     $response["message"] = "comment posted successfully";
	}
	 
	 return $response;	
}


function post_comments($title, $ext, $page){
	$db = $this->registry->getObject('database');
	$forum = $this->registry->getObject('forum_class');
	
	//get topic_id
	$forum_response = $forum->topic_view($title);
	$topic_id = $forum_response["topic_id"];
	
	if($page != ""){
	     $var = explode("=", $page);
		 $page_num = $var[1];
		 $end = $page_num * PAG;
		 $start = $end - PAG;
		 
		 $limit = "LIMIT $start, $end";
	}
	
	$db->my_sql("SELECT post_id, topic_id, cat_id, post_text, DATE_FORMAT(post_create_time, '%b %e %Y at %r') AS fmt_post_create_time, post_owner, active FROM forum_posts WHERE topic_id ='".$topic_id."' AND cat_id='0' ORDER BY post_create_time ASC");
	$response["all_count"] = $db->num_rows();
	
	$db->my_sql("SELECT post_id, topic_id, cat_id, post_text, DATE_FORMAT(post_create_time, '%b %e %Y at %r') AS fmt_post_create_time, post_owner, active FROM forum_posts WHERE topic_id ='".$topic_id."' AND cat_id='0' ORDER BY post_create_time ASC $limit");
	
	
	if($db->num_rows() == 0){
	   $response["success"] = 0;
	   $response["count"] = 0;
       $response["message"] = "no comment found";
	}else{
	   $response["success"] = 1;
	   $response["count"] = $db->num_rows();
	   $response["comments"] = $db->get_rows();	 
	}
	
	 return $response;
	
}


function delete_post($post_id){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("DELETE FROM forum_topics WHERE topic_id='".$post_id."'", 1);
	$db->my_sql("DELETE FROM forum_posts WHERE topic_id='".$post_id."'", 1);
	
	   $response["success"] = 1;
	   $response["count"] = 1;
       $response["message"] = "post deleted successfully";
	   
	   return $response;
}


function delete_comment($comment_id){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("DELETE FROM forum_posts WHERE post_id='".$comment_id."'", 1);
	
	   $response["success"] = 1;
	   $response["count"] = 1;
       $response["message"] = "comment deleted successfully";
	   
	   return $response;
}

function forum_cats(){
	$db = $this->registry->getObject('database');
	
	//get cat name
	$db->my_sql("SELECT * FROM forum_cat ORDER BY cat_type ASC");

	   $response["success"] = 1;
	   $response["count"] = $db->num_rows();
	   $response["forum_cats"] = $db->get_rows();	 
	
	 return $response;
}



function forum($property){
	 return $this->$property;
 }

}
?>
