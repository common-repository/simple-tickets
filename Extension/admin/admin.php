<?php
/*
Globel Administrator Library File
*/
// Exit if file accessed directly ///
global $GBLCOM;
defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////

if (file_exists(GBL_ADMIN_EXTENSIONS_DIR.'/admin/general_settings.mnu.php'))
{include_once(GBL_ADMIN_EXTENSIONS_DIR.'/admin/general_settings.mnu.php');}



?>
