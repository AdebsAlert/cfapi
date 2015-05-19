<?php
class index_class {
	
		protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }


function index($property){
	 return $this->$property;
 }

}
?>
