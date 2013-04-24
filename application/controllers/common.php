<?php
class Common extends Authenticate
{

	function __construct()
	{
		parent::Authenticate();
	}
	function index(){
		//echo 	$auth_id = $this->config->item('auth_id');
	}
	/*
	 * Ajax call for get all States of country. - PK 
	 */
	
	function get_states(){
		$country = $this->input->post('country');
		//$country = "USA";	
		
		if(empty($country)){
			die('false'); 
		}
		
		$uri = 'property/get_states';
		$params = 'property_id=' . $this->config->item('property_id','lemoore') .'&destination_id=' . $this->config->item('destination_id','lemoore').'&country=' . $country;
		$response = $this->rest->{$this->method}($uri, $params);
		
		if($response['status']== 'success'){
			if(!empty($response['responseData'])){
				echo json_encode($response['responseData']);exit;
			}else echo 'false';exit;
		}else echo 'false';exit;
	}
	
	/*
	 * Ajax call for get all Cities of state. - PK 
	 */
	
	function get_cities(){
		$state = $this->input->post('state');
		//$state = "California";	
		if(empty($state)){
			die('false'); 
		}
		
		$uri = 'property/get_cities';
		$params = 'property_id=' . $this->config->item('property_id','lemoore') .'&destination_id=' . $this->config->item('destination_id','lemoore').'&state=' . $state;
		$response = $this->rest->{$this->method}($uri, $params);
		
		if($response['status']== 'success'){
			if(!empty($response['responseData'])){
				echo json_encode($response['responseData']);exit;
			}else echo 'false';exit;
		}else echo 'false';exit;
	}
}