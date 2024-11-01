<?php
/*
Globel Administrator Library File
*/
// Exit if file accessed directly ///
global $GBLCOM;

defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
$ImagePath = GBL_ADMIN_BASEURI_MYPATH."/Themes/Simple-Tickets-Logo.png";
$content .= <<<CONTENT

<table style="width: calc(100% - 10px); border: 0; background: #F6F6F6;" cellspacing="1" cellpadding="1">
  <tr>
    <td align="center" valign="middle">
	<a href="http://simple-tickets.com/" target="_blank"><img src="$ImagePath"></a>
	</td>
  </tr>
</table>

CONTENT;


?>
