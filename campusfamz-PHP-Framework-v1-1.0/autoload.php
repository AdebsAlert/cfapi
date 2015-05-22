<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * PHP-Framework Version 1.0
  * autoload.php
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com> 
  *
  * Autoload all the class
  * Call the class name from anywhere in your pages
*/

function __autoload($class){ // autoload classes
$path = FRAMEWORK_PATH."Registry/".$class.".php";
if (file_exists($path)) {
    require $path;
  }
}

$registry = new registry();

$registry->createAndStoreObject('session_class', 'session_class', 'Classes');
$registry->createAndStoreObject('auth_class', 'auth_class', 'Classes');
$registry->createAndStoreObject('database', 'database', 'Model');
$registry->createAndStoreObject('cache_class', 'cache_class', 'Model');
$registry->createAndStoreObject('user_class', 'user_class', 'PageController');
$registry->createAndStoreObject('admin_class', 'admin_class', 'PageController');
$registry->createAndStoreObject('friend_class', 'friend_class', 'PageController');
$registry->createAndStoreObject('photo_class', 'photo_class', 'PageController');
$registry->createAndStoreObject('forum_class', 'forum_class', 'PageController');
$registry->createAndStoreObject('slide_class', 'slide_class', 'PageController');
$registry->createAndStoreObject('message_class', 'message_class', 'PageController');
$registry->createAndStoreObject('search_class', 'search_class', 'PageController');
$registry->createAndStoreObject('feed_class', 'feed_class', 'PageController');
$registry->createAndStoreObject('developer_class', 'developer_class', 'PageController');
$registry->createAndStoreObject('mail_class', 'mail_class', 'Classes');
$registry->createAndStoreObject('pagination_class', 'pagination_class', 'Classes');
$registry->createAndStoreObject('CampusfamzAuth', 'CampusfamzAuth', 'Campusfamz');
$registry->createAndStoreObject('Campusfamz', 'Campusfamz', 'Campusfamz');
$registry->createAndStoreObject('Functions', 'Functions', 'Campusfamz');
$registry->createAndStoreObject('ErrorParser', 'ErrorParser', 'Campusfamz');
$registry->createAndStoreObject('Developers', 'Developers', 'Campusfamz');
$registry->createAndStoreObject('Web', 'Web', 'Campusfamz');


$db = $registry->getObject('database');
$cache = $registry->getObject('cache_class');
$session = $registry->getObject('session_class');
$auth = $registry->getObject('auth_class');
$user = $registry->getObject('user_class');
$admin = $registry->getObject('admin_class');
$friend = $registry->getObject('friend_class');
$photo = $registry->getObject('photo_class');
$forum = $registry->getObject('forum_class');
$slide = $registry->getObject('slide_class');
$message = $registry->getObject('message_class');
$search = $registry->getObject('search_class');
$feed = $registry->getObject('feed_class');
$mail = $registry->getObject('mail_class');
$developer = $registry->getObject('developer_class');
$apiAuth = $registry->getObject('CampusfamzAuth');
$pagination = $registry->getObject('pagination_class');

?>
