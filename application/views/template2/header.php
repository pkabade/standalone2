<?php
$max_age_of_child=($room_details[0]['child_age_limit']==1)?12:17;
$input_params['child'] = @array_chunk($input_params['child'], 4);
switch(round($review_details['review_score']))
{
		case 0.5: $review_class = 'halfrating'; break;
		
		 case 1: $review_class = 'onerating'; break;
		
		 case 1.5: $review_class = 'onehalfrating'; break;
		
		 case 2: $review_class = 'tworating'; break;
		
		 case 2.5: $review_class = 'twohalfrating'; break;
		
		 case 3: $review_class = 'threerating'; break;
		
		 case 3.5: $review_class = 'threehalfrating'; break;
		
		 case 4: $review_class = 'fourrating'; break;
		
		 case 4.5: $review_class = 'fourhalfrating'; break;
		
		 case 5: $review_class = 'fiverating'; break;
		
		 default: $review_class = 'norating'; break;
}
?>
<div class="header">
        <div class="top">
        	<div class="floatl logo"><img src="<?php echo $site_url ?>assets/themes/template2/images/Logo.png" alt="" width="120" height="99" /></div><!--logo ends-->
            <div class="floatl name">
            	<?php echo (trim($property['property_name']) != '')? '<h4 style="font-size:23px;">'.strtoupper($property['property_name']).'</h4>':'Property name is not available'; ?>
                <p><?php echo (trim($property['street_address']) != '')?$property['street_address'].', ':''; ?> <?php echo (trim($property['city']) != '')?$property['city'].', ':''; ?>
                            		<?php echo (trim($property['state']) != '')?$property['state']:''; ?> <?php echo (trim($property['zip_code']) != '')?$property['zip_code']:''; ?>
                            		<?php echo (trim($property['country']) != '')?"{$property['country']}":''; ?></p>
                <p>Phone: <?php $phone = explode('/',$property['primary_phone_no']);list($code, $area, $number) = explode('-',$phone[1]); echo "$phone[0] {$code} {$area}-{$number}"; ?> Fax: <?php $phone = explode('/',$property['facsimile_phone_no']);list($code, $area, $number) = explode('-',$phone[1]); echo " $phone[0] {$code} {$area}-{$number}"; ?></p>
            </div><!--name ends-->
            
            <div class="top_rht floatr">
            <div class="signin">
            	<a href="javascript:;" class="signin_link">Sign In</a> |
                <a href="javascript:;" class="register_link">Register</a> |
                <a href="javascript:;" class="help_link">Help</a>
            </div><!--sign in ends-->
            
            <div class="availability">
            	<a href="javascript:;" class="arrow">Check Availability</a>
                <div class="clears"></div>
                <div class="availability_box" style="display:none;">
                	<a class="floatr close" href="javascript:;"><img alt="" src="<?php echo $theme_assets_url;?>images/close.jpg"></a>
                    <div class="clears"></div>
              <div class="chkin floatl">
				  <span class="floatl P7">Check In</span>
   				  <input type="text" name="room_check_in" style="width:102px;" id="check_in_date" value="<?php echo (trim($input_params['room_check_in']) != '')? date('m/d/Y', strtotime($input_params['room_check_in'])):date('m/d/Y', time()) ?>" readonly />
			  </div>
                    
              <div class="chkin floatl">
				  <span class="floatl P7">Check Out</span>
   				  <input type="text" name="room_check_out" style="width:102px;" id="check_out_date" value="<?php echo (trim($input_params['room_check_out']) != '')? date('m/d/Y', strtotime($input_params['room_check_out'])): date('m/d/Y', time() + 86400) ?>" readonly />
			  </div>
                    <div class="clears"></div>
                    
                    <div class="PT7 chkin floatl ML17">
    					<span class="chkin">Rooms</span>
        				<select class="innbox1">
                        	<option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
    				</div>
                    
                    <div class="PT7 floatr total">1 room, 1 adults, 1 children</div>
                    <div class="clears"></div>
                    <ul>
                    	<li class="last">&nbsp;</li>
                        <li>Adults</li>
                        <li>Children</li>
                        <li>Ages of children*</li>
                    </ul>
                    <div class="clears"></div>
                    <ul>
                    	<li class="last">Room 1:</li>
                        <li>
                        	<select class="innbox1">
                        		<option>1</option>
                            	<option>2</option>
                            	<option>3</option>
                            	<option>4</option>
                        	</select>
                        </li>
                        <li>
                        	<select class="innbox1">
                        		<option>1</option>
                            	<option>2</option>
                            	<option>3</option>
                            	<option>4</option>
                        	</select>
                        </li>
                        <li>
                        	<select class="innbox1">
                        		<option>1</option>
                            	<option>2</option>
                            	<option>3</option>
                            	<option>4</option>
                        	</select>
                            
                            <select class="innbox1">
                        		<option>1</option>
                            	<option>2</option>
                            	<option>3</option>
                            	<option>4</option>
                        	</select>
                            
                            <select class="innbox1">
                        		<option>1</option>
                            	<option>2</option>
                            	<option>3</option>
                            	<option>4</option>
                        	</select>
                            
                            <select class="innbox1">
                        		<option>1</option>
                            	<option>2</option>
                            	<option>3</option>
                            	<option>4</option>
                        	</select>
                        </li>
                    </ul>
                    <div class="clears"></div>
                    <div class="travel">*Children above 12 are considered an Adult</div>
                     <div class="SCA"> *Age at time of travel</div>
                    <div class="clears"></div>
                </div>
            </div><!--availability ends-->
            <div class="clears"></div>
            
        </div><!--availability ends-->  
        <div class="clears"></div>  
        </div><!--top ends-->
    </div><!--header ends-->