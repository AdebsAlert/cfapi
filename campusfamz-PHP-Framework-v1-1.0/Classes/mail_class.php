<?php

class mail_class {
	protected $user_id, $padiz, $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
 
 function friend_request_mail($fr_email, $fr_username, $my_username){
	 // formating the mail posting to notify user of one friend request
// headers here 
$Name = "Campusfamz.com";
$email ="admin@campusfamz.com"; // Change this address within quotes to your address
$headers = "From: ". $Name . "<" . $email . ">";
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
// for html mail un-comment the above line
		// mail funciton will return true if it is successful
if(mail($fr_email,"You Have New Friend Request",
"<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>CampusFamz.com</title>
<meta name='HandheldFriendly' content='True' />
</head>
<style type='text/css'>
body {
	width: 99%;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.sitename {
	color: white;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	text-align: center;
	background-color:#005CB9;padding:5px;
	font-weight:bold;
	font-size:25px;
}
.content{
	font-size:14px;
	padding-top:5px; padding-bottom:5px;
	padding-left: 20px;
	border: ridge;
	border-width:thin;
	border-color:#666;
}
input[type=button] {
	background-color:#005CB9;padding:3px;
	color:white;
}
</style>
<body>
<div class='sitename'>Campusfamz</div>
<div class='content'>
<p><b>Hi $fr_username, <br />
You have a new notification</b></p>

$my_username wants to be your friend<br><p>
<a href='http://www.campusfamz.com' target='new'><input type='button' value='Click here to view' /></a>
</p><hr>
This is an automated mail, please do not reply.
</div>

</body>
</html>
",
"$headers"));
 }
 
 function friend_accept_mail($fr_email, $fr_username, $my_username){
	 // formating the mail posting to notify user of one friend request
// headers here 
$Name = "Campusfamz.com";
$email ="admin@campusfamz.com"; // Change this address within quotes to your address
$headers = "From: ". $Name . "<" . $email . ">";
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
// for html mail un-comment the above line
		// mail funciton will return true if it is successful
if(mail($fr_email,"You Have New Friend Notification",
"<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>CampusFamz.com</title>
<meta name='HandheldFriendly' content='True' />
</head>
<style type='text/css'>
body {
	width: 99%;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.sitename {
	color: white;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	text-align: center;
	background-color:#005CB9;padding:5px;
	font-weight:bold;
	font-size:25px;
}
.content{
	font-size:14px;
	padding-top:5px; padding-bottom:5px;
	padding-left: 20px;
	border: ridge;
	border-width:thin;
	border-color:#666;
}
input[type=button] {
	background-color:#005CB9;padding:3px;
	color:white;
}
</style>
<body>
<div class='sitename'>Campusfamz</div>
<div class='content'>
<p><b>Hi $fr_username, <br />
You have a new notification</b></p>
$my_username has accepted your friend request, you can now connect & share<br><br>

<a href='http://www.campusfamz.com' target='new'><input type='button' value='Click here to connect' /></a>
</p><hr>
This is an automated mail, please do not reply.
</div>

</body>
</html>",
"$headers"));
 }
 
 
 function friend_famz_mail($fr_email, $fr_username, $my_username){
	 // formating the mail posting to notify user of one friend request
// headers here 
$Name = "Campusfamz.com";
$email="admin@campusfamz.com"; // Change this address within quotes to your address
$headers = "From: ". $Name . "<" . $email . ">";
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
// for html mail un-comment the above line
		// mail funciton will return true if it is successful
if(mail($fr_email,"You Have A New Famzer",
"<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>CampusFamz.com</title>
<meta name='HandheldFriendly' content='True' />
</head>
<style type='text/css'>
body {
	width: 99%;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.sitename {
	color: white;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	text-align: center;
	background-color:#005CB9;padding:5px;
	font-weight:bold;
	font-size:25px;
}
.content{
	font-size:14px;
	padding-top:5px; padding-bottom:5px;
	padding-left: 20px;
	border: ridge;
	border-width:thin;
	border-color:#666;
}
input[type=button] {
	background-color:#005CB9;padding:3px;
	color:white;
}
</style>
<body>
<div class='sitename'>Campusfamz</div>
<div class='content'>
<p><b>Hi $fr_username, <br />
You have a new notification</b></p>
$my_username famzed you to stay connected & share with you<br><br> 

<a href='http://www.campusfamz.com' target='new'><input type='button' value='Click here to view' /></a>
</p><hr>
This is an automated mail, please do not reply.
</div>

</body>
</html>",
"$headers"));
 }
 
 function friend_message_mail($fr_email, $fr_username, $my_username){
	// formating the mail posting to notify user of one friend request
// headers here 
$Name = "Campusfamz.com";
$email="support@campusfamz.com"; // Change this address within quotes to your address
$headers = "From: ". $Name . "<" . $email . ">";
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
// for html mail un-comment the above line

// mail funciton will return true if it is successful
if(mail($fr_email,"You Have A New Message",
"<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>CampusFamz.com</title>
<meta name='HandheldFriendly' content='True' />
</head>
<style type='text/css'>
body {
	width: 99%;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.sitename {
	color: white;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	text-align: center;
	background-color:#005CB9;padding:5px;
	font-weight:bold;
	font-size:25px;
}
.content{
	font-size:14px;
	padding-top:5px; padding-bottom:5px;
	padding-left: 20px;
	border: ridge;
	border-width:thin;
	border-color:#666;
}
input[type=button] {
	background-color:#005CB9;padding:3px;
	color:white;
}
</style>
<body>
<div class='sitename'>Campusfamz</div>
<div class='content'>
<p><b>Hi $fr_username, <br />
You have a new notification</b></p>

$my_username sent you a message<br><br>

 <a href='http://www.campusfamz.com' target='new'><input type='button' value='Click here to read' /></a>
</p><hr>
This is an automated mail, please do not reply.
</div>

</body>
</html>","$headers"));
 }
 
function new_user_mail($username, $fr_email){
	// formating the mail posting to notify user of one friend request
// headers here 
$Name = "Campusfamz.com";
$email="support@campusfamz.com"; // Change this address within quotes to your address
$headers = "From: ". $Name . "<" . $email . ">";
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
// for html mail un-comment the above line

// mail funciton will return true if it is successful
if(mail($fr_email,"Welcome To Campusfamz",
"<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>CampusFamz.com</title>
<meta name='HandheldFriendly' content='True' />
</head>
<style type='text/css'>
body {
	width: 99%;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.sitename {
	color: white;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	text-align: center;
	background-color:#005CB9;padding:5px;
	font-weight:bold;
	font-size:25px;
}
.content{
	font-size:14px;
	padding-top:5px; padding-bottom:5px;
	padding-left: 20px;
	border: ridge;
	border-width:thin;
	border-color:#666;
}
input[type=button] {
	background-color:#005CB9;padding:3px;
	color:white;
}
</style>
<body>
<div class='sitename'>Campusfamz</div>
<div class='content'>
<p><b>Hi $username, <br />

<h2> Welcome to campusfamz.com</h2><br><br>

You have successfully created an account to be used accross all our platforms.<br>
This single account gives you unlimited and free access to all the platforms.<br><br>

<b>Here are some tips to get you going:</b><br><br>

- Build your <a href='http://home.campusfamz.com'>Home</a> profile and invite your closest friends to your <a href='http://home.campusfamz.com'>Home</a> network<br>
- Create, share and stay updated with latest news happening around you in your <a href='http://hub.campusfamz.com'>Hub</a><br>
- Create and share moments in <a href='http://slides.campusfamz.com'>Slides</a> with friends and loved ones<br>
- Download and share latest songs, videos and musical beats in <a href='http://tunes.campusfamz.com'>Tunes</a>.<br>  
- And lots more<br>
<br> Thank You <br><br> 

<a href='http://www.campusfamz.com' target='new'><input type='button' value='Click here to continue' /></a>
</p><hr>
This is an automated mail, please do not reply.
</div>

</body>
</html>","$headers"));
 }
 
 
 
function forgot_password_mail($username, $fr_email, $password){
	// formating the mail posting to notify user of one friend request
// headers here 
$Name = "Campusfamz.com";
$email="support@campusfamz.com"; // Change this address within quotes to your address
$headers = "From: ". $Name . "<" . $email . ">";
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
// for html mail un-comment the above line

// mail funciton will return true if it is successful
if(mail($fr_email,"Password Reminder",
"<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>CampusFamz.com</title>
<meta name='HandheldFriendly' content='True' />
</head>
<style type='text/css'>
body {
	width: 99%;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.sitename {
	color: white;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	text-align: center;
	background-color:#005CB9;padding:5px;
	font-weight:bold;
	font-size:25px;
}
.content{
	font-size:14px;
	padding-top:5px; padding-bottom:5px;
	padding-left: 20px;
	border: ridge;
	border-width:thin;
	border-color:#666;
}
input[type=button] {
	background-color:#005CB9;padding:3px;
	color:white;
}
</style>
<body>
<div class='sitename'>Campusfamz</div>
<div class='content'>
<p><b>Hi $username, <br />

<h2> Here are your login credentials</h2><br><br>
Username : $fr_email<br>
Password : $password<br><br>

<a href='http://www.campusfamz.com'><input type='button' value='Login now' /></a>


</html>","$headers"));
 }
 
 
function send_email($user_mail, $subject, $message){
		// formating the mail posting to notify user of one friend request
// headers here 
$Name = "Campusfamz.com";
$email="support@campusfamz.com"; // Change this address within quotes to your address
$headers = "From: ". $Name . "<" . $email . ">";
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
// for html mail un-comment the above line

// mail funciton will return true if it is successful
if(mail($user_email, $subject,
"<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>CampusFamz.com</title>
<meta name='HandheldFriendly' content='True' />
</head>
<style type='text/css'>
body {
	width: 99%;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.sitename {
	color: white;
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
	text-align: center;
	background-color:#005CB9;padding:5px;
	font-weight:bold;
	font-size:25px;
}
.content{
	font-size:14px;
	padding-top:5px; padding-bottom:5px;
	padding-left: 20px;
	border: ridge;
	border-width:thin;
	border-color:#666;
}
input[type=button] {
	background-color:#005CB9;padding:3px;
	color:white;
}
</style>
<body>
<div class='sitename'>Campusfamz</div>
<div class='content'>
$message
</html>","$headers"));
	
}
 
 public function __DESTRUCT (){
	 
 }
 
}
?>
