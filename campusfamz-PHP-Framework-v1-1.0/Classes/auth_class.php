<?php
class auth_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
	
	function filter_data($value){ 
	
	$value = trim($value);
	$value = strip_tags($value);
    $value = mysql_real_escape_string($value);
	$value = str_replace("'", "&acute;", $value);
	
	
	$bad = array(
				  "'","\"",
				 );

	$good = array(
				 "&apos;","&quot;",
				 );	
				 
	$value = str_replace($bad, $good, $value);
		
		return $value;
    }
	
}

?>
