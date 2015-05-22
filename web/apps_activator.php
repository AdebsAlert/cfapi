<div class="main-nav-icon">
<a href="#" onclick="viewMainApps()" class="right_bt" id="activator" title="Apps"><span> </span> </a> 
<?php
$response = $campusfamz->get('profiles', $_SESSION['cfuser']);
$my_profile_pics_link = $response['image_url'];
$my_username = $response['username'];
?>

<a target="_blank" href="<?php echo HOME_URL.$my_username; ?>" style="color:white"> 
<img src="<?php echo $my_profile_pics_link; ?>"><?php echo $my_username; ?></a>                  
</div>

<div id="apps_view">

<a id="btnCloseproject" onclick="closeMainApp()" style="color:grey; cursor:pointer; font-weight:bold; float:right; padding-right:10px">X</a>
<a href="http://campusfamz.com"><h1 style="padding:10px 10px 0 10px; font-size:22px"><img src="<?php echo CF_URL; ?>web/images/campusfamz.jpg" width="25">CF Apps</h1></a>
<br />

<div class="odd_app">
<a href="<?php echo HOME_URL; ?>" target="_blank">
<h3>Home</h3>
<p>Meet and stay connected with friends.</p>
</a>
</div>

<div class="even_app">
<a href="<?php echo HUB_URL; ?>" target="_blank">
<h3>Hub</h3>
<p>Stay updated with news and gists around you.</p>
</a>
</div>

<div class="odd_app">
<a href="<?php echo TUNES_URL; ?>" target="_blank">
<h3>Tunes</h3>
<p>Download & share musics, videos and musical beats.</p>
</a>
</div>

<div class="even_app">
<a href="<?php echo SLIDE_URL; ?>" target="_blank">
<h3>Slides</h3>
<p>Create and share photo slides with friends.</p>
</a>
</div>


<hr />
<h1 style="padding:10px 10px 0 10px; font-size:22px">More on CF</h1>
<br />

<div class="odd_app">
<a href="<?php echo DEVELOPERS_URL; ?>" target="_blank">
<h3>Developers</h3>
<p>Build with campusfamz open-source infastructures.</p>
</a>
</div>


<div class="even_app">
<a href="<?php echo ENG_URL; ?>" target="_blank">
<h3>Engineering</h3>
<p>Let our skilled engineers help you build the website of your dreams.</p>
</a>
</div>



</div>

                
<style type="text/css">
.main-nav-icon{
	position:absolute;
	top:10px;
	right: 15px;
}

.main-nav-icon img{
	width:50px;
	height:35px;
	border-radius:50px;
	margin-right:5px;
}

.main-nav-icon a span{
	color: black;
	width:48px;
	height:40px;
	display:block;
	float:left;
	margin-right:10px;
	background: url(http://www.chipbrothers.com/bilder/nav-icon.png) no-repeat 0px 0px;
}

#apps_view{
   display: none;
   position: fixed;
   width: 25%;
   border-radius:5px;
   top: 22.5%;
   right: 20px;
   margin-left: -190px;
   margin-top: -100px;
   background-color: #ffffff;
   border: 2px solid #CCC;
   padding: 0px;
   z-index: 3;
   overflow: auto;overflow-style: marquee-line;
}

.odd_app{
	background-color: #E1E1E1;
	padding: 10px;
}

.odd_app h3{
	color:#005CB9;
	font-size:18px;
}

.odd_app p{
	color:black;
	font-size:14px;
}

.even_app{
	background-color: white;
	padding: 10px;
}

.even_app h3{
	color:#005CB9;
	font-size:18px;
}

.even_app p{
	color:black;
	font-size:14px;
}
@media only screen and (max-width: 580px) {
.main-nav-icon{
	display:none;
	position:absolute;
	top:5px;
	right: 5px;
}

#apps_view{
   display: none;
   position: fixed;
   width: 80%;
   border-radius:2px;
   top: 17.5%;
   right: 1px;
   margin-left: -190px;
   margin-top: -100px;
   background-color: #ffffff;
   border: 2px solid #CCC;
   padding: 0px;
   z-index: 3;
   overflow: auto;overflow-style: marquee-line;height: 100%;
}

.main-nav-icon a span{
	color: black;
	width:280%;
	height:40px;
	display:block;
	float:left;
	margin-right:10px;
	background: url(http://www.chipbrothers.com/bilder/nav-icon.png) no-repeat 0px 0px;
}
	
}
</style>


<script type="text/javascript">

   function viewMainApps(){ 
   if ($('#apps_view').is(":hidden")){$("#apps_view").fadeIn(300);}else{$("#apps_view").fadeOut(300);}
   }
   
   function closeMainApp(){
     $("#apps_view").fadeOut(300);
   } 
        
</script>