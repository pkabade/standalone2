<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "inn";
$route['scaffolding_trigger'] = "";

$route['southgate'] = $route['default_controller'];

// Routing Lemoore page
$route['overview']						=$route['default_controller'].'/hotel_review';
$route['accommodations']				=$route['default_controller'].'/accomodation';
$route['guestrooms']					=$route['default_controller'].'/guestrooms';
$route['gallery']						=$route['default_controller'].'/gallery';
$route['destination-guide']				=$route['default_controller'].'/destination_guide';
$route['directions']					=$route['default_controller'].'/directions';	//terms_conditions
$route['terms']							=$route['default_controller'].'/terms_conditions';
$route['privacy-policy']				=$route['default_controller'].'/privacy_policy'; 
$route['register_user']					=$route['default_controller'].'/register_user';///register_user




/* End of file routes.php */
/* Location: ./system/application/config/routes.php */