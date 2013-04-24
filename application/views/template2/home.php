<div class="container">
		<div class="floatl slider" id="slider">
            <div class="slide_mid" id="slide-holder" style="display:block; max-height:310px;overflow:hidden;">
            	<div id="slide-runner" style="max-height:310px;overflow:hidden;">
				<?php if(is_array($property_images[0])) {  ?>
	            	<ul>
	            		<li><img id="slide-img-1" src="<?php echo str_replace('medium/','',$property_images[0]['image_url']); ?>" width="595" height="306" alt="" /></li>
	            		<li><img id="slide-img-2" src="<?php echo str_replace('medium/','',$property_images[1]['image_url']); ?>" width="595" height="306" alt="" /></li>
	            		<li><img id="slide-img-3" src="<?php echo str_replace('medium/','',$property_images[2]['image_url']); ?>" width="595" height="306" alt="" /></li>
	            		<li><img id="slide-img-4" src="<?php echo str_replace('medium/','',$property_images[3]['image_url']); ?>" width="595" height="306" alt="" /></li>
	            		<li><img id="slide-img-5" src="<?php echo str_replace('medium/','',$property_images[4]['image_url']); ?>" width="595" height="306" alt="" /></li>
	            	</ul>
	            	<?php }?>
	            </div>
        	</div>
    	</div><!--slider ends-->
        <div class="floatr featured_room">
	        
        	<div class="featured_mid">
            	<h4>Featured Room</h4>
            	<?php if(count($avail_room_types) > 0 && is_array($avail_room_types)){ ?>
                <h5><?php echo $avail_room_types[0]['name']; ?></h5>
                <ul class="gallery">
                	<li><img src="<?php echo $theme_assets_url;?>images/qdeluxe.jpg" alt="" /></li>
                    <li><img src="<?php echo $theme_assets_url;?>images/qdeluxe1.jpg" alt="" /></li>
                    <li><img src="<?php echo $theme_assets_url;?>images/qdeluxe.jpg" alt="" /></li>
                </ul>
                <div class="clears"></div>
                <p>
                	<?php echo (strlen($avail_room_types[0]['description']) > 202)?substr($avail_room_types[0]['description'],0,202).' ...':$avail_room_types[0]['description']; ?>
                </p>
                <ul class="facility">
                	<li class="include"><b>Included:</b> <?php echo $avail_room_types[0]['included'];?></li>
                    <li class="exclude"><b>Non Included:</b> <?php echo $avail_room_types[0]['not_included'];?></li>
                </ul>
                <a class="Greenbox floatr W105" href="<?php echo $site_url ?>accomodations"><span class="Button_arrow"></span>Check Rates </a>
            	<div class="clears"></div>
             	<?php  } ?>
            </div><!--featured mid ends-->
           
        </div><!--featured room ends-->
    	<div class="clears"></div>
        
    	<div class="welcome" style="">
        	<h4>Welcome to <?php echo (trim($property['property_name']) != '')?$property['property_name']:'{!Property Name}'; ?></h4>
          	<div class="less" style="max-height:90px;overflow:hidden;display:block;">
				<?php if(!empty($property['long_description']))echo $property['long_description']; ?>
			</div>
			<div class="floatl ask_questions"><a href="#nodo">View more</a></div>
			<!--<div class="description-overflow"></div>-->
        </div><!--welcome ends-->
        
        <div class="weather">
                <h4>Weather</h4>
                <div class="headerRT_top">
                    <div class="floatl" style="width:105px;">
                        <div class="floatl tstorms"></div>
                        <span class="floatl f24">49<sup> 0</sup></span>
                    </div>
                    
                    <div class="floatl">
                        <span><a href="#">F</a> | <a href="#" class="non_active">C</a> Mon (Chance of Thunder Strome)</span>
                        <div class="MT15">
                            <div class="floatl"  style="width:102px;">
                                <div class="floatl clear_small"></div>
                                <div class="days floatr"><span class="DB">Tue</span> 29/50</div>
                                <div class="clears"></div>
                            </div>
                            <div class="floatl"  style="width:102px;">
                                <div class="floatl clear_small"></div>
                                <div class="days floatr"><span class="DB">Tue</span> 29/50</div>
                                <div class="clears"></div>
                            </div>
                            <div class="clears"></div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="clears"></div>
                </div>
            </div><!--weather ends-->

        <div class="clears"></div>
        
    
        <div class="innkeeper">
        	<h4>Contact The INNkeeper</h4>
            <div class="floatl">
            	<div class="floatl innkeepers"><img src="<?php echo $theme_assets_url;?>images/innkeeper.jpg" alt="" /></div>
                <div class="floatl">
                	<h6>General Manager</h6>
                    <div class="review">
                    	<ul>
                        	<li class="review2"></li>
                            <li class="review1"></li>
                            <li class="review1"></li>
                            <li class="review1"></li>
                            <li class="review1"></li>
                        </ul>
                    </div>
                    <h6>Score For  4.5  INNsights</h6>
                </div>
                <div class="clears"></div>
            </div>
            <div class="W252 floatr">
            	<div class="W203 floatr">
                	<div class="floatl ask_questions">Ask a Question   |</div>
                	<span class="floatr links">
                	<a class="call" href="#"></a>
                    <a class="skype" href="#"></a>
                    <a class="fb" href="#"></a>
                    <a class="twitter" href="#"></a>
                </span>
                	<div class="clears"></div>
                </div><!--wrapper ends-->
                <div class="clears"></div>
                <ul class="links">
                	<li class="floatl"><a class="print" href="#">Print</a></li>
                    <li class="floatl"><a class="share" href="#">Share</a></li>
                    <li class="floatl"><a class="favourites" href="#">Add to My Favorites</a></li>
                </ul>
                
            </div>
            <div class="clears"></div>
        </div><!--innkeeper ends-->
            
        <div class="weather">
                <div class="heading1"><h4 class="floatl">Our Reviews</h4> <span class="reviewlink floatr"><a href="#">Prev</a>  |  <a href="#">Next</a></span> <div class="clears"></div></div>
                 
                 
                <div class="floatl reviews">
                    <div class="reviews_detail">
                        <span class="review_inn"><span class="review_heading">"Very Good Stay"</span> Yeah,This is really a wonderful hotel with Great Location. We really enjoyed the Hotel services &amp; assistance for making our conference hit. Really appreciated there efforts &amp; will visit again.</span>
                        <a href="#">More</a><br clear="all" />
                        
                            
                    </div>
                </div>
                
                <!--reviews ends-->
                
                <div class="floatr reviewers">
                    <img src="<?php echo $theme_assets_url;?>images/reviewer.jpg" alt="" class="reviewer" />
                    <p>Atul Jadhav <img src="<?php echo $theme_assets_url;?>images/us_flag.jpg" alt="" /></p>
                    <p class="PT0">August 11, 2012</p>
                    <div class="social">
                 
                        	<a href="#" class=" yelp2"></a>
                            <a href="#" class=" trip2"></a>
                            <a href="#" class=" Gplus"></a>
                        </div>
                      
                    
                </div><!--reviewer ends-->
                
                <div class="clears"></div>
                
            </div><!--weather ends-->
    
    	<div class="clears"></div>
    
        <div class="travel_ideas">
            <h4>Travel Ideas</h4>
            <div class="idea_travel">
                <div class="content floatl">
                    <h6>Groveland</h6>
                    <img src="<?php echo $theme_assets_url;?>images/travel_ideas.jpg" alt="" class="floatl" />
                    <p>Groveland, California is a small gold rush town with a population of 3,388, located just outside the Big Oak Flat Entrance to Yosemite National Park.  The Town has always been an important stop along Highway 120 on the way to Yosemite. outside the Big Oak Flat Entrance to Yosemite National Park.  ThE HIighway 120 on the way to Yosemite is very go. &amp; attractions are many to see  <a href="#">more</a></p>
                </div><!--content ends-->
                
                <div class="floatr" id="ti_accordion">
                    <!--<img src="<?php echo $theme_assets_url;?>images/slider.jpg" alt="" />-->
                <dl>
	                <dt>Family</dt>
	                <dd><img src="<?php echo $site_url?>assets/images/p1.jpg" width="400" height="" /></dd>
	                <dt>Entertainment</dt>
	                <dd><img src="<?php echo $site_url?>assets/images/p2.jpg" width="400" height="" /></dd>
	                <dt>Children</dt>
	                <dd><img src="<?php echo $site_url?>assets/images/p3.jpg" width="400" height="" /></dd>
	                <dt>Tourist</dt>
	                <dd><img src="<?php echo $site_url?>assets/images/p4.jpg" width="400" height="" /></dd>
	                <dt>Shopping</dt>
	                <dd><img src="<?php echo $site_url?>assets/images/p4.jpg" width="400" height="" /></dd>
	                <dt>Romance</dt>
	                <dd><img src="<?php echo $site_url?>assets/images/p4.jpg" width="400" height="" /></dd>
           		</dl>
                    
                </div><!--slider ends-->
                
                <div class="clears"></div>
            </div><!--ideas ends-->
        </div><!--travel ideas ends-->
    	
        <div class="clears"></div>
        
        <div class="floatl map">
            <h4>Map &amp; Directions</h4>
            <div class="P7 idea_map">
                <img src="<?php echo $theme_assets_url;?>images/map.jpg" alt="" />
                <div class="add"><!--
                    <h6>Adante Hotel</h6>
                    <p>610 Geary Street<br />
                    San Francisco, CA, <br />
                    USA, 94102<br />
                    Phone: (415) 673-9221<br />
                    Fax: (415) 928-2434</p>
                    -->
                    
                    <?php echo (trim($property['property_name']) != '')? '<h6>'.strtoupper($property['property_name']).'</h6>':'Property name is not available'; ?>
                	<p><?php echo (trim($property['street_address']) != '')?$property['street_address'].', ':''; ?> <?php echo (trim($property['city']) != '')?$property['city'].', ':''; ?>
                            		<?php echo (trim($property['state']) != '')?$property['state']:''; ?> <?php echo (trim($property['zip_code']) != '')?$property['zip_code']:''; ?>
                            		<?php echo (trim($property['country']) != '')?"{$property['country']}":''; ?></p>
                <p>Phone: <?php $phone = explode('/',$property['primary_phone_no']);list($code, $area, $number) = explode('-',$phone[1]); echo "$phone[0] {$code} {$area}-{$number}"; ?> 
                <br />Fax: <?php $phone = explode('/',$property['facsimile_phone_no']);list($code, $area, $number) = explode('-',$phone[1]); echo " $phone[0] {$code} {$area}-{$number}"; ?></p>
            <a href="<?php echo $site_url ?>directions">Link to Directions</a>
                </div><!--add ends-->
            </div><!--container ends-->
        </div><!--map ends-->
    
        <div class="floatr hot_deal">
            <div class="heading"><h4 class="floatl">Hot Deals!</h4> <span class="reviewlink floatr"><a href="#">Prev</a>  |  <a href="#">Next</a></span> <div class="clears"></div></div>
            <div class="deals">
            <div class="deal_percentage">10% Off</div>
                <img src="<?php echo $theme_assets_url;?>images/deal.jpg" alt="" class="floatl" />
                
                <div class="floatr deal_txt">
                    <p>
                        Winter Deal! Book a stay for 5 days and save 10% on Queen Standard room!
                    </p>
                    <div class="prices">
                        <ul>
                            <li>
                                Original Price
                                <h6>65$</h6>
                            </li>
                            
                            <li>
                                Discounted Price
                                <h6>65$</h6>
                            </li>
                            
                            <li class="last">
                                You Save
                                <h6>65$</h6>
                            </li>
                        </ul>
                        <div class="clears"></div>
                        
                    </div><!--prices ends-->
                    <a class="Greenbox floatr W105" style="*margin:4px" href="#"><span class="Button_arrow"></span>Book It Now </a>
                    <div class="clears"></div>
                    
                </div><!--deal txt ends-->
                <div class="clears"></div>
            </div><!--deals ends-->
            <div class="clears"></div>
        </div><!--hot deal ends-->
    
    	<div class="clears"></div>
    </div>