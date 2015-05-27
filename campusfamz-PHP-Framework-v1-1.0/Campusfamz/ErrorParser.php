<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * You are hereby granted a non-exclusive, worldwide, royalty-free license to
  * use, copy, modify, and distribute this software in source code or binary
  * form for use in connection with the web services and APIs provided by
  * Campusfamz.
  *
  * Class ErrorParser
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com> 
  *
  * Get and display the right error  
*/
	
class ErrorParser {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function success(){
	header('HTTP/1.1 200 OK');
	exit();
}

function connection_error(){
	header('Error: Could Not Parse Request');
	header('HTTP/1.1 400 Bad Request');	
	exit();
}

function unauthorized_url(){
	header('Error: Unauthorized API Login');
	header('HTTP/1.1 401 Unauthorized');	
	exit();
}

function funct_error($method){
	header('Error: Method ('.$method.') Not Found');	
	header('HTTP/1.1 404 Not Found');	
	exit();
}

function invalid_method(){
	header('Error: Could Not Parse Request');
	header('HTTP/1.1 405 Method Not Allowed');	
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
