<?php

class Templates extends Authenticate
{

    private $_weather;

    function Templates()
    {
        parent::Authenticate();
    }

    function index()
    {
        //$this->load->view('html/index', array('active_tab'=>'index', 'user_reviews' => $user_reviews['responseData'], 'deal_details' => $deal_details['responseData'], 'property' => $this->_property_info['responseData'], 'review_details' => $review_details['responseData'], 'room_images' => $room_images['responseData'], 'room_details' => $room_details['responseData'], 'property_images' => $property_images['responseData'], 'user_details' => $user_details['responseData'], 'weather' => $this->_weather, 'debug' => ''));
    }

    

}