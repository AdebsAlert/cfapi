<?php
class slide_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function upload_slide($file_tmp, $file_name, $slide_id, $user_id, $file_id){
	$db = $this->registry->getObject('database');
	
	$handle = fopen($file_tmp, "r");
	$data = fread($handle, filesize($file_tmp));
	$POST_DATA = array('file'=>base64_encode($data), 'name'=>$file_name, 'folder'=>'slides');
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, ''.IMAGE_PATH.'slide_handle.php');
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);

	  curl_exec($curl);
	  curl_close($curl);
	  
	  //check if the slide exist
	  $db->my_sql("SELECT id FROM slides WHERE owner='".$user_id."' AND slide_id='".$slide_id."'");
	  if($db->num_rows() == 0){
	 $db->my_sql("INSERT INTO slides (owner, slide_id, title, date, views) 
	 VALUES ('".$user_id."', '".$slide_id."', '', now(), '1')");
	  }else{}
	  
	$response["success"] = 1;
	$response["count"] = 1;
    $response["message"] = "slide uploaded successfully";
	$response["id"] = $file_id;
	
	
	return $response;
	
	
}


function update_slide($desc, $slide_id){
	$db = $this->registry->getObject('database');
	
	$db->my_sql("UPDATE slides SET title='$desc' WHERE slide_id='".$slide_id."'");
	$response["success"] = 1;
	$response["count"] = 1;
    $response["message"] = "slide updated successfully";
	
	return $response;
	
}

function slide_info($slide_id){
	$db = $this->registry->getObject('database');
	
	// get slide details
	$db->my_sql("SELECT owner, slide_id, title, DATE_FORMAT(date,  '%b %e %Y at %r') AS slide_date FROM slides WHERE slide_id='".$slide_id."'");
	
	foreach($db->get_rows() as $s){
		$slide_id = $s['slide_id'];
		$owner = $s['owner'];
		$title = $s['title'];
		$date = $s['slide_date'];
		$view = number_format($s['view']);
	}
	
	    $dir = IMAGE_PATH.'slides/*'.$slide_id.'*';
		
		$all_slides = glob($dir);
		
		foreach($all_slides as $ab){
		  $image = $ab;
		}
		
		$first_image = $image;
		
		
	
	$response["success"] = 1;
	$response["count"] = $db->num_rows();
	$response["slide_id"] = $slide_id;
	$response["owner"] = $owner;
	$response["title"] = $title;
	$response["date"] = $date;
	$response["views"] = $view;
	$response["first_slide"] = $first_image;
	$response["all_slides"] = $all_slides;
	
	return $response;
    
}



function slide($property){
	 return $this->$property;
 }

}
?>
