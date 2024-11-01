<?php
//Globel Administrator Library File
// Exit if file accessed directly
global $GBLCOM, $GBL_SMTCKS;

defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////

date_default_timezone_set('Europe/London');

if(!function_exists("array_column"))
{
    function array_column($array,$column_name)
    {
        return array_map(function($element) use($column_name)
		{
			return $element[$column_name];
		}, $array);
    }
}

global $GBL_SMTCKS;
$GBL_SMTCKS = array(
'DIR_URI' => str_replace($_SERVER['DOCUMENT_ROOT'], GBL_ADMIN_BASEURI, dirname(__FILE__)),
'tkl_view' => '0',
'tkl_sort' => '0',
'tkl_order' => '0',
'tkl_views' => array(0),
);

if(isset($GBLCOM['GBL_SMTCKS_CONTROL']))
{
	$GBL_SMTCKS_CONTROL_SETTINGS = explode(',', $GBLCOM['GBL_SMTCKS_CONTROL']);
	
	if(isset($GBL_SMTCKS_CONTROL_SETTINGS[0]))
		$GBL_SMTCKS['tkl_view'] = $GBL_SMTCKS_CONTROL_SETTINGS[0];
	if(isset($GBL_SMTCKS_CONTROL_SETTINGS[1]))
		$GBL_SMTCKS['tkl_order'] = $GBL_SMTCKS_CONTROL_SETTINGS[1];
	if(isset($GBL_SMTCKS_CONTROL_SETTINGS[2]))
		$GBL_SMTCKS['tkl_sort'] = $GBL_SMTCKS_CONTROL_SETTINGS[2];
	
}

if(isset($_REQUEST['gbl_smtcks_view']))
	$GBL_SMTCKS['tkl_view'] = GBL_SANITISE_PASSWORD($_REQUEST['gbl_smtcks_view']);

if(isset($_REQUEST['gbl_smtcks_sort']))
	$GBL_SMTCKS['tkl_sort'] = GBL_SANITISE_PASSWORD($_REQUEST['gbl_smtcks_sort']);

if(isset($_REQUEST['gbl_smtcks_order']))
	$GBL_SMTCKS['tkl_order'] = GBL_SANITISE_PASSWORD($_REQUEST['gbl_smtcks_order']);

$GBLCOM['GBL_SMTCKS_ID'] = 'simple-tickets';
GBL_SMTCKS_INIT();
$gbl_smtcks_style = '<div id="Notification"></div>';

if(GBL_ADMIN_MYNAME == "GlobelWP")
{
	$GBL_SMTCKS['A_HREF'] = GBL_ADMIN_CONTROL_INSERTS('?gblcmd='.$GBLCOM['GBL_ADMIN_CMD']);
	wp_register_style('simple-tickets', $GBL_SMTCKS['DIR_URI'].'/simple-tickets.css');
	wp_enqueue_style('simple-tickets');
}
else
{
	$GBL_SMTCKS['A_HREF'] = GBL_ADMIN_CONTROL_INSERTS('?');
	$gbl_smtcks_style .= '<link rel="stylesheet" href="'.$GBL_SMTCKS['DIR_URI'].'/simple-tickets.css">';
}

if(isset($_GET['gbl_smtcks_tkt'])) {$GBL_SMTCKS['ID'] = GBL_SANITISE_NUMBER_ONLY($_GET['gbl_smtcks_tkt']);}

function GBL_SMTCKS_INIT() {
	global $GBLCOM, $GBL_SMTCKS;
	$GBL_SMTCKS_TICKET = array(25,5,5,'1,1,1');
	$GBL_SMTCKS['SETTINGS'] = array(
	'HEAD,ID,TYPE,FIELD NAME,ENABLED,REQUIRED,HIDDEN,DISPLAY IN LIST,PLACEHOLDER,COLOURS,,,,,,,,,,,,',
	'TKS,1,text,Subject,1,1,0,1,Ticket Subject,,,,,,,,,,,,,',
	'TKS,2,email,E-mail,1,1,0,1,example@example.com,,,,,,,,,,,,,',
	'TKS,3,select,Status,1,0,0,1,,a:3:{s:4:"Open";s:7:"#A8FFA4";s:7:"Pending";s:7:"#FFDCA4";s:6:"Closed";s:7:"#FFA4A4";},,,,,,,,,,,,Open,Pending,Closed,',
	'TKS,4,select,Priority,1,0,0,1,,,,,,,,,,,,,,Low,Medium,High,',
	'TKS,5,select,Type,1,1,0,1,,0,,,,,,,,,,,,Problem,Question,');

	if(!file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID']))
		GBL_ADMIN_MAKE_CHECK_DIR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID']);
	
	if(!file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default')) 
		GBL_ADMIN_MAKE_CHECK_DIR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default');
	
	if(!file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets'))
		GBL_ADMIN_MAKE_CHECK_DIR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets');
	
	if(!file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/ticket.tks'))
		GBL_SAVE_FILE_CONTENTS(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/ticket.tks', implode(',', $GBL_SMTCKS_TICKET));
	else
		$GBL_SMTCKS_TICKET = explode(',', GBL_OPEN_FILE_CONTENTS(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/ticket.tks'), 4);
	
	if(!file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/settings.tks'))
	{
		foreach($GBL_SMTCKS['SETTINGS'] as $GBL_SMTCKS_SETTINGS)
		{
			if(strpos($GBL_SMTCKS_SETTINGS, ','))
				$GBLCOM['GBL_ADMIN_ADR_LINES'][] = explode(',', $GBL_SMTCKS_SETTINGS);
		}
		GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/settings.tks', $GBL_SMTCKS['SETTINGS']);
	} else {
		GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/settings.tks', true);
		$GBL_SMTCKS['SETTINGS'] = $GBLCOM['GBL_ADMIN_ADR_LINES'];
	}	
	
	$GBLCOM['GBL_SMTCKS_MAXDETS'] = $GBL_SMTCKS_TICKET[0];
	$GBLCOM['GBL_SMTCKS_TIMEWAIT'] = $GBL_SMTCKS_TICKET[1];
	$GBLCOM['GBL_SMTCKS_COMMENT_MIN'] = $GBL_SMTCKS_TICKET[2];
	$GBLCOM['GBL_SMTCKS_EMAILS'] = $GBL_SMTCKS_TICKET[3];
}

function GBL_SMTCKS_TIMEELAPSED($ptime) {
	$etime = time() - $ptime;
	if($etime < 1) {return '0 seconds';}
	$a = array( 365 * 24 * 60 * 60  =>  'year', 30 * 24 * 60 * 60  =>  'month', 24 * 60 * 60  =>  'day', 60 * 60  =>  'hour', 60  =>  'minute', 1  =>  'second');
	$a_plural = array( 'year' => 'years', 'month'  => 'months', 'day' => 'days', 'hour' => 'hours', 'minute' => 'minutes', 'second' => 'seconds');
	
	foreach ($a as $secs => $str) {
		$d = $etime / $secs;
		if ($d >= 1) { $r = round($d); return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago'; }
	}
}

function GBL_SMTCKS_HEX_TO_RGB($hex)
{
	if(strpos($hex, '#') === false)
		return $hex;
	else
		$hex =  str_replace('#', '', $hex);
	
	if(strlen($hex) == 6)
	{
		$rgb[0]['r'] = hexdec(substr($hex, 0, 2));
		$rgb[0]['g'] = hexdec(substr($hex, 2, 2));
		$rgb[0]['b'] = hexdec(substr($hex, 4, 2));
	}
	elseif(strlen($hex) == 3)
	{
		$rgb[0]['r'] = hexdec(str_repeat(substr($hex, 0, 1), 2));
		$rgb[0]['g'] = hexdec(str_repeat(substr($hex, 1, 1), 2));
		$rgb[0]['b'] = hexdec(str_repeat(substr($hex, 2, 1), 2));
	}
	else
		return $hex;
	
	$rgb[1]['r'] = $rgb[0]['r'];
	$rgb[1]['g'] = $rgb[0]['g'];
	$rgb[1]['b'] = $rgb[0]['b'];
	
	if($rgb[0]['r'] < 255/2)
		$rgb[1]['r'] = $rgb[0]['r'] + 25;
	else
		$rgb[1]['r'] = $rgb[0]['r'] - 25;
	
	if($rgb[0]['g'] < 255/2)
		$rgb[1]['g'] = $rgb[0]['g'] + 25;
	else
		$rgb[1]['g'] = $rgb[0]['g'] - 25;
	
	if($rgb[0]['b'] < 255/2)
		$rgb[1]['b'] = $rgb[0]['b'] + 25;
	else
		$rgb[1]['b'] = $rgb[0]['b'] - 25;
	
	return $rgb;
}

function GBL_SMTCKS_CONTROL_SETTINGS()
{
	global $GBLCOM, $GBL_SMTCKS;
	
	$Feature = array();
	$Options = array();
	$tkl_views = array();
	
	//	Save Handling
	if($GBL_SMTCKS['tkl_view'] != '0'|$GBL_SMTCKS['tkl_order'] != '0'|$GBL_SMTCKS['tkl_sort'] != '0')
	{
		$GBLCOM['GBL_SMTCKS_CONTROL'] = $GBL_SMTCKS['tkl_view'].','.$GBL_SMTCKS['tkl_order'].','.$GBL_SMTCKS['tkl_sort'];
		$GBLCOM["GBL_ADMIN_GBLCOM_IGNORE"] .= ',GBL_ADMIN_ADR_LINES';
		GBL_SAVE_COMFILE($GBLCOM,"","","GBL_ADMIN_APP_NAME",GBL_ADMIN_APP_NAME,"GBLCOM",GBL_ADMIN_DATA_DIR."/");
	}
	
	if($GBL_SMTCKS['tkl_view'] == '0')
		$gbl_smtcks_control[0][] = '<option disabled selected hidden value="0">Select View</option>';
	else
		$gbl_smtcks_control[0][] = '<option disabled hidden value="0">Show</option>';
	
	if($GBL_SMTCKS['tkl_view'] == 'all')
		$gbl_smtcks_control[0][] = '<option selected value="all">All</option>';
	else
		$gbl_smtcks_control[0][] = '<option value="all">All</option>';
	
	foreach($GBL_SMTCKS['SETTINGS'] as $Settings)
	{
		$SettingsExploded = explode(',', $Settings, 22);
		
		if(!isset($SettingsExploded[21]))
			continue;
		
		if($SettingsExploded[3] != 'Status'|$SettingsExploded[2] != 'select')
			continue;
		
		$tkl_views = explode(',', $SettingsExploded[1].','.substr($SettingsExploded[21], 0, -1));
	}
	
	foreach($tkl_views as $tkl_select_options)
	{
		$tkl_select_options = GBL_SANITISE_TEXT_ONLY($tkl_select_options);
		
		if($tkl_select_options == null)
			continue;
		
		if($GBL_SMTCKS['tkl_view'] == $tkl_select_options)
			$gbl_smtcks_control[0][] = '<option selected value="'.$tkl_select_options.'">'.$tkl_select_options.'</option>';
		else
			$gbl_smtcks_control[0][] = '<option value="'.$tkl_select_options.'">'.$tkl_select_options.'</option>';
	}
	
	if($GBL_SMTCKS['tkl_sort'] == '0')
		$gbl_smtcks_control[1][] = '<option disabled selected hidden value="0">Sort By</option>';
	else
		$gbl_smtcks_control[1][] = '<option disabled hidden value="0">Sort By</option>';
	
	if($GBL_SMTCKS['tkl_sort'] == 'ticketid')
		$gbl_smtcks_control[1][] = '<option selected value="ticketid">Ticket ID</option>';
	else
		$gbl_smtcks_control[1][] = '<option value="ticketid">Ticket ID</option>';
	
	if($GBL_SMTCKS['tkl_sort'] == 'datemodified')
		$gbl_smtcks_control[1][] = '<option selected value="datemodified">Date Modified</option>';
	else
		$gbl_smtcks_control[1][] = '<option value="datemodified">Date Modified</option>';
	
	//	Order Control
	if($GBL_SMTCKS['tkl_order'] == '0')
		$gbl_smtcks_control[2][] = '<option disabled selected hidden value="0">Order</option>';
	else
		$gbl_smtcks_control[2][] = '<option disabled hidden value="0">Order</option>';
	
	if($GBL_SMTCKS['tkl_order'] == 'ascending')
		$gbl_smtcks_control[2][] = '<option selected value="ascending">Ascending</option>';
	else
		$gbl_smtcks_control[2][] = '<option value="ascending">Ascending</option>';

	if($GBL_SMTCKS['tkl_order'] == 'descending')
		$gbl_smtcks_control[2][] = '<option selected value="descending">Descending</option>';
	else
		$gbl_smtcks_control[2][] = '<option value="descending">Descending</option>';
	
	$gbl_smtcks_control[0] = implode('', $gbl_smtcks_control[0]);
	$gbl_smtcks_control[1] = implode('', $gbl_smtcks_control[1]);
	$gbl_smtcks_control[2] = implode('', $gbl_smtcks_control[2]);
	
	$Feature['Ticket List Control Settings'] = <<<data
<div id="gbl_smtcks_settings">
<form method="post" action="">
	<table>
		<tbody>
			<tr>
				<td colspan="2">
					<div id="gbl_smtcks_divs">
						<div id="gbl_smtcks_setting">
							<span id="gbl_smtcks_setting_left">Select View (Default):</span>
							<span id="gbl_smtcks_setting_right">
								<select name="gbl_smtcks_view" onchange="this.form.submit()">
									$gbl_smtcks_control[0]
								</select>
							</span>
						</div>
						<div id="gbl_smtcks_setting">
							<span id="gbl_smtcks_setting_left">Sort By (Default):</span>
							<span id="gbl_smtcks_setting_right">
								<select name="gbl_smtcks_sort" onchange="this.form.submit()">
									$gbl_smtcks_control[1]
								</select>
							</span>
						</div>
					</div>
					<div id="gbl_smtcks_divs">
						<div id="gbl_smtcks_setting">
							<span id="gbl_smtcks_setting_left">Order (Default):</span>
							<span id="gbl_smtcks_setting_right">
								<select name="gbl_smtcks_order" onchange="this.form.submit()">
									$gbl_smtcks_control[2]
								</select>
							</span>
						</div>
						<!--
						<div id="gbl_smtcks_setting">
							<span id="gbl_smtcks_setting_left"></span>
							<span id="gbl_smtcks_setting_right"></span>
						</div>
						-->
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</form>
</div>
data;
	
	return $Feature;
}

function GBL_SMTCKS_LIST_OPTIONS()
{
	global $GBLCOM, $GBL_SMTCKS;
	
	$layout = null;
	$gbl_smtcks_control = array(array(), array(), array(), array());
	$GBL_ADMIN_CONTROL_INSERTS = GBL_ADMIN_CONTROL_INSERTS('');
	
	//	Select View Control
	if($GBL_SMTCKS['tkl_view'] == '0')
		$gbl_smtcks_control[0][0] = '<option disabled selected hidden value="0">Select View</option>';
	else
		$gbl_smtcks_control[0][0] = '<option disabled hidden value="0">Show</option>';
	
	if($GBL_SMTCKS['tkl_view'] == 'all')
		$gbl_smtcks_control[0][1] = '<option selected value="all">All</option>';
	else
		$gbl_smtcks_control[0][1] = '<option value="all">All</option>';
	
	
	foreach($GBL_SMTCKS['tkl_views'] as $tkl_select_options_id => $tkl_select_options)
	{
		if($tkl_select_options_id == 0)
			continue;
		
		$tkl_select_options = GBL_SANITISE_TEXT_ONLY($tkl_select_options);
		if($GBL_SMTCKS['tkl_view'] == $tkl_select_options)
		{
			$gbl_smtcks_control[0][] = '<option selected value="'.$tkl_select_options.'">'.$tkl_select_options.'</option>';
		}
		else
			$gbl_smtcks_control[0][] = '<option value="'.$tkl_select_options.'">'.$tkl_select_options.'</option>';
	}
	
	//	Sort By Control
	if($GBL_SMTCKS['tkl_sort'] == '0')
		$gbl_smtcks_control[1][0] = '<option disabled selected hidden value="0">Sort By</option>';
	else
		$gbl_smtcks_control[1][0] = '<option disabled hidden value="0">Sort By</option>';
	
	if($GBL_SMTCKS['tkl_sort'] == 'ticketid')
		$gbl_smtcks_control[1][1] = '<option selected value="ticketid">Ticket ID</option>';
	else
		$gbl_smtcks_control[1][1] = '<option value="ticketid">Ticket ID</option>';
	
	if($GBL_SMTCKS['tkl_sort'] == 'datemodified')
		$gbl_smtcks_control[1][2] = '<option selected value="datemodified">Date Modified</option>';
	else
		$gbl_smtcks_control[1][2] = '<option value="datemodified">Date Modified</option>';
	
	//	Order Control
	if($GBL_SMTCKS['tkl_order'] == '0')
		$gbl_smtcks_control[2][0] = '<option disabled selected hidden value="0">Order</option>';
	else
		$gbl_smtcks_control[2][0] = '<option disabled hidden value="0">Order</option>';
	
	if($GBL_SMTCKS['tkl_order'] == 'ascending')
		$gbl_smtcks_control[2][1] = '<option selected value="ascending">Ascending</option>';
	else
		$gbl_smtcks_control[2][1] = '<option value="ascending">Ascending</option>';

	if($GBL_SMTCKS['tkl_order'] == 'descending')
		$gbl_smtcks_control[2][2] = '<option selected value="descending">Descending</option>';
	else
		$gbl_smtcks_control[2][2] = '<option value="descending">Descending</option>';
	
	$gbl_smtcks_control[0] = implode('', $gbl_smtcks_control[0]);
	$gbl_smtcks_control[1] = implode('', $gbl_smtcks_control[1]);
	$gbl_smtcks_control[2] = implode('', $gbl_smtcks_control[2]);
	
	$gbl_smtcks_view_hidden = '<input value="'.$GBL_SMTCKS['tkl_view'].'" name="gbl_smtcks_view" type="hidden">';
	$gbl_smtcks_sort_hidden = '<input value="'.$GBL_SMTCKS['tkl_sort'].'" name="gbl_smtcks_sort" type="hidden">';
	$gbl_smtcks_order_hidden = '<input value="'.$GBL_SMTCKS['tkl_order'].'" name="gbl_smtcks_order" type="hidden">';
	
	$HiddenFields = null;
	
	//	CHANGE THIS LATER!!!!!!!!!!!!!!!!!!!!!!!!!
	if(function_exists('is_admin'))
	{
		if(is_admin())
			$HiddenFields = $GBL_ADMIN_CONTROL_INSERTS.$gbl_smtcks_view_hidden.$gbl_smtcks_sort_hidden.$gbl_smtcks_order_hidden;
	}
	else
		$HiddenFields = $GBL_ADMIN_CONTROL_INSERTS.$gbl_smtcks_view_hidden.$gbl_smtcks_sort_hidden.$gbl_smtcks_order_hidden;
	
	$layout .= <<<layout
<form method="get" action="">

$HiddenFields

<div id="gbl_smtcks_clear">
	<table>
		<thead>
			<tr>
				<th>
					Control
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<select name="gbl_smtcks_view" onchange="this.form.submit()">
						$gbl_smtcks_control[0]
					</select>
					<select name="gbl_smtcks_sort" onchange="this.form.submit()">
						$gbl_smtcks_control[1]
					</select>
					<select name="gbl_smtcks_order" onchange="this.form.submit()">
						$gbl_smtcks_control[2]
					</select>

				</td>
			</tr>
		</tbody>
	</table>
</div>
</form>
layout;
	
	return $layout;
}

function GBL_SMTCKS_VALIDATE_TKL($ticket_file) {
	global $GBLCOM;
	$GBLCOM['GBL_ADMIN_ADR_LINES'] = null;
	GBL_ADMIN_FETCH_ADR($ticket_file, true);
	
	return $GBLCOM['GBL_ADMIN_ADR_LINES'];
}

?>