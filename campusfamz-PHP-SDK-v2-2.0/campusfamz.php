<?php
/**
  * Copyright 2015 Campusfamz, Inc.
  *
  * PHP-SDK Version 2.0
  *
  * Class CFapi
  *
  * @package Campusfamz
  * @author AdebsAlert <adebsalert@campusfamz.com>
  *
  * DO NOT edit any part of the codes below for the 
  * proper functioning of the software.  
*/

define("API_ADDR", "http://127.0.0.1/cfapi"); // do not change this!
		
class CFapi{
	
function get($function, $param, $ext, $page){
		global $curl;
		include 'key.php';

    $api_url = API_ADDR."/api/v2/".$function."/".$param."/"; 
	$api_url = $api_url."?ext=".$ext."&page=".$page."";	
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $api_url);   
    curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_USERPWD, $appId.':'.$appKey);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	 $response = $this->execute($curl);
	 
	
	 if ($response["responseCode"] == 200) {
      return json_decode($response["body"], true); 
	 }else{
		 $error = $this->displayError($response["responseCode"], $response["headers"]["Error"]);
	  echo json_decode($error, true);
	 }
	 
}
	
	
function post($function, $param, $data, $ext){	
        global $curl;
		include 'key.php';
		
		if(!is_array($param)){
			$data = $data;
		}else{
			$data = $param;
		}

    $api_url = API_ADDR."/api/v2/".$function."/".$param."/";	
	$api_url = $api_url."?ext=".$ext."";  
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $api_url); 
    curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_USERPWD, $appId.':'.$appKey);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
     $response = $this->execute($curl);
	
	 if ($response["responseCode"] == 200) {
      return json_decode($response["body"], true); 
	 }else{
		 $error = $this->displayError($response["responseCode"], $response["headers"]["Error"]);
	  echo json_decode($error, true);
	 }
}
	
	
function put($function, $param, $data, $ext){	
		global $curl;
		include 'key.php';
		
		if(!is_array($param)){
			$data = $data;
		}else{
			$data = $param;
		}

    $api_url = API_ADDR."/api/v2/".$function."/".$param."/"; 
	$api_url = $api_url."?ext=".$ext."";	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $api_url);      
    curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($curl, CURLOPT_USERPWD, $appId.':'.$appKey);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		

	 $response = $this->execute($curl);
	
	 if ($response["responseCode"] == 200) {
      return json_decode($response["body"], true); 
	 }else{
		 $error = $this->displayError($response["responseCode"], $response["headers"]["Error"]);
	  echo json_decode($error, true);
	 }
}
	
	
function delete($function, $param, $data, $ext){	
		global $curl;
		include 'key.php';
		
		if(!is_array($param)){
			$data = $data;
		}else{
			$data = $param;
		}

    $api_url = API_ADDR."/api/v2/".$function."/".$param."/";
	$api_url = $api_url."?ext=".$ext."";	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $api_url);     
    curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_USERPWD, $appId.':'.$appKey);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		

	 $response = $this->execute($curl);
	
	 if ($response["responseCode"] == 200) {
      return json_decode($response["body"], true); 
	 }else{
		 $error = $this->displayError($response["responseCode"], $response["headers"]["Error"]);
	  echo json_decode($error, true);
	 }
}
	
	
function execute($curl){
	$string = curl_exec($curl);
    $headers = array();
    $content = '';
    $str = strtok($string, "\n");
    $h = null;
    while ($str !== false) {
        if ($h and trim($str) === '') {                
            $h = false;
            continue;
        }
        if ($h !== false and false !== strpos($str, ':')) {
            $h = true;
            list($headername, $headervalue) = explode(':', trim($str), 2);
            $headervalue = ltrim($headervalue);
            if (isset($headers[$headername])) 
                $headers[$headername] .= ',' . $headervalue;
            else 
                $headers[$headername] = $headervalue;
        }
        if ($h === false) {
            $content .= $str."\n";
        }
        $str = strtok("\n");
    }
	
	$result["responseCode"] = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
    $result["headers"] = $headers;
    $result["body"] = trim($content);
	curl_close($curl);
    return $result;
}
	
	
function displayError($errorCode, $error_message){ 
   return json_encode("Server returned unexpected status code. (Error ".$errorCode.") - ".$error_message);
}

	 
}  
?>