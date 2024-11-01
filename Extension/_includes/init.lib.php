<?php
//Globel Administrator Library File
// Exit if file accessed directly
global $GBLCOM;
defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
define('GBL_ADMIN_THEMES_DIR', GBL_ADMIN_GLOBEL_DIR."/Themes");
define('GBL_ADMIN_REPOSITORY_FETCH', 0);// SET TO 1 to get Extensions and register and setup
define('GBL_ADMIN_APP_NAME', "Globel Administrator");
define('GBL_ADMIN_APP_NAME_SHORT', "Simple Tickets");
define('GBL_ADMIN_EXTENSION_SITE', "http://www.simple-tickets.com");
define('GBL_ADMIN_REMOTE_IP', $_SERVER["REMOTE_ADDR"]);
define('GBL_ADMIN_REPOSITORY', "http://gbl0000001.globel.co.uk");// http://repository.globel.co.uk
define('GBL_ADMIN_IMAGES', GBL_ADMIN_BASEURI_MYPATH."/Themes/default_admin/images");

// PRESETS B4 FILE
// $GBLCOM['GBL_ADMIN_PHP_ERROR'] = "no"; // REM FOR WORDPRESS
$GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] = "no";
$GBLCOM["GBL_ADMIN_SWITCH_DISPLAY"] = "off";
$GBLCOM["GBL_ADMIN_DASHBOARD"] = "off";
$GBLCOM["GBL_ADMIN_HEADER"] = "off";
$GBLCOM["GBL_ADMIN_FOOTER"] = "off";
$GBLCOM["GBL_ADMIN_ADVANCED_FEATURES"] = "on";
$GBLCOM["GBL_ADMIN_PRIMARY"] = "off";
$GBLCOM["GBL_ADMIN_PRIMARY_KEY"] = "";
$GBLCOM['GBL_ADMIN_GBLCOM_IGNORE'] = "GBL_ADMIN_TRK,GBL_ADMIN_CMD,GBL_ADMIN_ACT,GBL_ADMIN_USER,GBL_ADMIN_PASS,GBL_ADMIN_EMAIL,";
$GBLCOM['GBL_ADMIN_GBLCOM_IGNORE'] .= "GBL_ADMIN_TAB,GBL_ADMIN_PAGE,GBL_ADMIN_EMAIL_AUTH,GBL_ADMIN_IMAGE_TARGET,GBL_ADMIN_CSS_TARGET,";
$GBLCOM['GBL_ADMIN_GBLCOM_IGNORE'] .= "GBL_ADMIN_TRACKING_FILE,GBL_WORDPRESS_USER,GBL_ADMIN_IMAGE_URI,GBL_ADMIN_TKN,";
$GBLCOM['GBL_ADMIN_GBLCOM_IGNORE'] .= "GBL_WORDPRESS_USERS,GBL_ADMIN_ISBOOTPAGE,GBL_ADMIN_ERROR_STATE,GBL_ADMIN_ERROR_MESSAGE,GBL_ADMIN_KEEP_TRACK,";
$GBLCOM['GBL_ADMIN_GBLCOM_IGNORE'] .= "GBL_ADMIN_ERRORS,GBL_ADMIN_LOGOFF_TAB,GBL_ADMIN_ERRORS_STYLE,";
$GBLCOM['GBL_ADMIN_REQUEST_BLACKLIST'] = "";
$GBLCOM['GBL_ADMIN_BOOT_TAB'] = "admin";
$GBLCOM['GBL_ADMIN_BOOT_PAGE'] = "general_settings";
$GBLCOM['GBL_ADMIN_REQUIRED_PHP_VERSION'] = '5.0';
$GBLCOM['GBL_ADMIN_KEEP_TRACK'] = "";


$MyFile = GBL_ADMIN_INCLUDES_DIR."/common.lib.php";
if (file_exists($MyFile)){include_once $MyFile;}//else{print "could not find ".$MyFile; exit;}

//if (function_exists("wp_verify_nonce")){print ".................................nonce exists <br>";}
//else {print ".......................................... NO nonce <br>";}

$MyFile = GBL_ADMIN_DATA_DIR."/GBLCOM.PHP";
if (file_exists($MyFile)){include_once $MyFile;}//else{print "could not find ".$MyFile; exit;}

$MyFile = GBL_ADMIN_INCLUDES_DIR."/system.lib.php";
if (file_exists($MyFile)){include_once $MyFile;}//else{print "could not find system lib"; exit;} //pathinfo(__FILE__, PATHINFO_FILENAME)

// DEFINE AND CREATE DIRS ? NOT SURE FOR WP YET
define('GBL_ADMIN_USERS_DIR', GBL_ADMIN_DATA_DIR."/Users");
if (GBL_ADMIN_MAKE_CHECK_DIR(GBL_ADMIN_USERS_DIR)){}
define('GBL_ADMIN_USER_ONLINE_FILES', GBL_ADMIN_USERS_DIR."/Online");
if (GBL_ADMIN_MAKE_CHECK_DIR(GBL_ADMIN_USER_ONLINE_FILES)){}


if(isset($_REQUEST["gbltkn"])){$GBLCOM['GBL_ADMIN_TKN'] = GBL_SANITISE_TEXT_FIELD($_REQUEST["gbltkn"]);}else{$GBLCOM['GBL_ADMIN_TKN'] = "";}
if(isset($_REQUEST["gbltrk"])){$GBLCOM['GBL_ADMIN_TRK'] = GBL_SANITISE_TEXT_FIELD($_REQUEST["gbltrk"]);}else{$GBLCOM['GBL_ADMIN_TRK'] = "";}
if(isset($_REQUEST["gblcmd"])){$GBLCOM['GBL_ADMIN_CMD'] = GBL_SANITISE_TEXT_FIELD($_REQUEST["gblcmd"]);}else{$GBLCOM['GBL_ADMIN_CMD'] = "";}
if(isset($_REQUEST["gblact"])){$GBLCOM['GBL_ADMIN_ACT'] = GBL_SANITISE_TEXT_FIELD($_REQUEST["gblact"]);}else{$GBLCOM['GBL_ADMIN_ACT'] = "";}
if(isset($_REQUEST["gbluser"])){$GBLCOM['GBL_ADMIN_USER'] = GBL_SANITISE_TEXT_FIELD($_REQUEST["gbluser"]);}else{$GBLCOM['GBL_ADMIN_USER'] = "";}
if(isset($_REQUEST["gblpass"])){$GBLCOM['GBL_ADMIN_PASS'] = GBL_SANITISE_PASSWORD($_REQUEST["gblpass"]);}else{$GBLCOM['GBL_ADMIN_PASS'] = "";}
if(isset($_REQUEST["gblemail"])){$GBLCOM['GBL_ADMIN_EMAIL'] = GBL_SANITISE_EMAIL($_REQUEST["gblemail"]);}else{$GBLCOM['GBL_ADMIN_EMAIL'] = "";}
if(isset($_REQUEST["gbltab"])){$GBLCOM['GBL_ADMIN_TAB'] = GBL_SANITISE_TEXT_FIELD($_REQUEST["gbltab"]);}else{$GBLCOM['GBL_ADMIN_TAB'] = "";}
if(isset($_REQUEST["gblpage"])){$GBLCOM['GBL_ADMIN_PAGE'] = GBL_SANITISE_TEXT_FIELD($_REQUEST["gblpage"]);}else{$GBLCOM['GBL_ADMIN_PAGE'] = "";}
if(isset($_REQUEST["gblauth"])){$GBLCOM['GBL_ADMIN_EMAIL_AUTH'] = GBL_SANITISE_EMAIL($_REQUEST["gblauth"]);}else{$GBLCOM['GBL_ADMIN_EMAIL_AUTH'] = "";}
//print "<pre>";
//print_r($GBLCOM);//$_REQUEST
//print "</pre>";
if(!isset($GBLCOM['GBL_ADMIN_THEME'])){$GBLCOM['GBL_ADMIN_THEME'] = 'default_admin';}
elseif(isset($_REQUEST["GBL_ADMIN_THEME"])){$GBLCOM["GBL_ADMIN_THEME"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_THEME"]);}

/// RESET BACK TO FREE VERS
if(!isset($GBLCOM['GBL_ADMIN_REG_LEVEL'])){$GBLCOM['GBL_ADMIN_REG_LEVEL'] = "";}
if(!isset($GBLCOM['GBL_ADMIN_REG_ALLOWED'])){$GBLCOM['GBL_ADMIN_REG_ALLOWED'] = false;}

if(!isset($GBLCOM['GBL_ADMIN_LOCAL_USERNAME']))
	{
	$GBLCOM['GBL_ADMIN_LOCAL_USERNAME'] = 'newfreeadmin'; // LOCAL ADMIN USER
	$GBLCOM['GBL_ADMIN_LOCAL_PASSWORD'] = '$2y$11$96z0Q6GYO.sT.kdJxC5BTOnJjz5qtondO2s4ptNiOkEpUtkBcrTNW'; // FREE LOCAL ADMIN PASSWORD
	}
if(!isset($GBLCOM['GBL_ADMIN_NET_TOKEN']))
	{$GBLCOM['GBL_ADMIN_NET_TOKEN'] = '62jKYW@kXksYYl3VuJ1Qtp3SB9VZlJnZD9r';} // FREE repository.globel.co.uk TOKEN

////if ($GBLCOM['GBL_ADMIN_ERROR_STATE'] == "ERR"){return $TXT;}
//print $GBLCOM['GBL_ADMIN_TAB'].'<BR>';
//print $GBLCOM['GBL_ADMIN_PAGE'].'<BR>';
$GBLCOM['GBL_ADMIN_MAINTENANCE'] = 0;
$GBLCOM['GBL_USER_DATA_PATH'] = "";
$GBLCOM['GBL_ADMIN_ADR_LINES'] = "";
$GBLCOM['GBL_ADMIN_ERROR_STATE'] = "OK";
$GBLCOM['GBL_ADMIN_ERROR_MESSAGE'] = "";
$GBLCOM['GBL_ADMIN_TRACKING_FILE'] = "";
$GBLCOM['GBL_ADMIN_LOGOFF_TAB'] = false;
$GBLCOM['GBL_ADMIN_ERRORS'] = ""; 
$GBLCOM['GBL_ADMIN_ERRORS_STYLE'] = ""; 

/*
Please Note: you can choose to have your data encrypted at any time
 and convert back to the original files with encryption on or off
 however; do not change the salt as this can seriously corrupt the 
 file data.
 
 encryption will make your data more secure but it is advisable to
 either switch it on or off as switching back and forth can also corrupt data.   
*/
// SET FOR NOW UNTIL NEW ADMIN DONE

// IF FUNCTIONS
if (GBL_ADMIN_MYNAME == "GlobelWP")
	{
	$MyFile = GBL_ADMIN_INCLUDES_DIR."/wordpresssite.lib.php";
	if (file_exists($MyFile)){include_once $MyFile;}
	else
		{
		// SETUP INCLUDE THIS FILE!
		print "could not find ".$MyFile;
		exit;
		}
	}
elseif (GBL_ADMIN_MYNAME == "index")
	{
	$MyFile = GBL_ADMIN_INCLUDES_DIR."/standardsite.lib.php";
	if (file_exists($MyFile)){include_once $MyFile;}
	else
		{
		// SETUP INCLUDE THIS FILE!
		print "could not find ".$MyFile;
		exit;
		}
	}
else {die("Globel Administrator Wrong Filename? The Filename was: ".GBL_ADMIN_MYNAME);}
	
if ($GBLCOM['GBL_ADMIN_MAINTENANCE']) {print "site under Maintenance"; exit;} // ADJUST

// CHECK PRIMARY DIRS
if (!file_exists(GBL_ADMIN_DATA_DIR)){GBL_ADMIN_MAKE_CHECK_DIR(GBL_ADMIN_DATA_DIR);}//{wp_mkdir_p(GBL_ADMIN_DATA_DIR);}
//GBL_ADMIN_MAKE_CHECK_DIR(GBL_ADMIN_DATA_DIR);

function GBL_ADMIN_INCLUDES()
{
global $GBLCOM;


if (file_exists(GBL_ADMIN_INCLUDES_DIR."/request.lib.php")){include_once GBL_ADMIN_INCLUDES_DIR."/request.lib.php";}

if (file_exists(GBL_ADMIN_EXTENSIONS_DIR.'/simple-tickets/shortcode.lib.php'))
{include_once(GBL_ADMIN_EXTENSIONS_DIR.'/simple-tickets/shortcode.lib.php');}


}











	







?>