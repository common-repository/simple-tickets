<?php
//hhh = m
/*
 * @package Globel Administrator
 */
/*
	Plugin Name: Simple Tickets
	Plugin URI: http://simple-tickets.com
	Description: Simple Tickets with Globel Administrator is an Administration program for all Globel extensions and services and includes in this edition the simple tickets platform.
	Author: P E S Grimes
	Version: 0.1.7.8
	Author URI: http://globel.co.uk
	License: GPLv3
*/
/*
    "Globel Administrator" Copyright (C) 2004 Globel Limited  (email : webmaster@globel.co.uk)

    Parts of Globel Administrator are free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Globel Administrator is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
	
	Alongside its own proprietary software Globel Administrator use packaging,
	extensions and libraries from different sources that all contain their own
	set of MIT and GNU licensing which will be stated on the various software
	you receive if it is not please inform us. we offer various pieces of free
	software under the GNU licence ourselves as well as paid and pro versions
	of Globel Administrator please see our website for details.
	
	Additionally;  images, scripts, clipart also may have their own set of rules
	and copyrights! put simply if you are in any doubt do not use it or apply to
	the source website to use the item, for example and for instance the GNU
	licence covers the source code "the software" but not necessarily the images,
	from time to time we use stock images that are licensed to us and we are 
	licensed to only use them in our applications so always be careful when using
	others work.

    You should have received a copy of the GNU General Public License with this copy.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
	
	In all cases you should consult our website for the latest licensing and terms
	for any software or applications you are using and/or the component parts.

*/
/*
Globel Administrator (MASTER)
*/
//print "BLANK"; EXIT;
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

global $GBLCOM;
define('GBL_ADMIN_VERSION', "0.1.7.8");
defined('GBL_ADMIN_RUNNING_STATE') or define('GBL_ADMIN_RUNNING_STATE',true);
define('GBL_ADMIN_MYNAME', pathinfo(__FILE__, PATHINFO_FILENAME));
//SET BASE PATHS
if (GBL_ADMIN_MYNAME == "GlobelWP")
	{
	define('GBL_ADMIN_PLATFORM', "wordpress");
	define('GBL_ADMIN_GLOBEL_DIR', rtrim(plugin_dir_path(__FILE__), '/'));
	define('GBL_ADMIN_BASEURI', site_url()); // Site URL
	define('GBL_ADMIN_BASEURI_MYPATH', plugin_dir_url(__FILE__));
	define('GBL_ADMIN_DATA_DIR', WP_CONTENT_DIR."/uploads/Globel_Data");
	/******************************************************************************************
	//Below works but user will need to create folder via FTP to securly store data and backups
	//define('GBL_ADMIN_DATA_DIR', realpath($_SERVER['DOCUMENT_ROOT'].'/../Globel_Data'));
	******************************************************************************************/
	define('GBL_WORDPRESS_ADMIN', "Globel_Admins");// paged name
	define('GBL_WORDPRESS_DASHICON', GBL_ADMIN_BASEURI_MYPATH."/Themes/Small White_20x21.png");
	}
elseif (GBL_ADMIN_MYNAME == "index")
	{
	define('GBL_ADMIN_PLATFORM', "normal");
	define('GBL_ADMIN_BASEPATH', str_replace('\\', '/', realpath(dirname(__FILE__))));
	define('GBL_ADMIN_GLOBEL_DIR', GBL_ADMIN_BASEPATH."/Globel");
	define('GBL_ADMIN_BASEURI', 'http://'.$_SERVER['HTTP_HOST']); // Site URL
	//define('GBL_ADMIN_BASEURI_ROOTPATH', str_replace('\\', '/', GBL_ADMIN_BASEURI."".str_replace($_SERVER['DOCUMENT_ROOT'],"",dirname(__FILE__))));
	define('GBL_ADMIN_BASEURI_MYPATH', str_replace('\\', '/', GBL_ADMIN_BASEURI."".str_replace($_SERVER['DOCUMENT_ROOT'],"",dirname(__FILE__))).'/Globel');///
	
	define('GBL_ADMIN_DATA_DIR', GBL_ADMIN_GLOBEL_DIR."/Data");
	
	//if (!file_exists(GBL_ADMIN_DATA_DIR)){GBL_ADMIN_MAKE_CHECK_DIR(GBL_ADMIN_DATA_DIR);}
	}
else {die("Globel Administrator Wrong Filename? The Filename was: ".GBL_ADMIN_MYNAME);}
//Required to call initiation file
define('GBL_ADMIN_EXTENSIONS_DIR', GBL_ADMIN_GLOBEL_DIR."/Extension");
define('GBL_ADMIN_INCLUDES_DIR', GBL_ADMIN_EXTENSIONS_DIR."/_includes");

//OTHER 
define('GBL_ADMIN_BASEURI_PLAIN', $_SERVER['HTTP_HOST']);

if (file_exists(GBL_ADMIN_INCLUDES_DIR."/init.lib.php")){include GBL_ADMIN_INCLUDES_DIR."/init.lib.php";}

//if (GBL_ADMIN_MYNAME == "index"){include_once(GBL_ADMIN_THEMES_DIR.'/default_admin/main.php');}
//else {print "init lib missing?";}
//print "BLANK"; EXIT;


?>
