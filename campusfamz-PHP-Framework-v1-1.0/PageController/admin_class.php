<?php
class admin_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function check_admin($user_id){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("SELECT admin_id, active FROM admins WHERE admin_id='".$user_id."'");
	
	if($db->num_rows() == 0){ // incorrect login credentials

	 $response["success"] = 0;
	 $response["count"] = 0;
     $response["message"] = "admin does not exist";
	 
	}else{      // successful LOGIN                   PROCEED
		foreach($db->get_rows() as $d){
			$admin_id = $d['admin_id'];
			$active = $d['active'];
		}
	
	    $response["success"] = 1;
		$response["count"] = $db->num_rows();
		$response["admin_id"] = $admin_id;
		$response["active"] = $active;
	}
	
	return $response;
	
	
}


function create_admin($user_id, $user_role){
	$db = $this->registry->getObject('database');
	
	if($user_id == "" || $user_role == ""){
			
			$response["success"] = 0;
           $response["message"] = "error creating admin";
	 
		}else{
	
	$db->my_sql("INSERT INTO admins (admin_id, active) VALUES ('".$user_id."', '".$user_role."')");
	
	$response["success"] = 1;
    $response["message"] = "admin created successfully";
	
		}
		
		return $response;
	
}


function admin($property){
	 return $this->$property;
 }

}
?>
