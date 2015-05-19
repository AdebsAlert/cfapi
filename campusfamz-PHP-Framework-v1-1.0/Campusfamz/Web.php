<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * You are hereby granted a non-exclusive, worldwide, royalty-free license to
  * use, copy, modify, and distribute this software in source code or binary
  * form for use in connection with the web services and APIs provided by
  * Campusfamz.
  *
  * Class Web
  * API Type : Web
  * Usage : Using and sharing CF datas accross external websites 
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com> 
  *
*/

class Web {
	protected $registry;
public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
}
 

function model($app_id, $action, $function, $param, $ext, $page){
	   $this->$function($param, $ext, $page);	
}


function profiles(){
	
}


function feeds(){
	
}


function messages(){
	
}


function slides(){
	
}


function photos(){
	
}

}
?>
