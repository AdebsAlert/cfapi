<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * You are hereby granted a non-exclusive, worldwide, royalty-free license to
  * use, copy, modify, and distribute this software in source code or binary
  * form for use in connection with the web services and APIs provided by
  * Campusfamz.
  *
  * Class CampusfamzAuth
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com> 
  *
  * Filters, check and routes api requests from users  
*/
	
class CampusfamzAuth {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function model($action, $version, $method, $param, $appID, $appKey, $ext, $page){
	$db = $this->registry->getObject('database');
	$auth = $this->registry->getObject('auth_class');
	
	// clean and filter the datas sent
	$action = $auth->filter_data($action);
	$version = $auth->filter_data($version);
	$method = $auth->filter_data($method);
	$param = $auth->filter_data($param);
	$appID = $auth->filter_data($appID);
	$appKey = $auth->filter_data($appKey);
	$ext = $auth->filter_data($ext);
	$page = $auth->filter_data($page);
	
	
	$db->my_sql("SELECT id FROM developers WHERE developer_id='".$appID."' AND developer_key='".$appKey."'");
	if($db->num_rows() == 0){
		$this->unauthorized_url(); // call connection error
	}else{
		
	$db->my_sql("SELECT id, app_name, app_type, active FROM applications WHERE developer_id='".$appID."'");
	foreach($db->get_rows() as $a){
		$app_id = $a['id'];
		$app_name = $a['app_name'];
		$app_type = $a['app_type'];
		$app_active = $a['active'];
	}
	
	if($app_active == 1){
	
	$app_type = $this->registry->getObject($app_type);
	
		
		if(method_exists($app_type, $method)){
			$app_type->model($app_id, $action, $method, $param, $ext, $page); // call the api type model
			
			header('HTTP/1.1 200 OK');
			exit();
		}else{
			$this->funct_error($method); // call function error
		}
		
	}else{
		$this->inactive_app_error($app_name); // inactive app error
	}
	}
	
}



function connection_error(){
	header('Error: Could Not Parse Request');
	header('HTTP/1.1 404 Not Found');	
	exit();
}

function unauthorized_url(){
	header('Error: Unauthorized API Login');
	header('HTTP/1.1 401 Unauthorized');	
	exit();
}

function funct_error($method){
	header('Error: Method ('.$method.') Not Found');	
	header('HTTP/1.1 405 Not Found');	
	exit();
}

function inactive_app_error($appname){
	header('WWW-Authenticate: Basic Realm="Campusfamz API Login"');
	header('Error: Inactive Application ('.$appname.')');	
	header('HTTP/1.1 422 Unprocessable Entry');	
	exit();
}

}
?>
