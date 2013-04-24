<?php

class Authenticate extends Controller
{

    public $method;
    protected $_property_info = array();
    protected $_property;
    private $_template;
	public $view_data = array();
    /**
    * Constructor of the class
    *
    * Creates the object for this class, loads library for rest
    * , intiates and gets brief information about property
    *
    * @access	public
    * @param    string  $property
    * @return	void
    */

    function __construct()
    {
        parent::__construct();
        
    	$this->load->library('user_agent');
		$mobile_url = $this->config->item('mobile_url');
    	if ($this->agent->is_mobile() && !empty($mobile_url)){
			header("Location:".$mobile_url);
		}else{
			//Do nohting for now
		}
        $property = $this->config->item('inn_key');
        if(empty($property)){
        	die("The 'inn_key' is not set.Check configuration file.");
        }
        $this->_property = $property;
        
        $this->load->library('rest', array(
            'server' => $this->config->item('rest_server',$this->_property),
            'property' => $this->_property
        ));
        $this->method = $this->config->item('rest_method',$this->_property);
        $format = $this->config->item('rest_format',$this->_property);
        $this->rest->format($format);
        $this->get_property_info();
        $this->_template = $this->config->item('theme',$this->_property);
        $this->view_data['theme'] = $this->_template;
    }

    /**
    * Get brief information about property
    *
    * Gets and stores the information of making request for
    * fetching brief information about property
    *
    * @access	protected
    * @return	void
    */

    protected function get_property_info()
    {
        $uri = 'property/get_property_name';
        $params =  'property_id=' . $this->config->item('property_id',$this->_property);

        $this->_property_info = $this->rest->{$this->method}($uri, $params);

        if (trim($this->_property_info['status']) == 'failure' && trim($this->_property_info['error_code']) == 20)
        {
            $this->get_token();
            $this->get_property_info();
        }
        elseif (trim($this->_property_info['status']) == 'failure' && trim($this->_property_info['error_code']) == 50)
        {
            $this->authenticate_user();
            $this->get_property_info();
        }
        elseif (trim($this->_property_info['status']) != 'success')
        {
            //die($_SERVER['HTTP_X_REQUESTED_WITH']);
            if($_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest")
            {
                $this->load->view($this->_template.'/popup_error_message');
            }
            else
            {
                $this->load->view($this->_template.'/error_message');
            }
        }else{
        	$this->view_data['property'] = $this->_property_info['responseData'];
        }
    }

    /**
    * Gets the token
    *
    * Gets access token for making further web service requests
    *
    * @access	protected
    * @return	void
    */

    protected function get_token()
    {
        $uri = 'property/get_token';
        $params = "auth_user={$this->config->item('auth_user',$this->_property)}&auth_pass={$this->config->item('auth_pass',$this->_property)}";

        $amenities = $this->rest->{$this->method}($uri, $params);
        if (trim($amenities['status']) != 'success')
        {
            //die($amenities['error']);
            if($_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest")
            {
                $this->load->view($this->_template.'/popup_error_message');
            }
            else
            {
                $this->load->view($this->_template.'/error_message');
            }
        }
    }

    /**
    * Authenticates user
    *
    * Authenticates user for making web service request
    *
    * @access	protected
    * @return	void
    */

    protected function authenticate_user()
    {
        $this->get_token();
        $uri = 'authenticate/authenticate_user';
        $params = "auth_user={$this->config->item('auth_user',$this->_property)}&auth_pass={$this->config->item('auth_pass',$this->_property)}";

        $authentication = $this->rest->{$this->method}($uri, $params);

        if(empty ($authentication))
        {
            redirect($this->_property);
        }
        elseif (trim($authentication['status']) != 'success')
        {
            //die($authentication['error']);
            if($_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest")
            {
                $this->load->view($this->_template.'/popup_error_message');
            }
            else
            {
                $this->load->view($this->_template.'/error_message');
            }
        }
    }
}
?>