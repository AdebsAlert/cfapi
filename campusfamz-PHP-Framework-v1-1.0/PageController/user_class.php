<?php
class user_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function user_login($username, $password){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("SELECT user_id, username, password, email FROM users WHERE (mat='".$username."' OR username='".$username."' OR phone='".$username."' OR matric='".$username."' OR email='".$username."') AND password='".$password."'");
	
	if($db->num_rows() == 0){ // incorrect login credentials

	 $response["success"] = 0;
     $response["message"] = "incorrect username or password";
	 
	}else{      // successful LOGIN                   PROCEED
		foreach($db->get_rows() as $d){
			$user_id = $d['user_id'];
			$username = $d['username'];
			$email = $d['email'];
			$password = $d['password'];
		}
	
	    $response["success"] = 1;
		$response["user_id"] = $user_id;
		$response["username"] = $username;
		$response["email"] = $email;
		$response["password"] = $password;
		
	}
	
	return $response;
	
	
}

function user_reg($fullname, $email, $username, $password, $re_password, $birthday, $birthmonth, $birthyear, $sex, $country, $phone, $verification){
	$db = $this->registry->getObject('database');
    $mail = $this->registry->getObject('mail_class');
	
	$full_birthday = "$birthday/$birthmonth/$birthyear";
	$names = explode (" ", $fullname);
	$firstname = $names[0];
	$lastname = $names[1];
	
	// checking
	
	if($verification != 18){ // verification code does not match
	
	 $response["success"] = 0;
     $response["message"] = "verification code failed";
	 
	}else if($password != $re_password){ //passwords does not match
	
	$response["success"] = 0;
    $response["message"] = "password does not match";
		
	}else{ // all first checking passed                      PROCCED
		//check if already existing
	$db->my_sql("SELECT email, username FROM users WHERE email='".$email."' OR username='".$username."'");
	if($db->num_rows() != 0){ // username or email already exist
		foreach($db->get_rows() as $reginfo){
			$alemail = $reginfo['email'];
			$alusername = $reginfo['username'];
		}
		if($alemail != "" && $alusername != ""){
			
			$response["success"] = 0;
            $response["message"] = "user with email <span style='color:green'>$email</span> already registered";
	 
		}else{
			
			$response["success"] = 0;
            $response["message"] = "username already exist, kindly use another";
			
		}
		
     }
else{ // email or username does not exist                    PROCEED

       if(strlen($password) < 6){ // password id less than 6 char
	   
	   $response["success"] = 0;
       $response["message"] = "password is too short";
			
			}else{ // password is more than 6 char            PROCEED
		$regex = '/^[_a-z0-9]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if(strlen($email) < 6 || (!(preg_match($regex, strtolower($email))))){ // email does not contain some necessary char
		
		$response["success"] = 0;
        $response["message"] = "invalid email address";
	   
			}else{ // email is good                            PROCEED
		if(strlen($username) < 3){ // username is less than 3 char
		
		$response["success"] = 0;
        $response["message"] = "username is too short";
			
	}else{ // username is over 3 char                           PROCEED
	
	
	
	$db->my_sql("INSERT INTO users (username, password, email, phone, sex, firstname, surname, dob, country) 
	VALUES 
	('".$username."', '".$password."', '".$email."', '".$phone."', '".$sex."', '".$firstname."', '".$lastname."', '".$full_birthday."', '".$country."')", 1);
	
	$user_id = $db->last_id();
	
	$mail->new_user_mail($username, $email);
	
	
	$db->my_sql("INSERT INTO contacts (matric, phone, active, facebook, twitter, yahoo, blackberry) VALUES 
	('".$user_id."', '', '', '', '', '', '')", 1);
	
	$db->my_sql("INSERT INTO biography (matric, quote, about) VALUES ('".$user_id."', '', '')", 1);
	
	$db->my_sql("INSERT INTO image (matric) VALUES ('".$user_id."' )", 1);
	
	$response["success"] = 1;
    $response["user_id"] = $user_id;

	}
			}
			}
}
	}
		
		return $response;
	
}


function retrieve_password($email){
	$db = $this->registry->getObject('database');
	$mail = $this->registry->getObject('mail_class');
	
	$db->my_sql("SELECT username, password FROM users WHERE email='".$email."'");
	if($db->num_rows() == 0){
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user does not exist";
	}else{
		
	foreach($db->get_rows() as $u){
		$password = $u['password'];
		$username = $u['username'];
	}
	  $response["success"] = 1;
	  $response["count"] = $db->num_rows();
	  $response["password"] = $password;
	  
	  $mail->forgot_password_mail($username, $email, $password);
	}
		
	return $response;	
}


function profile_info($user_id){
	$db = $this->registry->getObject('database');
	$photo = $this->registry->getObject('photo_class');
	
	$image_response = $photo->profile_photo($user_id); // get user photo details
    $cover_image_response = $photo->cover_photo($user_id); // get user photo details
	
	    $response["image_url"] = $image_response["image_link"];
		$response["image_type"] = $image_response["image_type"];
		$response["image_id"] = $image_response["image_id"];
		$response["cover_photo"] = $cover_image_response["image_link"];
	
	$db->my_sql("SELECT user_id, username, email, phone, institution, sex, hometown, state, firstname, surname, dob, relationship, location, city, country FROM users WHERE (user_id='".$user_id."' OR username='".$user_id."' OR email='".$user_id."')");
	
	$user_count = $db->num_rows();
	
	if($user_count == 0){ // user does not exist at all
		$response["success"] = 0;
		$response["count"] = $db->num_rows();
        $response["message"] = "user does not exist";
		
	}else{  // user exist in the DB table, go ahead and grab the profile info with the profile photo
		
		foreach($db->get_rows() as $user_info){
			$user_id = $user_info['user_id'];
			$username = $user_info['username'];
			$email = $user_info['email'];
			$phone = $user_info['phone'];
			$institution = $user_info['institution'];
			$sex = $user_info['sex'];
			$hometown = $user_info['hometown'];
			$state = $user_info['state'];
			$firstname = $user_info['firstname'];
			$surname = $user_info['surname'];
			$dob = $user_info['dob'];
			$relationship = $user_info['relationship'];
			$location = $user_info['location'];
			$city = $user_info['city'];
			$country = $user_info['country'];
		}
		
		
	// get bio infos
	$db->my_sql("SELECT quote, about FROM biography WHERE matric='".$user_id."'");
	foreach($db->get_rows() as $bio_info){
			$quote = $bio_info['quote'];
			$about = $bio_info['about'];
	}

		
		$response["success"] = 1;
		$response["count"] = $user_count;
        $response["user_id"] = $user_id;
		$response["username"] = $username;
		$response["email"] = $email;
		$response["phone"] = $phone;
		$response["institution"] = $institution;
		$response["sex"] = $sex;
		$response["hometown"] = $hometown;
		$response["state"] = $state;
		$response["firstname"] = $firstname;
		$response["surname"] = $surname;
		$response["dob"] = $dob;
		$response["relationship"] = $relationship;
		$response["location"] = $location;
		$response["city"] = $city;
		$response["country"] = $country;
		$response["quote"] = $quote;
		$response["about"] = $about;
	}
	
	return $response;	
}


function subscribe_user($email){
	$db = $this->registry->getObject('database');
	
	// check if email exits in user table
	$db->my_sql("SELECT user_id FROM users WHERE email='".$email."'");
	$users_count = $db->num_rows();
	
	
	// check if email exits in subscribers table
	$db->my_sql("SELECT id FROM subscribers WHERE email='".$email."'");
	$subs_count = $db->num_rows();
	
	$tot = $users_count + $subs_count;
	
	if($tot != 0){
		
		$response["success"] = 0;
		$response["count"] = 0;
        $response["message"] = "user already subsribed";
		
	}else{
		$db->my_sql("INSERT INTO subscribers (email) VALUES ('".$email."')");
		
		$response["success"] = 1;
		$response["count"] = 1;
        $response["message"] = "user subsribed successfully";
	}
	
	return $response;
	
}



function user($property){
	 return $this->$property;
 }

}
?>
