<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * PHP-Framework Version 1.0
  * Class registry
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com>
  *
  * DO NOT edit any part of the codes below for the 
  * proper functioning of the software. 
  *
  * Creates and stores instances of all the classes in registry 
*/
	
class registry {

private $object, $key, $folder;
public function __construct(){
}

public function createAndStoreObject($class, $key, $folder){
	
$path = FRAMEWORK_PATH."".$folder."/".$class.".php";



if(file_exists($path)){
    require_once ($path);
}else{
	
}

$this->objects[$key] = new $class($this);
}

public function getObject($key){
return $this->objects[$key];
}

public function __DESTRUCT (){
	 
 }
}
?>
