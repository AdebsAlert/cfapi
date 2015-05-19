<?php
/**
 * Copyright 2015 Campusfamz.
 */
 

class database {
    protected $result, $_numRows, $_lastid, $_rows, $_name, $registry;
	
	
       public function __CONSTRUCT (registry $registry){
$this->registry = $registry;
$this->link_DBselect = mysql_connect(DB_HOSTNAME1, DB_USERNAME1, DB_PASSWORD1); mysql_select_db(DB_NAME1, $this->link_DBselect); 
$this->link_DBupdate = mysql_connect(DB_HOSTNAME2, DB_USERNAME2, DB_PASSWORD2); mysql_select_db(DB_NAME2, $this->link_DBupdate);   
       }
    
       public function my_sql($sql, $plus){
		   if (strpos($sql,'SELECT') !== false) { 
		   // select query goes to slave server
$this->result = mysql_query($sql, $this->link_DBselect);
		   }else{ // update query goes to master server
$this->result = mysql_query($sql, $this->link_DBupdate);			   
		   }
		// log request made
if(isset($plus)){
$cache = $this->registry->getObject('cache_class');
$cache->append_cache($sql);}


		
if (strpos($sql,'SELECT') !== false){
$cache = $this->registry->getObject('cache_class');
$cache->name_cache($sql);
$this->_name = $cache->cache('name');
$this->_numRows = mysql_num_rows($this->result);
 }else{ }
mysql_free_result();
$this->_lastid =  mysql_insert_id();
		
       }
    
       public function num_rows(){
return ($this->_numRows);
       }
	
	   public function name(){
return ($this->_name);
       }
	
	   public function last_id(){
return $this->_lastid;
       }
	
    
	
       public function get_rows(){
$cache = $this->registry->getObject('cache_class');
$cache->get_cache($this->name(), $this->num_rows(), $this->result);
return $cache->cache('c_res');
	   }
	   
	   
	   public function __DESTRUCT (){
		   foreach ($this->results as $result)
{
@mysql_free_result($result);
}
	 
 }
	   
}
?>
