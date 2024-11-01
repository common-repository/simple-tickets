<?php
/*
Globel Administrator Library File
*/
// Exit if file accessed directly ///
global $GBLCOM;

defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
$ImagePath = GBL_ADMIN_BASEURI_MYPATH."/Themes/Simple-Tickets-Logo.png";
$blankpagemsg = "";

if ($blankpagemsg == "")
	{
	$blankpagemsg = '<p style="font-size: x-large; color:blue; text-align: center;" >';
	$blankpagemsg .= 'You are seeing this page because you may need to upgrade <br>';
	$blankpagemsg .= ' to a Pro Edition Feature or we are still developing this Feature.</p>';
	$blankpagemsg .= '<p style="text-align: center; font-size: x-large">';
	$blankpagemsg .= 'Please look at our site or the FAQ.</p>';
	}
$content .= <<<CONTENT

<table style="width: calc(100% - 10px); border: 0; background: #F6F6F6;" cellspacing="1" cellpadding="1">
  <tr>
    <td align="center" valign="middle">
	<a href="http://simple-tickets.com/support/" target="_blank"><img src="$ImagePath"></a>
	</td>
  </tr>
  <tr>
    <td align="center" valign="middle">
	$blankpagemsg
	</td>
  </tr>
</table>

CONTENT;


?>

