<?php 
	header("HTTP/1.1 404 Not Found"); 
	//global  $config;
	$site_url = config_item('base_url');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<link type="text/css" rel="stylesheet" href="<?php  echo $site_url;?>/assets/css/abvi/error.css">-->
<link type="text/css" rel="stylesheet" href="<?php   echo $site_url;?>assets/css/abvi/error.css">
<!--<link type="text/css" rel="stylesheet" href="<?php echo $site_url;?>assets/css/scl/error.css">
<link type="text/css" rel="stylesheet" href="<?php  // echo $site_url;?>assets/css/leemore/error.css">-->
<title>Oops! - 404 Page Not Found Error</title>
</head>

<body>
<div id="bg_mainbx">

  <div class="First_B">
  <div class="First_Left"></div>
<div class="First_Center">404 Page Not Found</div>
<div class="First_Right"></div
></div>
<div class="First_B MAll W630">
<div class="Second_TP"></div>
<div class="Second_Center">
 <div class="Blue_FT">Oops! It seems like we can't  find the page you are looking for!  </div>
 <div class="Blue_FT2"> Perhaps you are here because: </div>
 <div class="Main_BT"> <div class="Bullets"></div> <div class="Text"> The page has moved </div>   </div>
 <div class="Main_BT"> <div class="Bullets"></div> <div class="Text">The page no longer exists </div> </div>
 <div class="Main_BT"> <div class="Bullets"></div> <div class="Text"> You really, really like 404 pages </div> </div>
 <div class="btn_open">  <a href="<?php  echo $site_url;?>" class="Gray">Return to Home Page</a> </div>
<!-- <div class="btn_open">  <a href="http://beta.montereystagecoachlodge.com/stagecoach" class="Gray">Return to Home Page</a> </div>-->
<!-- <div class="btn_open">  <a href="http://beta.visaliacahotel.com/abvi" class="Gray">Return to Home Page</a> </div>-->
<!-- <div class="btn_open">  <a href="http://beta.yosemitewestgate.com/yosemite" class="Gray">Return to Home Page</a> </div>-->
</div>
<div class="Second_BT"></div>
</div>
<div id="Logo"><img src="<?php echo $site_url;?>/assets/css/abvi/images/abvi_logo.png" width="180" height="150" /></div>
<!--<div id="Logo"><img src="<?php echo $site_url;?>assets/css/scl/images/scl_logo.png" width="180" height="150" /></div>
<div id="Logo"><img src="<?php echo $site_url;?>assets/css/abvi/images/abvi_logo.png" width="180" height="150" /></div>-->
<!--<div id="Logo"><img src="<?php //echo $site_url;?>assets/css/ywl/images/logo.png" width="180" height="150" /></div>-->
</div>

</body>
</html>
