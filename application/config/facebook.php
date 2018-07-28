<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Facebook API Configuration
| -------------------------------------------------------------------
|
| To get an facebook app details you have to create a Facebook app
| at Facebook developers panel (https://developers.facebook.com)
|
|  facebook_app_id               string   Your Facebook App ID.
|  facebook_app_secret           string   Your Facebook App Secret.
|  facebook_login_type           string   Set login type. (web, js, canvas)
|  facebook_login_redirect_url   string   URL to redirect back to after login. (do not include base URL)
|  facebook_logout_redirect_url  string   URL to redirect back to after logout. (do not include base URL)
|  facebook_permissions          array    Your required permissions.
|  facebook_graph_version        string   Specify Facebook Graph version. Eg v2.6
|  facebook_auth_on_load         boolean  Set to TRUE to check for valid access token on every page load.
*/
// $config['facebook_app_id']              = '557837804567255';
// $config['facebook_app_secret']          = 'fcb931405e53ff1fa3d31b8ccda316db';
// $config['facebook_login_type']          = 'web';
// $config['facebook_login_redirect_url']  = 'index.php/User_authentication';
// $config['facebook_logout_redirect_url'] = 'index.php/User_authentication/logout';
// $config['facebook_permissions']         = array('email');
// $config['facebook_graph_version']       = 'v2.6';
// $config['facebook_auth_on_load']        = TRUE;

$config['facebook_app_id']              = '1663119170401914';
$config['facebook_app_secret']          = '904057eb706deefc41fba0c06d18fc0c';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'fb_login';
// $config['facebook_logout_redirect_url'] = 'index.php/User_authentication/logout';
$config['facebook_permissions']         = array('email');
$config['facebook_graph_version']       = 'v2.6';
$config['facebook_auth_on_load']        = TRUE;