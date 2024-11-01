<?php
//Globel Administrator Library File
// Exit if file accessed directly
global $GBLCOM, $GBL_SMTCKS;
defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
if(file_exists(GBL_ADMIN_EXTENSIONS_DIR.'/simple-tickets/simple-tickets.lib.php')) {include_once('simple-tickets.lib.php');} else {die('0');}

$Features = array();

$content = $gbl_smtcks_style.GBL_SMTCKS_ACT_SET().GBL_SMTCKS_SETTINGS();

function GBL_SMTCKS_ACT_SET() {
	global $GBLCOM, $GBL_SMTCKS;
	
	if(!isset($_POST['gbl_smtcks'])) {return '';}
	if($GBLCOM['GBL_ADMIN_ACT'] != 'Save'&!is_array($_POST['gbl_smtcks'])) {return '';}
	
	if(function_exists('GBL_SMTCKS_SETTINGS_HANDLE')) {
		return GBL_SMTCKS_SETTINGS_HANDLE();} else {
		return GBL_NOTIFICATION('There was an error saving your settings. Please try again later.', 'indianred', 'black', 10);}
}

function GBL_SMTCKS_SETTINGS() {
	global $GBLCOM, $GBL_SMTCKS;
	$GBL_ADMIN_CONTROL_INSERTS = GBL_ADMIN_CONTROL_INSERTS("");
	$gbl_disp_settings = '';
	$Features = array();
	$GBL_SMTCKS_EMAIL = explode(",", $GBLCOM['GBL_SMTCKS_EMAILS']);
	if($GBL_SMTCKS_EMAIL[0]) {$GBL_SMTCKS_EMAIL[0] = '<option selected="selected">Yes</option><option>No</option>';} else {$GBL_SMTCKS_EMAIL[0] = '<option>Yes</option><option selected="selected">No</option>';}
	if($GBL_SMTCKS_EMAIL[1]) {$GBL_SMTCKS_EMAIL[1] = '<option selected="selected">Yes</option><option>No</option>';} else {$GBL_SMTCKS_EMAIL[1] = '<option>Yes</option><option selected="selected">No</option>';}
	if($GBL_SMTCKS_EMAIL[2]) {$GBL_SMTCKS_EMAIL[2] = '<option selected="selected">Yes</option><option>No</option>';} else {$GBL_SMTCKS_EMAIL[2] = '<option>Yes</option><option selected="selected">No</option>';}
	$Features['Basic Settings'] = <<<data
<div id="gbl_smtcks_settings">
<table>
<tbody>
<tr>
<td>
<div id="gbl_smtcks_divs"><div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">
Minimum amount of characters for a new ticket details: 
</span>
<span id="gbl_smtcks_setting_right">
<input name="gbl_smtcks_maxdets" type="text" min="0" value="$GBLCOM[GBL_SMTCKS_MAXDETS]">
</span>
</div><div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">
Minimum amount of characters that a comment has to contain:
</span>
<span id="gbl_smtcks_setting_right">
<input name="gbl_smtcks_comment_min" type="text" min="0" value="$GBLCOM[GBL_SMTCKS_COMMENT_MIN]">
</span>
</div><div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">
Time the user has to wait after creating a ticket in order to create the next one: 
</span>
<span id="gbl_smtcks_setting_right">
<input name="gbl_smtcks_timewait" type="text" min="0" value="$GBLCOM[GBL_SMTCKS_TIMEWAIT]">
</span>
</div>
</div>
<div id="gbl_smtcks_divs"><div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">
Send E-mail to website administrator if someone creates a ticket?
</span>
<span id="gbl_smtcks_setting_right">
<select name="GBL_SMTCKS_EMAIL0">$GBL_SMTCKS_EMAIL[0]</select>
</span>
</div><div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">
Send E-mail to website administrator if someone updates a ticket settings?
</span>
<span id="gbl_smtcks_setting_right">
<select name="GBL_SMTCKS_EMAIL2">$GBL_SMTCKS_EMAIL[2]</select>
</span>
</div><div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">
Send E-mail to website administrator if someone creates a comment in a ticket?
</span>
<span id="gbl_smtcks_setting_right">
<select name="GBL_SMTCKS_EMAIL1">$GBL_SMTCKS_EMAIL[1]</select>
</span></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
$GBL_ADMIN_CONTROL_INSERTS
data;
	
	if(function_exists('GBL_SMTCKS_CONTROL_SETTINGS'))
		$Features += GBL_SMTCKS_CONTROL_SETTINGS();
	
	if($GBLCOM['GBL_ADMIN_ADVANCED_FEATURES'] == 'on') {$Features += GBL_SMTCKS_ADVANCED_SETTINGS();}
	return '<form action="" method="post">'.GBL_ADMIN_WRAP_ACCORDION($Features,'GBL_ADMIN_ACCORDION_SMTCKS_SETTINGS').'<table><tbody><tr><td><CENTER><input class="btn" name="gblact" value="Save" id="btn" type="submit"></CENTER></td></tr></tbody></table></div></form>';
}

function GBL_SMTCKS_ADVANCED_SETTINGS() {
	global $GBLCOM, $GBL_SMTCKS;
	$gbl_smtcks_select = '';
	$GBL_SMTCKS_DETRACT = '';
	$GBL_SMTCKS_TYPES = '';
	$Features = array();
	$GLB_SMTCKS_TYPES_ARR = array();
	foreach($GBL_SMTCKS['SETTINGS'] as $gbl_smtcks_settingL0) {
		$gbl_smtcks_settingL0 = explode(',', $gbl_smtcks_settingL0, 22);
		if(count($gbl_smtcks_settingL0) > 21) {
			if($gbl_smtcks_settingL0[0] == 'TKS') {
				$gbl_smtcks_settingL0[3] = str_replace('_', ' ', ucfirst($gbl_smtcks_settingL0[3]));
				$gbl_smtcks_options = '';
				$GBL_SMTCKS_TYPES = '';
				$GLB_SMTCKS_TYPES_ARR = array();
				$gbl_smtcks_types = array("1" => "select","2" => "date","4" => "time","5" => "text","6" => "checkbox","7" => "color","8" => "datetime-local","9" => "email","10" => "file","11" => "image","12" => "month","13" => "number","14" => "password","15" => "range","16" => "tel","17" => "url","18" => "week");
				foreach($gbl_smtcks_types as $gbl_smtcks_option) {
					if($gbl_smtcks_settingL0[2] == $gbl_smtcks_option) {
						$gbl_smtcks_options .= '<option selected="selected">'.$gbl_smtcks_option.'</option>';} else {
						$gbl_smtcks_options .= '<option>'.$gbl_smtcks_option.'</option>';}
				}
				if($gbl_smtcks_settingL0[4]) {$gbl_smtcks_settingL0[4] = '<option selected="selected">Yes</option><option>No</option>';} else {$gbl_smtcks_settingL0[4] = '<option>Yes</option><option selected="selected">No</option>';}
				if($gbl_smtcks_settingL0[5]) {$gbl_smtcks_settingL0[5] = '<option selected="selected">Yes</option><option>No</option>';} else {$gbl_smtcks_settingL0[5] = '<option>Yes</option><option selected="selected">No</option>';}
				if($gbl_smtcks_settingL0[6]) {$gbl_smtcks_settingL0[6] = '<option selected="selected">Yes</option><option>No</option>';} else {$gbl_smtcks_settingL0[6] = '<option>Yes</option><option selected="selected">No</option>';}
				if($gbl_smtcks_settingL0[7]) {$gbl_smtcks_settingL0[7] = '<option selected="selected">Yes</option><option>No</option>';} else {$gbl_smtcks_settingL0[7] = '<option>Yes</option><option selected="selected">No</option>';}
				
				if($gbl_smtcks_settingL0[2] == $gbl_smtcks_types[1]) {
					
					if(substr($gbl_smtcks_settingL0[21], -1) == ',')
						$gbl_smtcks_settingL0[21] = substr($gbl_smtcks_settingL0[21], 0, -1);
					
					$gbl_smtcks_select = <<<data
<div id="gbl_smtcks_setting"><span id="gbl_smtcks_setting_left">Select Options:</span>
<span id="gbl_smtcks_setting_right">
<input name="gbl_smtcks[$gbl_smtcks_settingL0[1]][select]" style="min-width: 180px;" placeholder="Your select options here e.g. High,Medium,Low" value="$gbl_smtcks_settingL0[21]"></span></div>
data;
				} else {
					$gbl_smtcks_select = <<<data
<input name="gbl_smtcks[$gbl_smtcks_settingL0[1]][select]" type="hidden" style="min-width: 180px;" placeholder="Your select options here e.g. High,Medium,Low" value="$gbl_smtcks_settingL0[21]">
data;
				}
				if($gbl_smtcks_settingL0[3] == 'Status'&$gbl_smtcks_settingL0[2] == 'select'&strlen($gbl_smtcks_settingL0[21]) > 5) {
					$GLB_SMTCKS_TYPES_ARR = explode(',', $gbl_smtcks_settingL0[21]);
					$GBL_SMTCKS_TYPES .= '<div id="gbl_smtcks_divs">';
					$GBL_SMTCKS_COLOURS = array();
					$GBL_SMTCKS_COLOUR = 'inherit';
					if($gbl_smtcks_settingL0[9] == serialize(false) || @unserialize($gbl_smtcks_settingL0[9]) !== false) {
						$GBL_SMTCKS_COLOURS = unserialize($gbl_smtcks_settingL0[9]);
					}
					foreach($GLB_SMTCKS_TYPES_ARR as $GLB_SMTCKS_TYPES_ARR_EACH_ID => $GLB_SMTCKS_TYPES_ARR_EACH) {
						if(strlen($GLB_SMTCKS_TYPES_ARR_EACH) < 2) {continue;}
						if(isset($GBL_SMTCKS_COLOURS[$GLB_SMTCKS_TYPES_ARR_EACH])) {
							$GBL_SMTCKS_COLOUR = $GBL_SMTCKS_COLOURS[$GLB_SMTCKS_TYPES_ARR_EACH];
						}
						if($GLB_SMTCKS_TYPES_ARR_EACH != '') {
							$GBL_SMTCKS_TYPES .= <<<data
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">Ticket List Colour '$GLB_SMTCKS_TYPES_ARR_EACH':</span>
<span id="gbl_smtcks_setting_right">
<input type="text" value="$GBL_SMTCKS_COLOUR" name="gbl_smtcks[$gbl_smtcks_settingL0[1]][color][$GLB_SMTCKS_TYPES_ARR_EACH]">
</span>
</div>
data;
						}
					}
					$GBL_SMTCKS_TYPES .= '</div>';
				}
				
				$Features[$gbl_smtcks_settingL0[3]] = <<<data
<div id="gbl_smtcks_settings">
<table>
<tbody>
<tr>
<td colspan="2">
<div id="gbl_smtcks_divs">
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">Label:</span>
<span id="gbl_smtcks_setting_right"><input name="gbl_smtcks[$gbl_smtcks_settingL0[1]][label]" type="text" value="$gbl_smtcks_settingL0[3]"></span>
</div>
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">Placeholder:</span>
<span id="gbl_smtcks_setting_right"><input name="gbl_smtcks[$gbl_smtcks_settingL0[1]][placeholder]" type="text" value="$gbl_smtcks_settingL0[8]"></span>
</div>
</div>
<div id="gbl_smtcks_divs">
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">Type:</span>
<span id="gbl_smtcks_setting_right"><select name="gbl_smtcks[$gbl_smtcks_settingL0[1]][type]" onchange="this.form.submit()">$gbl_smtcks_options</select></span>
</div>
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">Enabled:</span>
<span id="gbl_smtcks_setting_right"><select name="gbl_smtcks[$gbl_smtcks_settingL0[1]][enabled]">$gbl_smtcks_settingL0[4]</select></span>
</div>
</div>
<div id="gbl_smtcks_divs">
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">Required:</span>
<span id="gbl_smtcks_setting_right"><select name="gbl_smtcks[$gbl_smtcks_settingL0[1]][required]">$gbl_smtcks_settingL0[5]</select></span>
</div>
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">Hidden:</span>
<span id="gbl_smtcks_setting_right"><select name="gbl_smtcks[$gbl_smtcks_settingL0[1]][hidden]">$gbl_smtcks_settingL0[6]</select></span>
</div>
</div>
<div id="gbl_smtcks_divs">
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">Display in Ticket List:</span>
<span id="gbl_smtcks_setting_right"><select name="gbl_smtcks[$gbl_smtcks_settingL0[1]][ticketlist]">$gbl_smtcks_settingL0[7]</select></span>
</div>
$gbl_smtcks_select
</div>
$GBL_SMTCKS_TYPES
</td>
</tr>
</tbody>
</table>
</div>
data;
			}
		}
	}
	return $Features;
}

function GBL_SMTCKS_SETTINGS_HANDLE() {
	global $GBLCOM, $GBL_SMTCKS;
	$GBLCOM['GBL_ADMIN_ADR_LINES'] = null;
	
	if(isset($_POST['gbl_smtcks_maxdets'])&isset($_POST['gbl_smtcks_timewait'])&isset($_POST['GBL_SMTCKS_EMAIL0'])&isset($_POST['GBL_SMTCKS_EMAIL1'])&isset($_POST['GBL_SMTCKS_EMAIL2'])&isset($_POST['gbl_smtcks_comment_min'])) {
		if ( is_numeric($_POST['gbl_smtcks_timewait'])){$GBLCOM['GBL_SMTCKS_TIMEWAIT']=intval($_POST['gbl_smtcks_timewait']);}
		else {return GBL_NOTIFICATION('TIME TO WAIT WAS NOT A NUMBER?', 'red', 'black', 10);}
		if ( is_numeric($_POST['gbl_smtcks_maxdets'])){$GBLCOM['GBL_SMTCKS_MAXDETS']=intval($_POST['gbl_smtcks_maxdets']);}
		else {return GBL_NOTIFICATION('Minimum amount of characters <br> is not a number?', 'red', 'black', 10);}
		if ( is_numeric($_POST['gbl_smtcks_comment_min'])){$GBLCOM['GBL_SMTCKS_COMMENT_MIN']=intval($_POST['gbl_smtcks_comment_min']);}
		else {return GBL_NOTIFICATION('Minimum amount of characters <br> is not a number?', 'red', 'black', 10);}
		if(GBL_SANITISE_TEXT_FIELD($_POST['GBL_SMTCKS_EMAIL0']) == 'Yes') {$GBL_SMTCKS_EMAIL0 = 1;} else {$GBL_SMTCKS_EMAIL0 = 0;}
		if(GBL_SANITISE_TEXT_FIELD($_POST['GBL_SMTCKS_EMAIL1']) == 'Yes') {$GBL_SMTCKS_EMAIL1 = 1;} else {$GBL_SMTCKS_EMAIL1 = 0;}
		if(GBL_SANITISE_TEXT_FIELD($_POST['GBL_SMTCKS_EMAIL2']) == 'Yes') {$GBL_SMTCKS_EMAIL2 = 1;} else {$GBL_SMTCKS_EMAIL2 = 0;}
		$GBLCOM['GBL_SMTCKS_EMAILS'] = $GBL_SMTCKS_EMAIL0.','.$GBL_SMTCKS_EMAIL1.','.$GBL_SMTCKS_EMAIL2;
		$GBL_SMTCKS_TICKET = $GBLCOM['GBL_SMTCKS_MAXDETS'].','.$GBLCOM['GBL_SMTCKS_TIMEWAIT'].','.$GBLCOM['GBL_SMTCKS_COMMENT_MIN'].','.$GBLCOM['GBL_SMTCKS_EMAILS'];
		GBL_SAVE_FILE_CONTENTS(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/ticket.tks', $GBL_SMTCKS_TICKET);
	}
	
	foreach($GBL_SMTCKS['SETTINGS'] as $GBL_SMTCKS_WHERE_ID => $GBL_SMTCKS_WHERE) {
		$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_WHERE_ID] = explode(',', $GBL_SMTCKS_WHERE, 22);
	}
	
	foreach($_POST['gbl_smtcks'] as $GBL_SMTCK_ID => $GBL_SMTCK) {
		if(isset($GBL_SMTCK['label'])&isset($GBL_SMTCK['placeholder'])&isset($GBL_SMTCK['type'])&isset($GBL_SMTCK['enabled'])&isset($GBL_SMTCK['required'])&isset($GBL_SMTCK['hidden'])&isset($GBL_SMTCK['ticketlist'])&isset($GBL_SMTCK['select'])) {
			foreach($GBLCOM['GBL_ADMIN_ADR_LINES'] as $GBL_SMTCKS_TEST_ID => $GBL_SMTCKS_TEST) {
				if(isset($GBL_SMTCKS_TEST[1])) {
					if($GBL_SMTCKS_TEST[1] == $GBL_SMTCK_ID) {
						$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][2] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $GBL_SMTCK['type']));
						$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][3] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $GBL_SMTCK['label']));
						$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][4] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $GBL_SMTCK['enabled']));
						$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][5] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $GBL_SMTCK['required']));
						$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][6] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $GBL_SMTCK['hidden']));
						$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][7] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $GBL_SMTCK['ticketlist']));
						$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][21] = GBL_SANITISE_TEXT_FIELD($GBL_SMTCK['select']);
						
						while(substr($GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][21], -1) == ',')
							$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][21] = substr($GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][21], 0, -1);
						
						$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][21] .= ',';
						
						if($GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][4] == 'Yes') {$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][4] = 1;} else {$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][4] = 0;}
						if($GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][5] == 'Yes') {$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][5] = 1;} else {$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][5] = 0;}
						if($GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][6] == 'Yes') {$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][6] = 1;} else {$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][6] = 0;}
						if($GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][7] == 'Yes') {$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][7] = 1;} else {$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][7] = 0;}
						
						//if($GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][2] == 'email') {
							//$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][8] = GBL_SANITISE_EMAIL(str_replace(',', '', $GBL_SMTCK['placeholder']));} else {
							$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][8] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $GBL_SMTCK['placeholder']));
						//}
						
						if(isset($GBL_SMTCK['color'])) {
							if(is_array($GBL_SMTCK['color'])) {
								foreach($GBL_SMTCK['color'] as $GBL_SMTCK_COLOR_ID => $GBL_SMTCK_COLOR) {
									$GBL_SMTCK['color'][$GBL_SMTCK_COLOR_ID] = str_replace('hashtag', '#', GBL_SANITISE_TEXT_FIELD(str_replace('#', 'hashtag', str_replace(',', '', $GBL_SMTCK_COLOR))));
								}
								$GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID][9] = serialize($GBL_SMTCK['color']);
							}
						}
						$GBL_SMTCKS['SETTINGS'][$GBL_SMTCKS_TEST_ID] = implode(',', $GBLCOM['GBL_ADMIN_ADR_LINES'][$GBL_SMTCKS_TEST_ID]);
					}
				}
			}
		}
	}
	
	if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
		GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default', 'settings.tks');
	
	GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/settings.tks');
	$GBLCOM['GBL_ADMIN_ADR_LINES'] = '';
	
	$ACCORD[0] = "ACCORDION"; // for 5 part accordion
	if((isset($_REQUEST["ACCORDION1"])) && $_REQUEST["ACCORDION1"] == "checked"){$ACCORD[1] = "checked";}else {$ACCORD[1] = "";}
	if((isset($_REQUEST["ACCORDION2"])) && $_REQUEST["ACCORDION2"] == "checked"){$ACCORD[2] = "checked";}else {$ACCORD[2] = "";}
	if((isset($_REQUEST["ACCORDION3"])) && $_REQUEST["ACCORDION3"] == "checked"){$ACCORD[3] = "checked";}else {$ACCORD[3] = "";}
	if((isset($_REQUEST["ACCORDION4"])) && $_REQUEST["ACCORDION4"] == "checked"){$ACCORD[4] = "checked";}else {$ACCORD[4] = "";}
	if((isset($_REQUEST["ACCORDION5"])) && $_REQUEST["ACCORDION5"] == "checked"){$ACCORD[5] = "checked";}else {$ACCORD[5] = "";}
	if((isset($_REQUEST["ACCORDION6"])) && $_REQUEST["ACCORDION6"] == "checked"){$ACCORD[6] = "checked";}else {$ACCORD[6] = "";}
	if((isset($_REQUEST["ACCORDION7"])) && $_REQUEST["ACCORDION7"] == "checked"){$ACCORD[7] = "checked";}else {$ACCORD[7] = "";}
	$GBLCOM['GBL_ADMIN_ACCORDION_'.'SMTCKS_SETTINGS'] = implode(",",$ACCORD);
	GBL_SAVE_COMFILE($GBLCOM,"","","GBL_ADMIN_APP_NAME",GBL_ADMIN_APP_NAME,"GBLCOM",GBL_ADMIN_DATA_DIR."/");
	
	return GBL_NOTIFICATION('Settings updated.', 'green', 'white', 5);
}

?>
