<?php
class Inn extends Authenticate {
	private $_weather;
	protected $verification_code;
	/**
	 * Constructor of the class
	 *
	 * Creates the object for this class, authenticates
	 * and creates the object for weather if not created
	 *
	 * @access	public
	 * @param
	 * @return	void
	 */

	function __construct()
	{
		parent::__construct ();
		
		$this->load->model ( 'weather_model', 'weather' );
		//$weather = $this->weather->get_weather_basic ( $this->_property_info ['responseData'] ['latitude'], $this->_property_info ['responseData'] ['longitude'] );
		//check if successfully retrieved or not if then parse data
		if ($weather != 0) {
			$this->_weather = $weather;
		}
		$this->view_data['site_url'] = site_url();
		$this->view_data['base_url'] = base_url();
		$this->view_data['theme_assets_url'] = $this->view_data['base_url']."assets/themes/template2/";
		
	}
	
	function check_response_failure($response_data)
	{
		if (trim ( $response_data ['status'] ) == 'failure' && trim ( $response_data ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $response_data ['status'] ) != 'success') {
			//die($property_images['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( $this->_template.'/popup_error_message' );
			} else {
				$this->load->view ( $this->_template.'/error_message' );
			}
		}
		
	}

	/**
	 * Handles home page
	 *
	 * Displays the response of making request for handling home page
	 *
	 * @access	public
	 * @return	void
	 */
	
	function index($is_verified=0) {
		#Call 1 : 
		$uri = 'room/get_room_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', $this->_property ) . '&destination_id=' . $this->config->item ( 'destination_id', $this->_property );
		$room_details = $this->rest->{$this->method} ( $uri, $params );
		$this->check_response_failure($room_details);
		$this->view_data['$room_details'] = $room_details['responseData'];unset($room_details);

		
		#call 2 :
		$uri = 'property/get_property_images';
		$property_images = $this->rest->{$this->method} ( $uri, $params );
		$this->check_response_failure($property_images);
		$this->view_data['property_images'] = $property_images['responseData'];unset($property_images);
		
		#call 3 :
		$uri = 'room/get_room_images';
		$params = 'property_id=' . $this->config->item ( 'property_id', $this->_property ) . '&destination_id=' . $this->config->item ( 'destination_id', $this->_property );
		$room_images = $this->rest->{$this->method} ( $uri, $params );
		$this->check_response_failure($room_images);
		$this->view_data['room_images'] = $room_images['responseData'];unset($room_images);
		
		#call 4 :
		$uri = 'user/get_user_details';
		$params = "auth_user={$this->config->item('auth_user',$this->_property)}&auth_pass={$this->config->item('auth_pass',$this->_property)}";
		$user_details = $this->rest->{$this->method} ( $uri, $params );
		$this->check_response_failure($user_details);
		$this->view_data['$user_details'] = $user_details['responseData'];unset($user_details);
		
		#call 5 :
		$uri = 'property/get_review_score';
		$params = 'property_id=' . $this->config->item ( 'property_id', $this->_property );
		$review_details = $this->rest->{$this->method} ( $uri, $params );
		$this->check_response_failure($review_details);
		$this->view_data['review_details'] = $review_details['responseData'];unset($review_details);
		
		#call 6 :
		$uri = 'property/get_deals_list';
		$params = 'property_id=' . $this->config->item ( 'property_id', $this->_property ) . '&destination_id=' . $this->config->item ( 'destination_id', $this->_property );
		$deal_details = $this->rest->{$this->method} ( $uri, $params );
		$this->check_response_failure($deal_details);
		$this->view_data['deal_details'] = $deal_details['responseData'];unset($deal_details);
		
		#call 7 :
		$uri = 'property/get_reviews';
		$params = 'property_id=' . $this->config->item ( 'property_id', $this->_property ) . '&destination_id=' . $this->config->item ( 'destination_id', $this->_property );
		$user_reviews = $this->rest->{$this->method} ( $uri, $params );
		$this->check_response_failure($user_reviews);
		$this->view_data['user_reviews'] = $user_reviews['responseData'];unset($user_reviews);
		
		#call 8 :
		$uri = 'property/get_attractions_categories';
		$params = "property_id={$this->config->item('property_id',$this->_property)}&destination_id={$this->config->item('destination_id',$this->_property)}";
		$attractions = $this->rest->{$this->method} ( $uri, $params );
		$this->check_response_failure($attractions);
		$this->view_data['attractions'] = $attractions['responseData'];unset($attractions);
		
		#call 9 : 
		$avail_room_types = $this->get_available_room_types ();
		$this->view_data['avail_room_types'] = $avail_room_types;
		
		$this->view_data['no_of_rooms'] = ($this->input->post ( 'no_of_rooms' ) > 0) ? $this->input->post ( 'no_of_rooms' ) : 1;

		//set user account image added y mohan on date 6 Sep 2011
		if (empty($this->view_data['user_details']['responseData'])|| empty($this->view_data['user_details']['responseData']['user_image'])) {
			$this->view_data['user_account_img'] = $this->view_data['base_url'] . 'assets/themes/'.$this->_template.'images/myccount_image.jpg';
		} else {
			$this->view_data['user_account_img'] = $this->view_data['user_details'] ['responseData'] ['user_image'];
		}
		$this->view_data['active_tab'] = 'index';
		$this->view_data['weather'] = $this->_weather;
	 	$this->view_data['debug'] ='';
		$this->view_data['is_verified'] =$is_verified;
		$this->view_data['main_content'] ='home';
		
		if(empty($this->view_data['theme'])){
			die("Template or theme path is not set.");
		}
		$this->load->view($this->view_data['theme']."/index",$this->view_data);
		
		/*
		$this->load->view ( 'ywl/index', 
		array ('active_tab' => 'index',
		'weather' => $this->_weather, 
		'no_of_rooms' => $no_of_rooms, 
		'avail_room_types' => $avail_room_types, 
		'attractions' => $attractions ['responseData'], 
		'user_reviews' => $user_reviews ['responseData'], 
		'deal_details' => $deal_details ['responseData'],
		'property' => $this->_property_info ['responseData'],
		'review_details' => $review_details ['responseData'],
		'room_images' => $room_images ['responseData'], 
		'room_details' => $room_details ['responseData'], 
		'property_images' => $property_images ['responseData'], 
		'user_details' => $user_details ['responseData'], 
		'user_image' => $user_account_img, 
		'weather' => $this->_weather, 
		'debug' => '','is_verified'=>$is_verified ) );*/
	}

	/**
	 * Handles hotel overview
	 *
	 * Displays the response of making request for handling
	 * hotel overview
	 *
	 * @access	public
	 * @return	void
	 */

	function hotel_review() {
		//get_room_details used to set CHILD AGE LIMIT in header.php
		$uri = 'room/get_room_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
		$room_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $room_details ['status'] ) != 'success') {
			//die($room_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		
		$uri = 'property/get_property_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' );

		$property_details = $this->rest->{$this->method} ( $uri, $params );
		// echo('<pre>');print_r($property_details);echo('</pre>');exit;
		if (trim ( $property_details ['status'] ) == 'failure' && trim ( $property_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->hotel_review ();
		} elseif (trim ( $property_details ['status'] ) != 'success') {
			//die($property_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$uri = 'property/get_property_amenities';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' );

		$amenities = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $amenities ['status'] ) == 'failure' && trim ( $amenities ['error_code'] ) == 20) {
			$this->get_token ();
			$this->hotel_review ();
		} elseif (trim ( $amenities ['status'] ) != 'success') {
			//die($amenities['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$uri = 'property/get_property_images';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
		$property_images = $this->rest->{$this->method} ( $uri, $params );

		if (trim ( $property_images ['status'] ) == 'failure' && trim ( $property_images ['error_code'] ) == 20) {
			$this->get_token ();
			$this->hotel_review ();
		} elseif (trim ( $property_images ['status'] ) != 'success') {
			//die($property_images['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$uri = 'room/get_room_images';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );

		$room_images = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_images ['status'] ) == 'failure' && trim ( $room_images ['error_code'] ) == 20) {
			$this->get_token ();
			$this->hotel_review ();
		} elseif (trim ( $room_images ['status'] ) != 'success') {
			//die($room_images['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$uri = 'property/get_property_policies';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' );

		$policies = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $policies ['status'] ) == 'failure' && trim ( $policies ['error_code'] ) == 20) {
			$this->get_token ();
			$this->hotel_review ();
		} elseif (trim ( $policies ['status'] ) != 'success') {
			//die($policies['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		$images = $this->_merge_property_room_images ( $property_images ['responseData'], $room_images ['responseData'] );

		$avail_room_types = $this->get_available_room_types ();
		$no_of_rooms = ($this->input->post ( 'no_of_rooms' ) > 0) ? $this->input->post ( 'no_of_rooms' ) : 1;

		$this->load->view ( 'ywl/hotel_review', array ('active_tab' => 'hotel_review', 'weather' => $this->_weather, 'property' => $this->_property_info ['responseData'], 'amenities' => $amenities ['responseData'], 'policies' => $policies ['responseData'], 'room_images' => $room_images ['responseData'], 'property_images' => $property_images ['responseData'], 'property_details' => $property_details ['responseData'], 'images' => $images, 'weather' => $this->_weather, 'debug' => '', 'room_details' => $room_details ['responseData'] ) );
	}

	/**
	 * Merges property and room images
	 *
	 * Returns an array of merging property and room images
	 *
	 * @access	public
	 * @param	array   $property
	 * @param	array   $room
	 * @flag		string  Here flag is used to decide which imahes should come first in array ie room or properties.
	 * @return	array
	 *
	 */

	private function _merge_property_room_images($property, $room, $flag = '') {

		$images = array ();

		if ($flag == 'property' || $flag == '') {
			if (is_array ( $property ) && ! empty ( $property )) {
				$j = 0;
				foreach ( $property as $key => $prop_image ) {
					if (is_int ( $key )) {
						$images ['medium'] [$key] ['image'] = $prop_image ['image_url'];
						$images ['medium'] [$key] ['image_caption'] = $prop_image ['image_caption'];
						$images ['thumb'] [$key] ['image'] = $prop_image ['image_thumb_url'];
						$images ['thumb'] [$key] ['image_caption'] = $prop_image ['image_caption'];
					}
					$j = $key;
				}

				if (is_array ( $room ) && ! empty ( $room )) {
					foreach ( $room as $key => $room_image ) {
						if (is_int ( $key )) {
							$k = $j + $key + 1;
							$images ['medium'] [$k] ['image'] = $room_image ['image_medium_url'];
							$images ['medium'] [$k] ['image_caption'] = $room_image ['image_caption'];
							$images ['thumb'] [$k] ['image'] = $room_image ['image_url'];
							$images ['thumb'] [$k] ['image_caption'] = $room_image ['image_caption'];
						}
					}
				}
			}
		} else {

			if (is_array ( $room ) && ! empty ( $room )) {
				$j = 0;
				foreach ( $room as $key => $room_image ) {
					if (is_int ( $key )) {
						//$k = $j + $key + 1;
						$images ['medium'] [$key] ['image'] = $room_image ['image_medium_url'];
						$images ['medium'] [$key] ['image_caption'] = $room_image ['image_caption'];
						$images ['thumb'] [$key] ['image'] = $room_image ['image_url'];
						$images ['thumb'] [$key] ['image_caption'] = $room_image ['image_caption'];
					}
					$j = $key;
				}
			}
			if (is_array ( $property ) && ! empty ( $property )) {
				//$j = 0;
				foreach ( $property as $key => $prop_image ) {
					if (is_int ( $key )) {
						$k = $j + $key + 1;
						$images ['medium'] [$k] ['image'] = $prop_image ['image_url'];
						$images ['medium'] [$k] ['image_caption'] = $prop_image ['image_caption'];
						$images ['thumb'] [$k] ['image'] = $prop_image ['image_thumb_url'];
						$images ['thumb'] [$k] ['image_caption'] = $prop_image ['image_caption'];
					}
				}

			}

		}

		/*echo '//-----------------------------------------------------------------------------------------//';
        echo "<pre>";print_r($images);echo "</pre>";
        echo '//--------------------------------------------------------------------------------------------//';
        exit;*/
		return $images;
	}

	/**
	 * Gets the accomodation available
	 *
	 * Displays the response of making request for getting
	 * available accomodation
	 *
	 * @access	public
	 * @return	void
	 */

	function accomodation() {
		//    	echo $this->config->item('property_id','yosemite')."<br />";
		//    	echo('<pre>');print_r($this->config);echo('</pre>');exit;;
		//    	exit;
		$uri = 'room/get_room_details';
	 	$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
		$room_details = $this->rest->{$this->method} ( $uri, $params );
		//echo('<pre>');print_r($room_details);echo('</pre>');exit;;
		
		if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->accomodation ();
		} elseif (trim ( $room_details ['status'] ) != 'success') {
			//die($room_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		/*
         * Get Property images
         */
		$uri = 'property/get_property_images';

		$property_images = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $property_images ['status'] ) == 'failure' && trim ( $property_images ['error_code'] ) == 20) {
			$this->get_token ();
			$this->accomodation ();
		} elseif (trim ( $property_images ['status'] ) != 'success') {
			//die($property_images['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		
		

		/*
         * Get Featured/First room type images on accomodation images.
         */
		$avail_room_types = $this->get_available_room_types ();	
		//echo "<pre>";print_r($avail_room_types);echo "</pre>";exit;
		if(!empty($avail_room_types) && is_array($avail_room_types)){
				$serched_room_type_images 	= $avail_room_types [0] ['room_type_images'];
				$images 					= $this->_merge_property_room_images ( $property_images ['responseData'], $serched_room_type_images ,'room_type');
		}else{
 			$images = $this->_merge_property_room_images ( $property_images ['responseData'], array() ,'property');			
		}
		//Combine/Merge the images to show in the slider	$serched_room_type_images
				
		$no_of_rooms = ($this->input->post ( 'no_of_rooms' ) > 0) ? $this->input->post ( 'no_of_rooms' ) : 1;

		/*  	Here we are not using the room type imges function bcoz we get these from the available room type images.
 * 		We placed the room type images from the first room type.
 *
 *       $uri = 'room/get_room_images';
        $params = 'property_id=' . $this->config->item('property_id','yosemite') . '&destination_id=' . $this->config->item('destination_id','yosemite');
        $room_images = $this->rest->{$this->method}($uri, $params);
        if (trim($room_images['status']) == 'failure' && trim($room_images['error_code']) == 20)
        {
            $this->get_token();
            $this->accomodation();
        }
        elseif (trim($room_images['status']) != 'success')
        {
            //die($room_images['error']);
            if($_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {     $this->load->view('ywl/popup_error_message'); } else {     $this->load->view('ywl/error_message'); }
        }*/

		$uri = 'user/get_user_details';
		$params = "auth_user={$this->config->item('auth_user','yosemite')}&auth_pass={$this->config->item('auth_pass','yosemite')}";

		$user_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $user_details ['status'] ) == 'failure' && trim ( $user_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->accomodation ();
		} elseif (trim ( $user_details ['status'] ) != 'success') {
			//die($user_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$uri = 'property/get_review_score';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' );
		$review_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $review_details ['status'] ) == 'failure' && trim ( $review_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->accomodation ();
		} elseif (trim ( $review_details ['status'] ) != 'success') {
			//die($review_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		//code to calculate the difference between days
		$diff = strtotime ( $this->input->post ( 'room_check_out' ) ) - strtotime ( $this->input->post ( 'room_check_in' ) );
		$no_of_nights = round ( $diff / 86400 );

		//set the INKeeper Image if he has not uploaded his image
		if ($user_details ['responseData'] == "" || $user_details ['responseData'] ['user_image'] == "") {
			$user_account_img = base_url () . 'assets/css/ywl/images/myccount_image.jpg';
		} else {
			$user_account_img = $user_details ['responseData'] ['user_image'];
		}

		//dynamically get the recent booking date added by mohan on date Sep 7 2011
		$uri = 'property/get_recent_booking_by_property';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' );
		$recent_booking_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $recent_booking_details ['status'] ) == 'failure' && trim ( $recent_booking_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->accomodation ();
		} elseif (trim ( $recent_booking_details ['status'] ) != 'success') {
			//die($review_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		//$recent_booking = $recent_booking_details['responseData'] ;
		$recent_booking = $recent_booking_details ['responseData'] == 'currently no booking done' ? 'No Booking' : $recent_booking_details ['responseData'];

		$input_rapams = $_POST;

		if ($this->_property_info ['responseData'] ['child_age_limit'] == '1') {
			$input_rapams = $this->child_age_modification ( $this->_property_info ['responseData'] ['child_age_limit'], $input_rapams );
		}
		
		
		/* Author : Sunny Patwa
		 * This deal Details are used in Available Room Type Slider
		 * used to display Deal rates for particulat date instead of Base rate
		 */
		$uri = 'property/get_deals_list';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );

		$deal_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $deal_details ['status'] ) == 'failure' && trim ( $deal_details ['error_code'] ) == 20) 
		{
			$this->get_token ();
			$this->index ();
		} 
		elseif (trim ( $deal_details ['status'] ) != 'success') 
		{
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") 
			{
				$this->load->view ( 'ywl/popup_error_message' );
			} 
			else 
			{
				$this->load->view ( 'ywl/error_message' );
			}
		}
		
		$this->load->view ( 'ywl/rooms_and_rates', array ('active_tab' => 'accomodation', 'weather' => $this->_weather, 'input_params' => $input_rapams, 'no_of_nights' => $no_of_nights, 'no_of_rooms' => $no_of_rooms, 'avail_room_types' => $avail_room_types, 'property' => $this->_property_info ['responseData'], 'review_details' => $review_details ['responseData'], 'room_images' => $room_images ['responseData'], 'room_details' => $room_details ['responseData'], 'property_images' => $property_images ['responseData'], 'user_details' => $user_details ['responseData'], 'images' => $images, 'weather' => $this->_weather, 'user_image' => $user_account_img, 'recent_booking' => $recent_booking, 'debug' => '', 'deal_details' => $deal_details ['responseData'] ) );
	}

	/**
	 * Checks for child age and modifies post if needed
	 *
	 * A function which takes the input and checks if age limit is set, if yes, modifies the input as per needed
	 *
	 * @access	public
	 * @param    integer $age_limit
	 * @param    array   $criteria
	 * @return	void
	 */

	function child_age_modification($age_limit, $criteria) {
		/*echo '<pre>';
                print_r($_POST);
                echo '</pre>';
                exit;*/
		if ($age_limit == 1) {
			$child_ages = $this->input->post ( 'child' );
			$children_post = $this->input->post ( 'children' );

			$child = array ();
			for($i = 0; $i < 4; $i ++) {
				if ($child_ages [$i] != '?') {
					if ($child_ages [$i] > 12) {
						$_POST ['child'] [$i] = '?';
					}
					if (($i + 1) > $children_post [0]) {
						$_POST ['child'] [$i] = '?';
					} else {
						$child [0] [] = $child_ages [$i];
					}
				}
			}
			if (count ( $child_ages ) > 4) {
				for($i = 4; $i < 8; $i ++) {
					if ($child_ages [$i] != '?') {
						if ($child_ages [$i] > 12) {
							$_POST ['child'] [$i] = '?';
						}
						if (($i + 1) > ($children_post [1] + 4)) {
							$_POST ['child'] [$i] = '?';
						} else {
							$child [1] [] = $child_ages [$i];
						}
					}
				}
			}
			if (count ( $child_ages ) > 8) {
				for($i = 8; $i < 12; $i ++) {
					if ($child_ages [$i] != '?') {
						if ($child_ages [$i] > 12) {
							$_POST ['child'] [$i] = '?';
						}
						if (($i + 1) > ($children_post [2] + 8)) {
							$_POST ['child'] [$i] = '?';
						} else {
							$child [2] [] = $child_ages [$i];
						}
					}
				}
			}
			if (count ( $child_ages ) > 12) {
				for($i = 12; $i < 16; $i ++) {
					if ($child_ages [$i] != '?') {
						if ($child_ages [$i] > 12) {
							$_POST ['child'] [$i] = '?';
						}
						if (($i + 1) > ($children_post [3] + 12)) {
							$_POST ['child'] [$i] = '?';
						} else {
							$child [3] [] = $child_ages [$i];
						}
					}
				}
			}
			if (count ( $child_ages ) > 16) {
				for($i = 16; $i < 20; $i ++) {
					if ($child_ages [$i] != '?') {
						if ($child_ages [$i] > 12) {
							$_POST ['child'] [$i] = '?';
						}
						if (($i + 1) > ($children_post [4] + 16)) {
							$_POST ['child'] [$i] = '?';
						} else {
							$child [4] [] = $child_ages [$i];
						}
					}
				}
			}

			if (! empty ( $child )) {
				foreach ( $child as $k => $value ) {
					if (count ( $value ) == $_POST ['children'] [$k]) {
						foreach ( $value as $val ) {
							if ($val > 12) {
								$_POST ['children'] [$k] = $_POST ['children'] [$k] - 1;
								$_POST ['adults'] [$k] = $_POST ['adults'] [$k] + 1;
								$criteria ['children'] [$k] = $_POST ['children'] [$k];
								$criteria ['adults'] [$k] = $_POST ['adults'] [$k];
								$criteria ['child'] = $this->input->post ( 'child' );

							}
						}
					} else {
						// header('location:http://www.'.core_url());
					}
				}
			} else {
				if (! empty ( $_POST ['children'] ) && ($_POST ['children'] [0] != 0 || $_POST ['children'] [1] != 0 || $_POST ['children'] [2] != 0 || $_POST ['children'] [3] != 0 || $_POST ['children'] [4] != 0)) {
					//header('location:http://www.'.core_url());
				}
			}
			/*echo "after <br>";
                            echo '<pre>';
                                print_r($_POST);
                                echo '</pre>';
                                exit;*/
			return $_POST;
		}
	}

	/**
	 * Handles destination guide
	 *
	 * Displays the response of making request for getting information
	 * about destination guide
	 *
	 * @access	public
	 * @return	void
	 */

	function destination_guide() {
		//get_room_details used to set CHILD AGE LIMIT in header.php
		$uri = 'room/get_room_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
		$room_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $room_details ['status'] ) != 'success') {
			//die($room_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		
		$uri = 'property/get_destination_details';
		$params = 'destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );

		$result = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $result ['status'] ) == 'failure' && trim ( $result ['error_code'] ) == 20) {
			$this->get_token ();
			$this->destination_guide ();
		} elseif (trim ( $result ['status'] ) != 'success') {
			//die($result['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$attraction_cats = array ();

		if ($this->input->post ( 'attraction_cats' ) != '' && strtolower ( trim ( $this->input->post ( 'inspire_me' ) ) ) == 'inspire me') {
			$attraction_cats = $this->input->post ( 'attraction_cats' );
		}
		$attraction_cat = implode ( ',', $attraction_cats );

		$uri = 'property/get_attractions_list';
		if ($attraction_cat != '') {
			$params = "property_id={$this->config->item('property_id','yosemite')}&destination_id={$this->config->item('destination_id','yosemite')}&attraction_cats={$attraction_cat}";
		} else {
			$params = "property_id={$this->config->item('property_id','yosemite')}&destination_id={$this->config->item('destination_id','yosemite')}";
		}

		$attractions = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $attractions ['status'] ) == 'failure' && trim ( $attractions ['error_code'] ) == 20) {
			$this->get_token ();
			$this->destination_guide ();
		} elseif (trim ( $attractions ['status'] ) != 'success') {
			//die($attractions['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$uri = 'property/get_attractions_categories';
		$params = "property_id={$this->config->item('property_id','yosemite')}&destination_id={$this->config->item('destination_id','yosemite')}";

		$attraction_categories = $this->rest->{$this->method} ( $uri, $params );

		if (trim ( $attraction_categories ['status'] ) == 'failure' && trim ( $attraction_categories ['error_code'] ) == 20) {
			$this->get_token ();
			$this->destination_guide ();
		} elseif (trim ( $attraction_categories ['status'] ) != 'success') {
			//die($attraction_categories['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$this->load->view ( 'ywl/destination_guide', array ('active_tab' => 'destination_guide', 'map_key' => $this->config->item ( 'map_key', 'yosemite' ), 'weather' => $this->_weather, 'property' => $this->_property_info ['responseData'], 'destination' => $result ['responseData'], 'attractions' => $attractions ['responseData'], 'attraction_categories' => $attraction_categories ['responseData'], 'weather' => $this->_weather, 'attraction_cats' => $attraction_cats, 'debug' => '', 'room_details' => $room_details ['responseData'] ) );
	}

	/**
	 * Shows the view for directions
	 *
	 * Displays the view for map and directions
	 *
	 * @access	public
	 * @return	void
	 */

	function directions($address = '') {
		//get_room_details used to set CHILD AGE LIMIT in header.php
		$uri = 'room/get_room_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
		$room_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $room_details ['status'] ) != 'success') {
			//die($room_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		
		$this->load->view ( 'ywl/map_view', array ('active_tab' => 'directions', 'weather' => $this->_weather, 'map_key' => $this->config->item ( 'map_key', 'yosemite' ), 'property' => $this->_property_info ['responseData'], 'result' => 'this is result', 'weather' => $this->_weather, 'debug' => '', 'room_details' => $room_details ['responseData'],'attraction_addr'=>$address ) );
	}

	/**
	 * Shows the view for log in
	 *
	 * Displays the view for logging in the user
	 *
	 * @access	public
	 * @return	void
	 */

	function sign_in() {
		$this->load->view ( 'ywl/sign_in', array ('property' => $this->_property_info ['responseData'] ) );
	}

	/**
	 * Authenticates user login
	 *
	 * Displays the response of making request for authenticating
	 * user login module
	 *
	 * @access	public
	 * @return	void
	 */

	function authenticate_login() 
	{
		$uri = 'user/authenticate_user_login';
		$params = "login_user={$this->input->post('username')}&login_pass={$this->input->post('password')}";
		
		$user_details = $this->rest->{$this->method} ( $uri, $params );

		if (trim ( $user_details ['status'] ) == 'failure' && trim ( $user_details ['error_code'] ) == 20) 
		{
			$this->get_token ();
			$this->authenticate_login ();
		} 
		elseif (trim ( $user_details ['status'] ) != 'success') 
		{
			echo json_encode ( array ('failure' => 'true' ) );
			exit;
		} 
		else 
		{
			if ($user_details ['result'] == 'array' && $user_details ['responseData'] ['auth_user'] != '') 
			{
				//print_r($user_details['responseData']);exit;
				if($user_details['responseData']['is_verified']!=1)
				{
					//when user is not active and not veified
					echo json_encode ( array ('email' => $user_details['responseData']['email'],
											  'code'  => $user_details['responseData']['verification_code'],
											  'firstname'  => $user_details['responseData']['firstname'],
											  'lastname'  => $user_details['responseData']['lastname']) );
					exit;
				}
				else
				{
					//when user is active and verified
					$this->session->set_userdata ( 'yosemite_user', $user_details ['responseData'] );
					echo json_encode ( array ('success' => 'true' ) );
					die ();
				}
			} 
			else
			{
				//when some error occured
				$this->session->unset_userdata ( 'yosemite_user' );
				echo json_encode ( array ('failure' => 'true' ) );
				die ();
			}
		}
	}
	
	function resend_verification_code() 
	{
			$user_data['email'] = $this->input->post('email');
    		$user_data['name'] = $this->input->post('firstname')." ".$this->input->post('lastname');  
    		$user_data['verification_code'] = $this->input->post('code');
    		$user_data['url'] = $this->config->item('bin_url');
    		$user_data['property_id'] = $this->_property_info ['responseData']['property_id'];
    		
    		$mail_data	= 	$this->load->view('ywl/email_resend_verification_code',$user_data,true);

    		$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			$this->email->set_mailtype('html');
    						
    		$this->email->from('innteract@gmail.com', 'INNsight Admin');
    		$this->email->to($this->input->post('email'));
    		if($this->config->item('bin_url')=='https://www.innsight.com' || $this->config->item('bin_url')=='https://www.innsight.com/')
        	{
        		$this->email->cc($this->input->post('email'));//do not delete CC otherwise system will not shoot the mail.
        		$this->email->bcc('leadership@innsight.com');
        	}
        	else
        	{
        		$this->email->cc('nikhil.shah@innsight.com');//do not delete CC otherwise system will not shoot the mail.
        		$this->email->bcc('sunny.patwa@innsight.com');
        	}
    		$this->email->subject('Verification Code');
			$this->email->message($mail_data);
			if($this->email->send())
    		{
    			echo "success";
			} 
			else 
			{
				echo "***ERROR***";
			}
    }

	/**
	 * Get filtered attraction categories
	 *
	 * Displays the response of making request for getting filtered caegories
	 *
	 * @access	public
	 * @return	void
	 */

	function get_filtered_attraction_cats() {
		$uri = 'property/get_attractions_list';
		$params = "property_id={$this->config->item('property_id','yosemite')}&destination_id={$this->config->item('destination_id','yosemite')}&attraction_cats={$this->input->post('attraction_cats')}&order_by={$this->input->post('order_by')}&lat={$this->_property_info['latitude']}&lon={$this->_property_info['longitude']}";

		$attraction_categories = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $attraction_categories ['status'] ) == 'failure' && trim ( $attraction_categories ['error_code'] ) == 20) {
			$this->get_token ();
			$this->get_filtered_attraction_cats ();
		} elseif (trim ( $attraction_categories ['status'] ) != 'success') {
			//die($attraction_categories['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		} else {
			$this->load->view ( 'ywl/filtered_categories', array ('attractions' => $attraction_categories ['responseData'], 'debug' => '' ) );
		}
	}

	/**
	 * Get available room types
	 *
	 * Returns an array of making request for getting available room types
	 *
	 * @access	public
	 * @return	mixed
	 */

	function get_available_room_types() {
		$uri = 'room/get_available_room_types';
		if(!empty($_POST ['adults']))
			$cnt = count ( $_POST ['adults'] );
		else $cnt = 0;

		$no_of_adults = array ();
		for($i = 0; $i < $cnt; $i ++) {
			$no_of_adults [] = $_POST ['adults'] [$i] + $_POST ['children'] [$i];
		}
		$no_of_guests = @max ( $no_of_adults );

		$no_of_guests = ($no_of_guests > 0) ? $no_of_guests : 2;
		$start_date = (trim ( $this->input->post ( 'room_check_in' ) != '' ) != '') ? $this->input->post ( 'room_check_in' ) : date ( 'm/d/Y', time () );
		$end_date = (trim ( $this->input->post ( 'room_check_out' ) != '' ) != '') ? $this->input->post ( 'room_check_out' ) : date ( 'm/d/Y', time () + 86400 );
		$no_of_rooms = (trim ( $this->input->post ( 'no_of_rooms' ) != '' ) != '') ? $this->input->post ( 'no_of_rooms' ) : 1;

		$guests = array ();
		for($i = 0; $i < $no_of_rooms; $i ++) {
			$guests [$i] ['num_adult'] = $_POST ['adults'] [$i];
			$guests [$i] ['num_child'] = $_POST ['children'] [$i];

			for($j = 0; $j < $_POST ['children'] [$i]; $j ++) {
				$k = 4 * $i + $j;
				$guests [$i] ['child_age'] [] = $_POST ['child'] [$k];
			}
		}
		$total_guests = @serialize ( $guests );

		$params = "property_id={$this->config->item('property_id','yosemite')}&destination_id={$this->config->item('destination_id','yosemite')}&start_date={$start_date}&end_date={$end_date}&no_of_guests={$no_of_guests}&no_of_rooms={$no_of_rooms}&total_guests={$total_guests}&child_ages={$this->input->post('child_ages')}";

		$room_type_details = $this->rest->{$this->method} ( $uri, $params );
	
		
		if (trim ( $room_type_details ['status'] ) == 'failure' && trim ( $room_type_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->get_available_room_types ();
		} else {
			$this->check_response_failure($room_type_details);
		}
		return $room_type_details ['responseData'];
		
	}

	/**
	 * Sign outs the user
	 *
	 * Clears the session and redirects to the home page
	 *
	 * @access	public
	 * @return	void
	 */

	function sign_out() {
		$this->session->unset_userdata ( 'yosemite_user' );
		redirect ( '/yosemite' ); //die; if($_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {     $this->load->view('ywl/popup_error_message'); } else {     $this->load->view('ywl/error_message'); }
	}

	/**
	 * Adds to users favourite
	 *
	 * Displays the result of making request for adding users favourite
	 *
	 * @access	public
	 * @return	void
	 */

	function add_to_favourite() {
		$uri = 'user/add_to_favourite';
		$params = "property_id={$this->config->item('property_id','yosemite')}&user_id={$this->session->userdata['yosemite_user']['api_user_id']}";

		$favourite_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $favourite_details ['status'] ) == 'failure' && trim ( $favourite_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->add_to_favourite ();
		} elseif (trim ( $favourite_details ['status'] ) != 'success') {
			//die($favourite_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		} else {
			$this->session->set_flashdata ( 'favourite_success', 'This property has been added successfully to your favourites.' );
			redirect ( '/yosemite' ); //die; if($_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {     $this->load->view('ywl/popup_error_message'); } else {     $this->load->view('ywl/error_message'); }
		}
	}

	/**
	 * Resets the password
	 *
	 * Displays the response of resetting the password with request to innsight server
	 *
	 * @access	public
	 * @return	void
	 */

	function reset_pass() 
	{
		$ch = curl_init();

        $data = array('email' => trim($this->input->post('email')));
        if($this->config->item('bin_url')=='https://www.innsight.com' || $this->config->item('bin_url')=='https://www.innsight.com/')
        {
        	curl_setopt($ch, CURLOPT_URL, 'http://www.innsight.com/reset/request');
        }
        else
        {
        	curl_setopt($ch, CURLOPT_URL, $this->config->item('bin_url').'/reset/request');
        }
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_exec($ch);        
        curl_close($ch);
	}

	/**
	 * Adds attraction details
	 *
	 * Displays the response of getting attraction details of the given attraction
	 *
	 * @access	public
	 * @return	void
	 */

	function attraction_details($id) {
		$uri = 'property/get_attraction_details';
		$params = 'attraction_id=' . $id;

		$result = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $result ['status'] ) == 'failure' && trim ( $result ['error_code'] ) == 20) {
			$this->get_token ();
			$this->attraction_details ();
		} elseif (trim ( $result ['status'] ) != 'success') {
			//die($result['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$this->load->view ( 'ywl/attraction_details', array ('active_tab' => 'attraction_details', 'map_key' => $this->config->item ( 'map_key', 'yosemite' ), 'weather' => $this->_weather, 'property' => $this->_property_info ['responseData'], 'attraction' => $result ['responseData'], 'debug' => '' ) );
	}

	/**
	 * Shows the view for Registration
	 *
	 * Displays the view for registering the user
	 *
	 * @access	public
	 * @return	void
	 */

	function register() {
		$this->load->view ( 'ywl/registration', array ('property' => $this->_property_info ['responseData'] ) );
	}

	/**
	 * Registers user on INNsight.
	 *
	 * Displays the response of making request for registration
	 * This function is called using AJAX
	 *
	 * @access	public
	 * @return	void
	 */

	function register_user() 
	{
		
		$uri = 'user/register_user';
		$details = urldecode ( $this->input->post ( 'details' ) );
		$params = $details;
		$registration_details = $this->rest->{$this->method} ( $uri, $params );

		///echo $this->rest->debug();exit;

		if (trim ( $registration_details ['status'] ) == 'failure' && trim ( $registration_details ['error_code'] ) == 100) 
		{
			echo json_encode ( array ('faliure' => $registration_details ['responseData'] ) );
		} 
		elseif (trim ( $deal_details ['status'] ) == 'failure' && trim ( $deal_details ['error_code'] ) == 20) 
		{
			$this->get_token ();
			$this->index ();
		} 
		elseif (trim ( $registration_details ['status'] ) != 'success') 
		{
			echo json_encode ( array ('faliure' => $registration_details ['responseData'] ) );
		} 
		else 
		{
			$this->verification_code = $registration_details ['responseData'];
			echo json_encode ( array ('success' => 'true' ) );
		}

	}

	/**
	 *
	 * Verifies user after registration. // Modified by PK at 16Nov 11
	 *
	 * @return unknown_type
	 */
	function verify_user() {
		$verification_code_post = $this->input->post ( 'verification_code' );
		$uri = 'user/verify_user';
		$params = "verification_code={$verification_code_post}&user_email_to_verify=".$this->input->post ( 'user_email' );
		//$params = "verification_code=128&user_email_to_verify=linktoprashsdsant@aol.in";
		$verification_details = $this->rest->{$this->method} ( $uri, $params );
		//echo $this->rest->debug();
		
		if (trim ( $verification_details ['status'] ) == 'failure' && trim ( $verification_details ['error_code'] ) == 10) {
			echo json_encode ( array ('faliure' => $verification_details ['responseData'] ) );exit;
		} elseif (trim ( $verification_details ['status'] ) == 'failure' && trim ( $verification_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $verification_details ['status'] ) != 'success') {
			echo json_encode ( array ('faliure' => $verification_details ['responseData'] ) );exit;
		} else {
			$userdata = unserialize ( $verification_details ['responseData'] );
			$this->session->set_userdata ( 'yosemite_user', $userdata );
			echo json_encode ( array ('success' => 'true' ) );
			exit;
		}
		

	}

	/**
	 * Handles gallery page.
	 *
	 * @return unknown_type
	 */
	function gallery() {
		//get_room_details used to set CHILD AGE LIMIT in header.php
		$uri = 'room/get_room_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
		$room_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $room_details ['status'] ) != 'success') {
			//die($room_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		
		$uri = 'property/get_property_images';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );

		$property_images = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $property_images ['status'] ) == 'failure' && trim ( $property_images ['error_code'] ) == 20) {
			$this->get_token ();
			$this->hotel_review ();
		} elseif (trim ( $property_images ['status'] ) != 'success') {
			//die($property_images['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$uri = 'room/get_room_images';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );

		$room_images = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_images ['status'] ) == 'failure' && trim ( $room_images ['error_code'] ) == 20) {
			$this->get_token ();
			$this->hotel_review ();
		} elseif (trim ( $room_images ['status'] ) != 'success') {
			//die($room_images['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}

		$images = $this->_merge_property_room_images ( $property_images ['responseData'], $room_images ['responseData'] );
		$this->load->view ( 'ywl/gallery', array ('active_tab' => 'gallery', 'weather' => $this->_weather, 'map_key' => $this->config->item ( 'map_key', 'yosemite' ), 'property' => $this->_property_info ['responseData'], 'result' => 'this is result', 'weather' => $this->_weather, 'debug' => '', 'images' => $images, 'room_details' => $room_details ['responseData'] ) );

	}

	/**
	 * Shows terms and conditions
	 *
	 * Displays the view for innsight terms and conditions
	 *
	 * @access	public
	 * @return	void
	 */
	function terms_conditions() {
		//get_room_details used to set CHILD AGE LIMIT in header.php
		$uri = 'room/get_room_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
		$room_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $room_details ['status'] ) != 'success') {
			//die($room_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		$this->load->view ( 'ywl/terms_conditions', array ('active_tab' => 'terms', 'weather' => $this->_weather, 'property' => $this->_property_info ['responseData'], 'debug' => '', 'room_details' => $room_details ['responseData'] ) );
	}

	/**
	 * Shows privacy policy
	 *
	 * Displays the view for innsight privacy policy
	 *
	 * @access	public
	 * @return	void
	 */

	function privacy_policy() {
		//get_room_details used to set CHILD AGE LIMIT in header.php
		$uri = 'room/get_room_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
		$room_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $room_details ['status'] ) != 'success') {
			//die($room_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		
		$this->load->view ( 'ywl/privacy_policy', array ('active_tab' => 'privacy_policy', 'weather' => $this->_weather, 'property' => $this->_property_info ['responseData'], 'debug' => '', 'room_details' => $room_details ['responseData'] ) );
	}

	/**
	 * Handles guest rooms tab.
	 *
	 * @return unknown_type
	 */
	function guestrooms() {
		$uri = 'room/get_room_details';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );

		$room_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->index ();
		} elseif (trim ( $room_details ['status'] ) != 'success') {
			//die($room_details['error']);
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
				$this->load->view ( 'ywl/popup_error_message' );
			} else {
				$this->load->view ( 'ywl/error_message' );
			}
		}
		$this->load->view ( 'ywl/guest_rooms', array ('active_tab' => 'guest_rooms', 'weather' => $this->_weather, 'map_key' => $this->config->item ( 'map_key', 'yosemite' ), 'property' => $this->_property_info ['responseData'], 'result' => 'this is result', 'weather' => $this->_weather, 'debug' => '', 'room_details' => $room_details ['responseData'] ) );

	}

	function person_cluetip() {
		$uri = 'user/get_user_details';
		$params = "auth_user={$this->config->item('auth_user','yosemite')}&auth_pass={$this->config->item('auth_pass','yosemite')}";
		$user_details = $this->rest->{$this->method} ( $uri, $params );
		if (trim ( $user_details ['status'] ) == 'failure' && trim ( $user_details ['error_code'] ) == 20) {
			$this->get_token ();
			$this->person_cluetip ();
		}
		echo $this->load->view ( 'ywl/person_info', array ('user_details' => $user_details ['responseData'] ) );
	}

	/*
     * Purpose : to implement 6+ booking page
     *
     *
     * Author: Sunny Patwa
     */
	function six_plus_booking() {
		if (empty ( $_POST )) {
			$this->load->helper ( 'form' );
			$this->load->library ( 'form_validation' );
			//list the amenities
			$uri = 'property/get_property_amenities';
			$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' );
			$amenities = $this->rest->{$this->method} ( $uri, $params );
			if (trim ( $amenities ['status'] ) == 'failure' && trim ( $amenities ['error_code'] ) == 20) {
				$this->get_token ();
				$this->six_plus_booking ();
			} elseif (trim ( $amenities ['status'] ) != 'success') {
				if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
					$this->load->view ( 'ywl/popup_error_message' );
				} else {
					$this->load->view ( 'ywl/error_message' );
				}
			}
			echo $this->load->view ( 'ywl/six_plus_booking', array ('active_tab' => 'six_plus_page', 'property' => $this->_property_info ['responseData'], 'amenity_list' => $amenities ['responseData'], 'weather' => $this->_weather ) );
		} 
		else 
		{
			$user_data['property_name']	= $this->_property_info['responseData']['property_name'];
    		$user_data['firstname'] = $this->input->post('firstname');
    		$user_data['lastname'] = $this->input->post('lastname');    					
    		$user_data['contact_preference'] = $this->input->post('contact_preference');
    		$user_data['phone'] = $this->input->post('phone');
    		$user_data['email'] = $this->input->post('email');    					
    		$user_data['checkin'] = $this->input->post('checkin');
    		$user_data['checkout'] = $this->input->post('checkout');
    		$user_data['trip_type'] = $this->input->post('trip_type');
    		$user_data['no_rooms'] = $this->input->post('no_rooms');
    		
    		$mail_data	= 	$this->load->view('ywl/email_sixplusbooking',$user_data,true);

    		$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			$this->email->set_mailtype('html');
    						
    		$this->email->from('request@innsight.com', 'Group Booking');
    		$this->email->to($this->_property_info['responseData']['email']);    		
    		
    		if($this->config->item('bin_url')=='https://www.innsight.com' || $this->config->item('bin_url')=='https://www.innsight.com/')
        	{
        		$this->email->cc($this->_property_info['responseData']['email']);//do not delete CC otherwise system will not shoot the mail.
        		$this->email->bcc('leadership@innsight.com');
        	}
        	else
        	{
        		$this->email->cc('nikhil.shah@innsight.com');//do not delete CC otherwise system will not shoot the mail.
        		$this->email->bcc('sunny.patwa@innsight.com');
        	}
    		
    		$this->email->subject('Group Booking Request Form for '.$user_data['property_name']);
			$this->email->message($mail_data);
			if($this->email->send())
    		{
    			echo "success";
			} 
			else 
			{
				echo "***ERROR***";
			}
		}
	}
	function testing() {

		$uri = 'user/get_user_details';
		$params = "auth_user={$this->config->item('auth_user','yosemite')}&auth_pass={$this->config->item('auth_pass','yosemite')}";

		$user_details = $this->rest->{$this->method} ( $uri, $params );
		print_r ( $user_details );
		echo '</pre>';
		exit ();
		$val = $this->get_property_info ();
		echo "<pre>";
		print_r ( $val );
		echo "<pre>";
		print_r ( $this->_weather );

	}

	//START:03OCT2011:Author-Sunny:used to implement ASK A QUESTION.
	function askquestion() 
	{
		if(empty($_POST))
    	{
    		$this->load->view('ywl/ask_question');
    	}
    	else
    	{
    		$user_data['property_name']	= $this->_property_info['responseData']['property_name'];
    		$user_data['message_subject'] = $this->input->post('message_subject');
    		$user_data['message_from'] = $this->input->post('message_from');    					
    		$user_data['msg'] = $this->input->post('msg');
    		
    		$mail_data	= 	$this->load->view('ywl/email_askquestion',$user_data,true);

    		$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			$this->email->set_mailtype('html');
    						
    		$this->email->from('request@innsight.com', 'Enquiry');
    		$this->email->to($this->_property_info['responseData']['email']);
    		if($this->config->item('bin_url')=='https://www.innsight.com' || $this->config->item('bin_url')=='https://www.innsight.com/')
        	{
        		$this->email->cc($this->_property_info['responseData']['email']);//do not delete CC otherwise system will not shoot the mail.
        		$this->email->bcc('leadership@innsight.com');
        	}
        	else
        	{
        		$this->email->cc('nikhil.shah@innsight.com');//do not delete CC otherwise system will not shoot the mail.
        		$this->email->bcc('sunny.patwa@innsight.com');
        	}
    		$this->email->subject('Ask a question');
			$this->email->message($mail_data);
			if($this->email->send())
    		{
    			echo "success";
			} 
			else 
			{
				echo "***ERROR***";
			}
    	}
	}
	 //END:03OCT2011:Author-Sunny:used to implement ASK A QUESTION.
	
	
	function deals($id='')
    {
    	$deal_id=$id;
    	
    	/*
    	 * Author:Sunny Patwa
    	 * used to find ALL DEAL details
    	 */
    	$uri = 'property/get_deals_list';
		$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
	
		$deal_details = $this->rest->{$this->method} ($uri, $params);
		if (trim ( $deal_details ['status'] ) == 'failure' && trim ( $deal_details ['error_code'] ) == 20) 
		{
			$this->get_token ();
			$this->deals($deal_id);
		} 
		elseif (trim ( $deal_details ['status'] ) != 'success') 
		{		
			if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") 
			{
				$this->load->view ( 'ywl/popup_error_message' );
			}
			else 
			{
				$this->load->view ( 'ywl/error_message' );
			}
		}

    	/*
    	 * used to find require DEAL details
    	 */
    	foreach($deal_details ['responseData'] as $key=>$value)
		{
			if(is_numeric($key))
			{
				if($deal_id==$value['deal_id'])
				{						
						//$deal_start=strtotime($value['deal_start']);
						//$deal_end=strtotime($value['deal_end']);
						//$min_no_of_nights=$value['num_of_days'];	
						$req_deal_details=$value;	
						$room_type_id=$value['room_type_id'];	
				}
			}
		}
    	
    	if (empty ( $_POST )) 
    	{	
    		
			
			//$checkin_date=$deal_start;
			//$checkout_date=86400 * $min_no_of_nights + $checkin_date;
	    	//$_POST['room_check_in']=date('m/d/Y', $checkin_date);
	    	//$_POST['room_check_out']=date('m/d/Y', $checkout_date);
	    	//$avail_room_types = $this->get_available_room_types ();
			
			/*
    		 * used to find ALL ROOM TYPE details
    		 */
			$uri = 'room/get_room_details';
			$params = 'property_id=' . $this->config->item ( 'property_id', 'yosemite' ) . '&destination_id=' . $this->config->item ( 'destination_id', 'yosemite' );
			$room_details = $this->rest->{$this->method} ( $uri, $params );
			if (trim ( $room_details ['status'] ) == 'failure' && trim ( $room_details ['error_code'] ) == 20) 
			{
				$this->get_token ();
				$this->deals($deal_id);
			} 
			elseif (trim ( $room_details ['status'] ) != 'success') 
			{
				//die($room_details['error']);
				if ($_SERVER ['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") 
				{
					$this->load->view ( 'ywl/popup_error_message' );
				}
				else 
				{
					$this->load->view ( 'ywl/error_message' );
				}
			}
			
			/*
    		 * used to find require ROOM TYPE details
    		 */
			foreach($room_details['responseData'] as $key_room_details=>$value_room_details)
			{
				if(is_numeric($key_room_details))
				{
					if($room_type_id==$value_room_details['room_type_id'])
					{
						$req_room_details=$value_room_details;
					}
				}
			}
			//print_r($req_room_details);
			//exit;		
			
	    	$this->load->view('ywl/deals_step1.php',array ('deal_id' => $deal_id, 'deal_details' => $req_deal_details, 'room_details' => $req_room_details));
    	}
    	else 
    	{
    		/*foreach($deal_details ['responseData'] as $key=>$value)
			{
				if(is_numeric($key))
				{
					if($deal_id==$value['deal_id'])
					{
						$room_type_id=$value['room_type_id'];//used in below foreach loop
						$req_deal_details=$value;
					}
				}
			}*/
			
			
	    	
			//used to create a post array
			$details = urldecode ( $this->input->post ( 'details' ) );
			$a = explode('&', $details);
			unset($_POST);//used to unset the previous post data
			$_POST=array();
			$j=0;
			$k=0;
			$l=0;
			for($i = 0;$i < count($a);$i++) 
			{
				$b = split('=', $a[$i]);
				if(htmlspecialchars($b[0])=='adults[]')
				{
					$_POST['adults'][$j]=htmlspecialchars($b[1]);
					$j++;
				}
				elseif(htmlspecialchars($b[0])=='children[]')
				{
					$_POST['children'][$k]=htmlspecialchars($b[1]);
					$k++;
				}
				elseif(htmlspecialchars($b[0])=='child[]')
				{
					$_POST['child'][$l]=htmlspecialchars($b[1]);
					$l++;
				}
				else
				{
					$_POST[htmlspecialchars($b[0])]=htmlspecialchars($b[1]);
				}
								    
			}
			//after setting a post array we are calling the below function
    		$avail_room_types = $this->get_available_room_types ();
    		
    		$room_available='false';
    		
    		if(is_array($avail_room_types))
    		{
		    	foreach($avail_room_types as $key_room=>$value_room)
				{
					if(is_numeric($key_room))
					{
						if($room_type_id==$value_room['id'])
						{
							if($value_room['is_available']=='N' || $value_room['vacant_rooms']< $_POST['no_of_rooms'] || $value_room['deal_id'] == '' )
							{
								//echo "Not Available";
								@mail('sunny.patwa3@gmail.com','Yosemite Deal-Not Available',print_r($avail_room_types,true));
								$room_available="not_available";
								//exit;
							}
							else
							{
								$room_available='true';
								$this->load->view('ywl/deals_step2.php',array ( 'post_value' => $_POST,'avail_room_types' => $avail_room_types[$key_room],'deal_details' => $req_deal_details));
								//exit;
								
							}
							
						}
					}
				}
    		}
    		else
    		{
    			//used when all rooms are blocked for particular date. In this, the rest server returns a  NO VACANCY string 
    			//echo "Not Vacancy ";
    			$room_available="no_vacancy";
    			//exit;
    		}
    		if($room_available!='true')
    		{
    			echo $room_available;
    		}
    	}
    }

}