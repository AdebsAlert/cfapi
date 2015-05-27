<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * You are hereby granted a non-exclusive, worldwide, royalty-free license to
  * use, copy, modify, and distribute this software in source code or binary
  * form for use in connection with the web services and APIs provided by
  * Campusfamz.
  *
  * Class Campusfamz
  * API Type : Campusfamz
  * Usage : Software for CF Engineers
  * to build on the main infastructure  
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com> 
  *
*/

class Campusfamz {
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
}
 

function model($app_id, $action, $function, $param, $ext, $page){
	   $this->$function($action, $param, $ext, $page);
}


function login($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		$functions->user_login($param, $ext);
		break;
	case 'POST':
	    $ErrorParser->invalid_method();
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}


function signup($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		$ErrorParser->invalid_method();
		break;
	case 'POST':
	    $functions->user_reg($param);
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}


function profiles($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == ''){
		       $functions->profile_info($param);
			   exit();
		}elseif($ext == "password"){
		       $functions->retrieve_password($param);
			   exit();
		}else{
			
		}
		break;
	case 'POST':
	    $ErrorParser->invalid_method();
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
	
}


function users($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == ''){
		      
		}elseif($ext == "suggestion"){
		       $functions->friend_suggestion($param, $ext, $page);
			   exit();
		}elseif($ext == "network"){
		       $functions->user_network($param);
			   exit();
		}else{
			   $functions->user_list($param, $ext, $page);
			   exit();
		}
		break;
	case 'POST':
	    if($ext == ''){
		      
		}elseif($ext == "subscribe"){
		       $functions->subscribe_user($param);
			   exit();
		}else{
			
		}
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}



function search($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == ''){
		       $functions->search_user($param, $ext, $page);
			   exit();
		}else{
			   $functions->search_user($param, $ext, $page);
			   exit();
		}
		break;
	case 'POST':
	    $ErrorParser->invalid_method();
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}


function friends($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == ''){
		       $functions->friend_list($param, $ext, $page);
			   exit();
		}elseif($ext == "friend"){
		       $functions->friend_list($param, $ext, $page);
			   exit();
		}elseif($ext == "famzer"){
		       $functions->famzer_list($param, $ext, $page);
			   exit();
		}elseif($ext == "famzing"){
		       $functions->famz_list($param, $ext, $page);
			   exit();
		}elseif($ext == "blocked"){
		       $functions->block_list($param, $ext, $page);
			   exit();
		}elseif($ext == "mutual"){
		       $functions->mutual_friends($param, $ext, $page);
			   exit();
		}else{	
		}
		break;
	case 'POST':
	    $functions->famz_friend($param);
		break;	
	case 'PUT':
	    $functions->unblock_friend($param);
		break;
	case 'DELETE':
	    $functions->unfamz_friend($param);
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}


function photos($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == 'dp'){
		       $functions->profile_photo($param);
			   exit();
		}elseif($ext == "all"){
		       $functions->all_photo($param, $ext, $page);
			   exit();
		}elseif($ext == "cover"){
		       $functions->cover_photo($param);
			   exit();
		}elseif($ext == "comment"){
		       $functions->photo_comments($param, $ext, $page);
			   exit();
		}elseif($ext == "info"){
		       $functions->photo_info($param);
			   exit();
		}elseif($page == ""){
		        $functions->view_photo($param, $ext);
				exit();
		}else{
			   $functions->get_photos($param, $ext, $page);
			   exit();
		}
		break;
	case 'POST':
	    if($ext == ''){
		      $functions->upload_photo($param);
			  exit();
		}elseif($ext == 'rate'){
			  $functions->rate_photo($param);
			  exit();
		}elseif($ext == 'comment'){
			  $functions->comment_photo($param);
			  exit();
		}elseif($ext == 'report'){
			  $functions->report_photo($param);
			  exit();
		}else{
		}
		break;	
	case 'PUT':
	    if($ext == 'caption'){
			  $functions->update_photo_caption($param);
			  exit();
		}elseif($ext == 'cover'){
			  $functions->update_cover_photo($param);
			  exit();
		}elseif($ext == 'dp'){
			  $functions->update_profile_photo($param);
			  exit();
		}else{
		}
		break;
	case 'DELETE':
	    if($ext == 'comment'){
			  $functions->delete_photo_comment($param);
			  exit();
		}elseif($ext == ''){
			  $functions->delete_photo($param);
			  exit();
		}else{
		}
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}



function feeds($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == 'user'){
		       $functions->user_shout($param, $ext, $page);
			   exit();
		}elseif($ext == "comment"){
		       $functions->shout_comment($param, $ext, $page);
			   exit();
		}elseif($ext == "liker"){
		       $functions->shout_liker($param, $ext, $page);
			   exit();
		}elseif($ext == "trend"){
		       $functions->trend_shout($param, $ext, $page);
			   exit();
		}elseif(is_numeric($ext)){
		       $functions->view_shout($param, $ext);
			   exit();
		}else{
			$functions->all_shout($param, $ext, $page);
			exit();
		}
		break;
	case 'POST':
	    if($ext == ''){
		      $functions->send_shout($param);
			  exit();
		}elseif($ext == "like"){
			  $functions->like_shout($param);
			  exit();
		}elseif($ext == "share"){
			  $functions->share_status($param);
			  exit();
		}elseif($ext == "comment"){
			  $functions->comment_shout($param);
			  exit();
		}elseif($ext == "report"){
			  $functions->report_shout($param);
			  exit();
		}else{
		}
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    if($ext == ''){
		      $functions->delete_status($param);
			  exit();
		}elseif($ext == "unlike"){
			  $functions->unlike_shout($param);
			  exit();
		}elseif($ext == "comment"){
			  $functions->delete_shout_comment($param);
			  exit();
		}else{
		}
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}


function messages($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == 'read'){
		       $functions->read_message($param, $ext, $page);
			   exit();
		}elseif($ext == "inbox"){
		       $functions->message_list($param, $ext, $page);
			   exit();
		}else{
			
		}
		break;
	case 'POST':
	    if($ext == 'send'){
		      $functions->send_message($param);
			  exit();
		}else{
		}
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}


function admins($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == 'check'){
		       $functions->check_admin($param);
			   exit();
		}else{
			
		}
		break;
	case 'POST':
	    if($ext == 'create'){
		      $functions->create_admin($param);
			  exit();
		}else{
		}
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}


function forums($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == 'category'){
		       $functions->topic_listing($param, $ext, $page);
			   exit();
		}elseif($ext == 'user'){
			   $functions->user_topics($param, $ext, $page);
			   exit();
		}elseif($ext == 'info'){
			   $functions->topic_info($param);
			   exit();
		}elseif($ext == 'comment'){
			   $functions->forum_comments($param, $ext, $page);
			   exit();
		}elseif($param == 'categories'){
			   $functions->forum_cats();
			   exit();
		}elseif($ext == ''){
			   $functions->topic_view($param);
			   exit();
		}else{
			
		}
		break;
	case 'POST':
	    if($ext == 'create'){
		      $functions->create_topic($param);
			  exit();
		}elseif($ext == 'comment'){
			 $functions->comment_forum($param);
			 exit();
		}else{
			
		}
		break;	
	case 'PUT':
	    if($ext == ''){
		      $functions->update_topic($param);
			 exit();
		}else{
		}
		break;
	case 'DELETE':
	    if($ext == 'forum'){
		      $functions->delete_forum_post($param);
			  exit();
		}elseif($ext == 'comment'){
			 $functions->delete_forum_comment($param);
			 exit();
		}else{
			 $functions->update_topic($param);
			 exit();
		}
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}


function slides($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	
		switch($action){	
	case 'GET':
		if($ext == ''){
			   $functions->slide_info($param);
			   exit();
		}else{
			
		}
		break;
	case 'POST':
	    if($ext == ''){
		      $functions->upload_slide($param);
			  exit();
		}else{
		}
		break;	
	case 'PUT':
	    if($ext == ''){
		      $functions->update_slide($param);
			  exit();
		}else{
		}
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}



function developers($action, $param, $ext, $page){
	$ErrorParser = $this->registry->getObject('ErrorParser');
	$functions = $this->registry->getObject('Functions');
	
	switch($action){	
	case 'GET':
		if($ext == ''){
			   $functions->getDev($param);
			   exit();
		}elseif($ext == 'retrieve'){
			   $functions->retrieveDev($param);
			   exit();
		}else{
			
		}
		break;
	case 'POST':
	    if($ext == ''){
		      $functions->registerDev($param);
			  exit();
		}else{
		}
		break;	
	case 'PUT':
	    $ErrorParser->invalid_method();
		break;
	case 'DELETE':
	    $ErrorParser->invalid_method();
		break;
	default:
	     $ErrorParser->invalid_method();
		break;
	}
}

}
?>
