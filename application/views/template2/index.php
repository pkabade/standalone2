<?php 
	$attractions_new = @array_slice($attractions,2);
    if(!empty($attractions_new)){
	    foreach($attractions_new as $value){
	    	$attractions_categories_ids[] = $value['attraction_cat_id'];
	    }
    }else{
    	$attractions_categories_ids[]='';
    } 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if(!empty($meta_tags))echo $meta_tags;?>
<title><?php if(!empty($title))echo $title?></title>
<link href="<?php echo $base_url;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_assets_url;?>css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_assets_url;?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_assets_url;?>css/review.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_assets_url;?>css/weather.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_assets_url;?>css/buttons.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_assets_url;?>css/reponsive.css" rel="stylesheet" type="text/css" />






<!--<link href="<?php echo site_url('css/ywl'); ?>/jquery.cluetip.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('css/ywl'); ?>/slides.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('css/ywl'); ?>/facebox.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo site_url('css/ywl'); ?>/jquery-ui-1.8.10.custom.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo site_url('css/ywl'); ?>/deals.css" rel="stylesheet" type="text/css" />

-->
<script type="text/javascript">
        	var __HOST__ = "<?php echo $site_url ?>";
        	var __SITE__ = "<?php echo $site_url ?>";
            var property = '<?php echo $property['property_name']; ?>';
            var address = '<?php echo $property['street_address']; ?>';            
            var lat = '37.817124';
            var lng = '-120.059928';
            var bin_url = "<?php echo $this->config->item('bin_url')?>"; 
            var local_user = "<?php echo $this->config->item('local_user')?>";
            var image_url	= "<?php echo $theme_assets_url;?>images";
            //this last image_url added for to get path of the image in js    added by  Mohan on date 21 Sep 2011.
           var assets_path	=	'<?php echo $theme_assets_url;?>'; 
           //used in common header.js
</script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_assets_url;?>js/cufon.js"></script>
<script type="text/javascript" src="<?php echo $theme_assets_url;?>js/Trebuchet_MS_700.font.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/theme.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/easySlider1.7.js"></script>
<script type="text/javascript" src="<?php echo $theme_assets_url;?>js/script.js"></script>
<script type="text/javascript" src="<?php echo $theme_assets_url;?>js/theme.js"></script>


<script type="text/javascript" src="<?php echo $base_url;?>assets/bootstrap/js/bootstrap.min.js"></script>


<!--<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/jquery.cluetip.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/jquery.tooltip.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/common.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/header.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/content_top.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/room_rates.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/scripts.js"></script>

--><!--<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/easySlider1.7.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/facebox.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/slides.js"></script>




<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/jcarousellite.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/loopedslider.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/slider.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/image_preview.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/jquery.lazyload.mini.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/common/js/jquery.tooltip.js"></script>-->


<script type="text/javascript">  
        Cufon.replace('.featured_mid h4, .menu a, .welcome h4, .innkeeper h4, .weather h4, .travel_ideas h4, .map h4, .hot_deal h4, .availability a');
</script>

<!--<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
--></head>
<body>

<?php include 'top_slide_box.php'?>

<div class="top_line"></div>
<div class="container">
	<div class="header"><?php include 'header.php'; ?></div>
</div>
<div class="menu" id="main_navigation">
	<div class="container">
    	<ul>
            <li class="last"><a href="<?php echo $site_url?>">Home</a></li>
            <li><a href="<?php echo $site_url?>overview" title="">Overview</a></li>
            <li><a href="<?php echo $site_url?>guestrooms">Guest Rooms</a></li>
            <li><a href="<?php echo $site_url?>accommodations">Accomodations</a></li>
            <li><a href="<?php echo $site_url?>gallery">Gallery</a></li>
            <li><a href="<?php echo $site_url?>destination-guide">Destination</a></li>
            <li><a href="<?php echo $site_url?>directions">Directions</a></li>
    	</ul>
    </div><!--menu container ends-->
</div><!--menu ends-->
<div class="top_body">
	<?php if(!empty($main_content)) include $main_content.".php"; ?>
</div>
<div class="footer">
	<?php include 'footer.php'; ?>
</div>
</body>
</html>