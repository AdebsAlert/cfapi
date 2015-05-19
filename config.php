<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * PHP-Framework Version 1.0
  * config.php
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com>
  *
  * Enter your DB credentials
  * For a single server, enter same DB connections for select and update queries 
  * 
  * Define your constants to be used accross the platform
*/

error_reporting(0); 
session_start();

define("PHP_ROOT", "");
define("FRAMEWORK_PATH", "campusfamz-PHP-Framework-v1-1.0/");
define("SDK_PATH", "campusfamz-PHP-SDK-v2-2.0/");
define("PAG", 20);
define("IMAGE_PATH", "http://127.0.0.1/Pictures/");

//define all enterprise urls
define("CF_URL", "http://localhost/campusfamz/");
define("HOME_URL", "http://localhost/cfhome/");
define("API_URL", "http://localhost/cfapi/");
define("HUB_URL", "http://localhost/cfhub/");
define("SLIDE_URL", "http://localhost/cfslides/");
define("TUNES_URL", "http://localhost/cftunes/");
define("DEVELOPERS_URL", "http://localhost/cfdevelopers/");
define("ENG_URL", "http://localhost/adebsalert/");


/******* ENTER YOUR DB CONNECTION CREDENTIALS *******/

// for select queries (SCALING)
define("DB_HOSTNAME1", "127.0.0.1");
define("DB_USERNAME1", "osunitec");
define("DB_PASSWORD1", "Adebsalert2012");
define("DB_NAME1", "osunitec_mobile");


// for updates(insert, update & delete) queries (SCALING)
define("DB_HOSTNAME2", "127.0.0.1");
define("DB_USERNAME2", "osunitec");
define("DB_PASSWORD2", "Adebsalert2012");
define("DB_NAME2", "osunitec_mobile");


/** 
  *include the framework autolaod
  *DO NOT EDIT THIS
**/
require_once(FRAMEWORK_PATH."autoload.php");
?>