<?php
class cache_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
 
 
 
 function append_cache($sql){
 
 if(strpos($sql, 'INSERT') !== false){
		    $ex = explode("INTO ", $sql); $w = $ex[1]; // w here is the table blah blah blah
		}elseif(strpos($sql, 'DELETE') !== false){
			$ex = explode("FROM ", $sql); $w = $ex[1];
		}elseif(strpos($sql, 'UPDATE') !== false){
			$ex = explode("UPDATE ", $sql); $w = $ex[1];
		}else{
			unset($ex);
		}
		
	    $m = $_SESSION['matric'];
		$w1 = explode(" ", $w); $wia = $w1[0];
		$like = $m."_".$wia;
		$dir = '../cache/*'.$like.'*';
		$a = glob($dir);
		foreach($a as $ab){
		unlink ($ab); 
		}
 }
 
 
 function name_cache($sql){
	 $ex = explode("FROM ", $sql); $w = $ex[1];
	$w1 = explode(" ", $w); $wia = $w1[0];
	
	 $m = $_SESSION['matric'];
	$this->name = $m."_".$wia."_".md5($sql);
 }
 
 
 function set_cache($name, $rows){
	 $a = 'brand_image'; $b = 'market_pics';
	 if((strpos($name, $a) != true) &&  strpos($name, $b) != true){
	  $file = '../cache/'.$name.'.txt';
$OUTPUT = serialize($rows);
$fp = fopen($file,"w");
fputs($fp, $OUTPUT);
fclose($fp);
	 }
 }
 
 function get_cache($name, $num_rows, $result){
	 $file = '../cache/'.$name.'.txt';
     $expire = 60 * 1 / 2; //  30 sec
if (file_exists($file) && filemtime($file) > (time() - $expire)) {
    $rows = unserialize(file_get_contents($file));
	 $this->c_res = $rows;
	 
}else{ // no cache data found, get from DB and cache results
 unlink($file);
    for($i =0; $i < $num_rows; ++$i){
      $rows[] = mysql_fetch_assoc($result);   
    }
	
	$cache = $this->registry->getObject('cache_class'); // send new records to cache class for caching
	$cache->set_cache($name, $rows);

       $this->c_res = $rows;
    }
 }
 
 
 
 function cache($property){
	 return $this->$property;
 }
 
 public function __DESTRUCT (){
	 
 }
 
 }

?>
