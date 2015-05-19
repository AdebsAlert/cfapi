<?php
class pagination_class {
	
	protected $registry;
 public function __CONSTRUCT (registry $registry){
	 $this->registry = $registry;
 }
 
 function pagination($currentPage, $total_pages, $deli){
	 $gpage = $_GET['pages'];
	 if(!isset($deli)){
		 $deli = "?";
	 }else{
		 $deli = $deli;
	 }
	 if($total_pages != 0){
	 echo '<div id="pg" style="background-color:grey; padding:10px; margin-bottom:30px;">';
	
				if(!(isset($gpage))){
					$gpage = 1;
				}else{
					$gpage = $gpage;
				}
				if(!(isset($gpage)) && $total_pages > 0){
					$gpage = 1;
				}
				$back = $gpage - 1;
				$next = $gpage + 1;
				$last = $total_pages;
				if(!(isset($_REQUEST['pages'])) || $gpage == 1){
					$previous = "<span class='disabled'>&laquo; Previous</span>&nbsp;&nbsp;";
				}else{
				$previous = "<a href='".$currentPage."".$deli."pages=".$back."'><span>&laquo; Previous</span></a>&nbsp;&nbsp;";
				}
				if(!(isset($_REQUEST['pages'])) || $gpage == 1){
					$first = "";
					$last = "&nbsp;&nbsp;<a href='".$currentPage."".$deli."pages=".$last."'><span>&raquo;&raquo; Last</span></a>&nbsp;&nbsp;";
				}else{
				$first = "<a href='".$currentPage."".$deli."pages=1'><span>&laquo;&laquo; First</span></a>&nbsp;&nbsp;";
				$last = "&nbsp;&nbsp;<a href='".$currentPage."".$deli."pages=".$last."'><span>&raquo;&raquo; Last</span></a>&nbsp;&nbsp;";
				}
				if($gpage == $total_pages){
					$last = "";
					$next = "&nbsp;&nbsp;<span class='disabled'>&raquo; Next</span>&nbsp;&nbsp;";
				}else{
					$next = "&nbsp;&nbsp;<a href='".$currentPage."".$deli."pages=".$next."'><span>&raquo; Next</span></a>&nbsp;&nbsp;";
				}
				if($total_pages == 1){
					$last = "";
					$next = "&nbsp;&nbsp;<span class='disabled'>&raquo; Next</span>&nbsp;&nbsp;";
				}
				echo "$first "."$previous";
$c = $gpage - 5;
$e = $gpage + 5;
if($c < 5){
$str = 1;
}else{
$str = $c;
}

if($e > $total_pages){
$ftr = $total_pages;
}else{
$ftr = $gpage + 5;
}
for ($j=$str; $j <= $ftr; $j++){
	if($gpage == $j){
		$span = "class='current'";
	}else{
		$span = "";
	}
					echo "
					<a ".$span." href='".$currentPage."".$deli."pages=".$j."'>".$j."</a> ";
				}
				
				echo "$next"."$last";
				
				echo "</div>";
 }
 }
	
	
}

?>
