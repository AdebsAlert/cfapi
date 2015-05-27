<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * You are hereby granted a non-exclusive, worldwide, royalty-free license to
  * use, copy, modify, and distribute this software in source code or binary
  * form for use in connection with the web services and APIs provided by
  * Campusfamz.
  *
  * Class Functions
  * List of all functions accessible by all APIs
  * Usage : Software for CF Engineers and other APIs
  * to build on the main infastructure  
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com> 
  *
*/

class Functions {
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 
	 $this->registry = $registry;
}
 

function model($app_id, $action, $function, $param, $ext, $page){
	   $this->$function($param, $ext, $page);
}

function user_login($param1, $param2){
	$auth = $this->registry->getObject('auth_class');
	$user = $this->registry->getObject('user_class');
	
	$username = $auth->filter_data($param1);
	$password = $auth->filter_data($param2);
	
	$response = $user->user_login($username, $password);
	exit(json_encode($response));	
}


function retrieve_password($param){
	$auth = $this->registry->getObject('auth_class');
    $user = $this->registry->getObject('user_class');
	
	$email = $auth->filter_data($param);
	
	$response = $user->retrieve_password($email);
	exit(json_encode($response));	
}


function subscribe_user($param){
	$auth = $this->registry->getObject('auth_class');
    $user = $this->registry->getObject('user_class');
	
	$email = $auth->filter_data($_POST['email']);
	
	$response = $user->subscribe_user($email);
	exit(json_encode($response));
}

function user_reg($param){
	$auth = $this->registry->getObject('auth_class');
	$user = $this->registry->getObject('user_class');
	
	$fullname = $auth->filter_data($_POST['fullname']);
	$email = $auth->filter_data($_POST['email']);
	$username = $auth->filter_data($_POST['username']);
	$password = $auth->filter_data($_POST['password']);
	$re_password = $auth->filter_data($_POST['re-password']);
	$birthday = $auth->filter_data($_POST['birthday']);
	$birthmonth = $auth->filter_data($_POST['birthmonth']);
	$birthyear = $auth->filter_data($_POST['birthyear']);
	$sex = $auth->filter_data($_POST['sex']);
	$country = $auth->filter_data($_POST['country']);
	$phone = $auth->filter_data($_POST['phone']);
	$verification = $auth->filter_data($_POST['verification']);
		
    $response = $user->user_reg($fullname, $email, $username, $password, $re_password, $birthday, $birthmonth, $birthyear, $sex, $country, $phone, $verification);
		
	exit(json_encode($response));	
}


function friend_list($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->friend_list($param, $ext, $page);
	exit(json_encode($response));
	
}


function profile_info($param){
	$user = $this->registry->getObject('user_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	
	$response = $user->profile_info($param);
	exit(json_encode($response));
	
}


function famz_list($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->famz_list($param, $ext, $page);
	exit(json_encode($response));
	
}


function famzer_list($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->famzer_list($param, $ext, $page);
	exit(json_encode($response));
	
}


function profile_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	
	$response = $photo->profile_photo($param);
	exit(json_encode($response));
}


function all_photo($param, $ext, $page){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $photo->all_photo($param, $ext, $page);
	exit(json_encode($response));
}


function cover_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	
	$response = $photo->cover_photo($param);
	exit(json_encode($response));
}


function add_friend($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$friend_id = $auth->filter_data($_POST['friend_id']);
	
	$response = $friend->add_friend($user_id, $friend_id);
	exit(json_encode($response));
}


function famz_friend($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$friend_id = $auth->filter_data($_POST['friend_id']);
	
	$response = $friend->famz_friend($user_id, $friend_id);
	exit(json_encode($response));
}

function unfamz_friend(){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$friend_id = $auth->filter_data($_POST['friend_id']);
	
	$response = $friend->unfamz_friend($user_id, $friend_id);
	exit(json_encode($response));
}


function unfriend_friend($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$friend_id = $auth->filter_data($_POST['friend_id']);
	
	$response = $friend->unfriend_friend($user_id, $friend_id);
	exit(json_encode($response));
}


function accept_friend($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$friend_id = $auth->filter_data($_POST['friend_id']);
	
	$response = $friend->accept_friend($user_id, $friend_id);
	exit(json_encode($response));
}


function reject_friend($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$friend_id = $auth->filter_data($_POST['friend_id']);
	
	$response = $friend->reject_friend($user_id, $friend_id);
	exit(json_encode($response));
}


function pend_list($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->pend_list($param, $ext, $page);
	exit(json_encode($response));
	
}

function pending_requests($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->pending_requests($param, $ext, $page);
	exit(json_encode($response));
	
}

function block_list($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->block_list($param, $ext, $page);
	exit(json_encode($response));
	
}


function unblock_friend($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$friend_id = $auth->filter_data($_POST['friend_id']);
	
	$response = $friend->unblock_friend($user_id, $friend_id);
	exit(json_encode($response));
}


function friend_suggestion($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->friend_suggestion($param, $ext, $page);
	exit(json_encode($response));
	
}


function user_network($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	
	$response = $friend->user_network($param);
	exit(json_encode($response));
	
}


function mutual_friends($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$friend_id = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->mutual_friends($user_id, $friend_id, $page);
	exit(json_encode($response));
}


function check_friend($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	
	$response = $friend->check_friend($param);
	exit(json_encode($response));
}

function check_famz($param){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	
	$response = $friend->check_famz($param);
	exit(json_encode($response));
}


function friend_requests($param, $ext, $page){
	$friend = $this->registry->getObject('friend_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $friend->friend_requests($param, $ext, $page);
	exit(json_encode($response));
}


function user_list($param, $ext, $page){
	$search = $this->registry->getObject('search_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$criteria = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $search->user_list($user_id, $criteria, $page);
	exit(json_encode($response));
}


function search_user($param, $ext, $page){
	$search = $this->registry->getObject('search_class');
	$auth = $this->registry->getObject('auth_class');
	
	$query = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $search->search_user($query, $ext, $page);
	exit(json_encode($response));
}



function send_shout($param){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$shout = $auth->filter_data($_POST['shout']);
	$privacy = $auth->filter_data($_POST['privacy']);
	
	$response = $feed->send_shout($user_id, $shout, $privacy);
	exit(json_encode($response));
}


function user_shout($param, $ext, $page){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $feed->user_shout($param, $ext, $page);
	exit(json_encode($response));
}

function all_shout($param, $ext, $page){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param1 = $auth->filter_data($param);
	$param2 = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $feed->all_shout($param1, $param2, $page);
	exit(json_encode($response));	
}


function like_shout($param){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$shout = $auth->filter_data($_POST['shout_id']);
	
	$response = $feed->like_shout($user_id, $shout);
	exit(json_encode($response));
}


function unlike_status($param){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$shout = $auth->filter_data($_POST['shout_id']);
	
	$response = $feed->unlike_shout($user_id, $shout);
	exit(json_encode($response));
}

function delete_status($param){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$shout = $auth->filter_data($_POST['shout_id']);
	
	$response = $feed->delete_shout($shout);
	exit(json_encode($response));
}


function share_status($param){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$shout = $auth->filter_data($_POST['shout_id']);
	
	$response = $feed->share_shout($user_id, $shout);
	exit(json_encode($response));
}


function comment_shout($param){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$shout_id = $auth->filter_data($_POST['shout_id']);
	$comment = $auth->filter_data($_POST['comment']);
	
	$response = $feed->comment_shout($user_id, $shout_id, $comment);
	exit(json_encode($response));
}


function delete_shout_comment($param){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$comment_id = $auth->filter_data($_POST['comment_id']);
	
	$response = $feed->delete_shout_comment($comment_id);
	exit(json_encode($response));
}


function shout_comment($param, $ext, $page){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $feed->shout_comment($param, $ext, $page);
	exit(json_encode($response));
}


function report_shout($param){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$shout_id = $auth->filter_data($_POST['shout_id']);
	$report = $auth->filter_data($_POST['report']);
	
	$response = $feed->report_shout($user_id, $shout_id, $report);
	exit(json_encode($response));	
}


function shout_liker($param, $ext, $page){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $feed->shout_liker($param, $ext, $page);
	exit(json_encode($response));	
}


function view_shout($param, $ext){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param1 = $auth->filter_data($param);
	$param2 = $auth->filter_data($ext);
	
	$response = $feed->view_shout($param1, $param2);
	exit(json_encode($response));
}



function trend_shout($param, $ext, $page){
	$feed = $this->registry->getObject('feed_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $feed->trend_shout($param, $ext, $page);
	exit(json_encode($response));
	
}


function upload_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$type = $auth->filter_data($_POST['type']);
	$error = $auth->filter_data($_POST['error']);
	$size = $auth->filter_data($_POST['size']);
	$name = $auth->filter_data($_POST['name']);
	$tmp = $auth->filter_data($_POST['tmp_name']);
	$caption = $auth->filter_data($_POST['caption']);
	$loc = $auth->filter_data($_POST['location']);
	$album_name = $auth->filter_data($_POST['album_name']);
	$privacy = $auth->filter_data($_POST['privacy']);
	
	$response = $photo->upload_photo($user_id, $type, $error, $size, $name, $tmp, $caption, $loc, $album_name, $privacy);
	
	exit(json_encode($response));
}


function rate_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$image_id = $auth->filter_data($_POST['image_id']);
	$rating = $auth->filter_data($_POST['rating']);
	
	$response = $photo->rate_photo($user_id, $image_id, $rating);
	exit(json_encode($response));	
}


function get_photos($param, $ext, $page){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$folder = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $photo->get_photos($user_id, $folder, $page);
	exit(json_encode($response));
}


function view_photo($param, $ext){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$photo_id = $auth->filter_data($param);
	$folder = $auth->filter_data($ext);
	
	$response = $photo->view_photo($photo_id, $folder);
	exit(json_encode($response));
}


function photo_comments($param, $ext, $page){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$param = $auth->filter_data($param); 
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $photo->photo_comments($param, $ext, $page);
	exit(json_encode($response));
}

function delete_photo_comment($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$comment_id = $auth->filter_data($param);
	$response = $photo->delete_photo_comment($comment_id);
	exit(json_encode($response));	
}


function comment_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$image_id = $auth->filter_data($param);
	$comment = $auth->filter_data($_POST['comment']);
	
	$response = $photo->comment_photo($image_id, $user_id, $comment);
	exit(json_encode($response));
}


function update_photo_caption($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$image_id = $auth->filter_data($param);
	$caption = $auth->filter_data($_POST['caption']);
	
	$response = $photo->update_photo_caption($user_id, $image_id, $caption);
	exit(json_encode($response));
}

function update_cover_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$image_name = $auth->filter_data($_POST['image_name']);
	
	$response = $photo->update_cover_photo($user_id, $image_name);
	exit(json_encode($response));
}


function update_profile_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$image_id = $auth->filter_data($_POST['image_id']);
	
	$response = $photo->update_profile_photo($user_id, $image_id);
	exit(json_encode($response));
}


function report_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$image_id = $auth->filter_data($param);
	$report = $auth->filter_data($_POST['report']);
	
	$response = $photo->report_photo($user_id, $image_id, $report);
	exit(json_encode($response));
	
}


function delete_photo($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$image_id = $auth->filter_data($param);

	$response = $photo->delete_photo($image_id);
	exit(json_encode($response));
	
}


function photo_info($param){
	$photo = $this->registry->getObject('photo_class');
	$auth = $this->registry->getObject('auth_class');
	
	$image_id = $auth->filter_data($param);

	$response = $photo->photo_info($image_id);
	exit(json_encode($response));
	
}



function send_message($param){
	$message = $this->registry->getObject('message_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$message_to = $auth->filter_data($param);
	$message = $auth->filter_data($_POST['message']);

	$response = $message->send_message($user_id, $message_to, $message);
	exit(json_encode($response));
	
}


function read_message($param, $ext, $page){
	$message = $this->registry->getObject('message_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$message_id = $auth->filter_data($page);

	$response = $message->read_message($message_id, $user_id);
	exit(json_encode($response));
	
}


function message_list($param, $ext, $page){
	$message = $this->registry->getObject('message_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);

	$response = $message->message_list($user_id, $ext, $page);
	exit(json_encode($response));
	
}


function check_admin($param){
	$admin = $this->registry->getObject('admin_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);

	$response = $admin->check_admin($user_id);
	exit(json_encode($response));
	
}


function create_admin($param){
	$admin = $this->registry->getObject('admin_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$user_role = $auth->filter_data($_POST['user_role']);
	
	$response = $admin->create_admin($user_id, $user_role);
	exit(json_encode($response));
	
}


function create_topic($param){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	$title = $auth->filter_data($_POST['title']);
	$body = $auth->filter_data($_POST['body']);
	$category = $auth->filter_data($_POST['category']);
	$photo_type = $auth->filter_data($_POST['photo_type']);
	$photo_error = $auth->filter_data($_POST['photo_error']);
	$photo_size = $auth->filter_data($_POST['photo_size']);
	$photo_name = $auth->filter_data($_POST['photo_name']);
	$photo_tmp = $auth->filter_data($_POST['photo_tmp']);
	
	$response = $forum->create_topic($user_id, $title, $body, $category, $photo_type, $photo_error, $photo_size, $photo_name, $photo_tmp);
	exit(json_encode($response));
	
}


function topic_listing($param, $ext, $page){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$cat_id = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $forum->topic_listing($cat_id, $ext, $page);
	exit(json_encode($response));
}


function user_topics($param, $ext, $page){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$admin = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	$response = $forum->user_topics($admin, $ext, $page);
	exit(json_encode($response));
}




function topic_info($param){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$topic_id = $auth->filter_data($param);
	
	$response = $forum->topic_info($topic_id);
	exit(json_encode($response));
}



function topic_view($param){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$title = $auth->filter_data($param);
	
	$response = $forum->topic_view($title);
	exit(json_encode($response));
}


function update_topic($param, $put_vars){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	
	$topic_id = $auth->filter_data($param);
	$cat_id = $auth->filter_data($put_vars['cat_id']);
	$topic_title = $auth->filter_data($put_vars['topic_title']);
	$topic_views = $auth->filter_data($put_vars['topic_views']);
	$topic_posts = $auth->filter_data($put_vars['topic_posts']);
	$topic_photo = $auth->filter_data($put_vars['topic_photo']);
	$ext_topic_photo = $auth->filter_data($put_vars['ext_topic_photo']);
	
	$response = $forum->update_topic($topic_id, $cat_id, $topic_title, $topic_views, $topic_posts, $topic_photo, $ext_topic_photo);
	exit(json_encode($response));
}


function comment_forum($param){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($_POST['user_id']);
	$title = $auth->filter_data($param);
	$comment = $auth->filter_data($_POST['comment']);
	
	$response = $forum->comment_post($user_id, $title, $comment);
	exit(json_encode($response));
}


function forum_comments($param, $ext, $page){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$title = $auth->filter_data($param);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);

	$response = $forum->post_comments($title, $ext, $page);
	exit(json_encode($response));
}


function delete_forum_post($param){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$post_id = $auth->filter_data($param);
	
	$response = $forum->delete_post($post_id);
	exit(json_encode($response));	
}


function delete_forum_comment($param){
	$forum = $this->registry->getObject('forum_class');
	$auth = $this->registry->getObject('auth_class');
	
	$comment_id = $auth->filter_data($param);
	
	$response = $forum->delete_comment($comment_id);
	exit(json_encode($response));	
}


function forum_cats(){
	$forum = $this->registry->getObject('forum_class');
	
	$response = $forum->forum_cats();
	exit(json_encode($response));
}



function upload_slide($param){
	$slide = $this->registry->getObject('slide_class');
	$auth = $this->registry->getObject('auth_class');
	
	$file_tmp = $auth->filter_data($_POST['file_tmp']);
	$file_name = $auth->filter_data($_POST['file_name']);
	$slide_id = $auth->filter_data($_POST['slide_id']);
	$user_id = $auth->filter_data($param);
	$file_id = $auth->filter_data($_POST['file_id']);
	
	$response = $slide->upload_slide($file_tmp, $file_name, $slide_id, $user_id, $file_id);
	exit(json_encode($response));
	
}

function update_slide($param){
	$slide = $this->registry->getObject('slide_class');
	$auth = $this->registry->getObject('auth_class');
	
	$desc = $auth->filter_data($_POST['desc']);
	$slide_id = $auth->filter_data($param);
	
	$response = $slide->update_slide($desc, $slide_id);
	exit(json_encode($response));
	
}

function slide_info($param){
	$slide = $this->registry->getObject('slide_class');
	$auth = $this->registry->getObject('auth_class');
	
	$slide_id = $auth->filter_data($param);
	$response = $slide->slide_info($slide_id);
	exit(json_encode($response));	
}


function registerDev($param){
	$developer = $this->registry->getObject('developer_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	
	$response = $developer->registerDev($user_id);
	exit(json_encode($response));
}


function getDev($param){
	$developer = $this->registry->getObject('developer_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	
	$response = $developer->getDev($user_id);
	exit(json_encode($response));
}


function retrieveDev($param){
	$developer = $this->registry->getObject('developer_class');
	$auth = $this->registry->getObject('auth_class');
	
	$user_id = $auth->filter_data($param);
	
	$response = $developer->retrieveDev($user_id);
	exit(json_encode($response));
}


}
?>
