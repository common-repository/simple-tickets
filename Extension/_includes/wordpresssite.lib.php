<?php
//Globel Administrator Library File
// Exit if file accessed directly
global $GBLCOM;
defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////

/// CHECK REQUIRED FILES FOR THIS SETUP


if (GBL_WORDPRESS_CHECK_PHP())
	{

	GBL_ADMIN_INCLUDES();
	add_action( 'init', 'InitiateGLOBEL');
	add_action('plugins_loaded', 'GBL_PLUGINS_LOADED');
	}

//################################# WORDPRESS FUNCTIONS ########################################

function InitiateGLOBEL(){if(is_admin()){add_action('admin_menu', 'GBL_WORDPRESS_ADMIN_MENU',"&" );}}

function GBL_WORDPRESS_CHECK_PHP() 
{
global $GBLCOM;

if (version_compare(phpversion(), $GBLCOM['GBL_ADMIN_REQUIRED_PHP_VERSION']) < 0) 
	{
	add_action('admin_notices', 'GBL_WORDPRESS_VERSION_CHECK_RESULT');
	return false;
	}
return true;
} 

function GBL_WORDPRESS_VERSION_CHECK_RESULT() 
{
global $GBLCOM;
$RequiredPHPVersion = $GBLCOM['GBL_ADMIN_REQUIRED_PHP_VERSION'];
$ExistingPHPVersion = phpversion();

$result .= <<<GLOBELPHPVERSION
<div class="updated fade">
Error: <br/>
Our plugin Globel Administrator requires a newer version of PHP to be running.............<br/>
Minimal version of PHP required: <strong>$RequiredPHPVersion</strong><br/>
Your server PHP version:<strong> $ExistingPHPVersion</strong>
</div>
GLOBELPHPVERSION;

echo $result;
}

function GBL_PLUGINS_LOADED() {
global $GBLCOM;
$MyKey = 'hRF54pF';
$GBLCOM['GBL_ADMIN_KEEP_TRACK'] = wp_create_nonce($MyKey);


//print ".......................................... ".$GBLCOM['GBL_ADMIN_KEEP_TRACK']." <br>";


	$current_user = wp_get_current_user();
	if (!($current_user instanceof WP_User)) {return;}
	if($GBLCOM['GBL_ADMIN_EMAIL'] == '')
	{$GBLCOM['GBL_ADMIN_EMAIL'] = $current_user->user_email;} 
	if($GBLCOM["GBL_ADMIN_USER"] == '')
	{ 
	if($current_user->user_login !== '')
	 {$GBLCOM["GBL_ADMIN_USER"] = $current_user->user_login;}
	else {$GBLCOM["GBL_ADMIN_USER"] = 'Guest';}
	}
}

function GBL_WORDPRESS_ADMIN_MENU()
{
global $GBLCOM;

add_menu_page(GBL_ADMIN_APP_NAME_SHORT, GBL_ADMIN_APP_NAME_SHORT, 'manage_options', GBL_WORDPRESS_ADMIN, 'GBL_GET_MENU', GBL_WORDPRESS_DASHICON, 1);
add_filter('admin_footer_text', 'GBL_REMOVE_FOOTER');///
add_filter( 'update_footer', 'GBL_REMOVE_FOOTER');
add_action('admin_enqueue_scripts', 'GBL_ADMIN_WP_STYLE');// Style for Admin Panel in WP

$current_user = wp_get_current_user();
$GBLCOM['GBL_WORDPRESS_USER'] = $current_user->user_login;
$GBLCOM['GBL_WORDPRESS_USERS'] = get_users(array('fields' => array('display_name'))); //OBJECT
}

function GBL_ADMIN_WP_STYLE() {
	global $GBLCOM;
	if(isset($_REQUEST['page'])) {$page = GBL_SANITISE_TEXT_FIELD($_REQUEST['page']);} else {$page = '';}
	if($page != GBL_WORDPRESS_ADMIN) {return;}
	wp_register_style(GBL_ADMIN_MYNAME, GBL_ADMIN_BASEURI_MYPATH.'/Themes/'.$GBLCOM['GBL_ADMIN_THEME'].'/css/GBLadmin.css');
	wp_enqueue_style(GBL_ADMIN_MYNAME);
	wp_register_style('simple-tickets', GBL_ADMIN_BASEURI_MYPATH.'/Extension/simple-tickets/simple-tickets.css');
	wp_enqueue_style('simple-tickets');
}

function GBL_REMOVE_FOOTER(){echo "";}

function GBL_GET_MENU()
{
global $GBLCOM;
print "\n\n<!-- GBL START -->\n\n"; 
include_once(GBL_ADMIN_THEMES_DIR.'/'.$GBLCOM['GBL_ADMIN_THEME'].'/main.php');
print "\n\n<!-- GBL END -->\n\n"; 
}
?>