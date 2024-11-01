<?php
//Globel Administrator Library File
// Exit if file accessed directly
global $GBLCOM, $GBL_SMTCKS;

defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
if(file_exists(GBL_ADMIN_EXTENSIONS_DIR.'/simple-tickets/simple-tickets.lib.php')) {include_once('simple-tickets.lib.php');} else {die('0');}

if(isset($_POST['gbl_smtcks_0']))
	$GBL_SMTCKS['DETAILS'] = str_replace(',', '!£"*', str_replace('_br_', "\n", GBL_SANITISE_TEXT_FIELD(str_replace("\n", '_br_', $_POST['gbl_smtcks_0']))));
else
	$GBL_SMTCKS['DETAILS'] = '';

function GBL_SMTCKS_LAST_ENTRY()
{
	global $GBLCOM;
	
	$Tickets = scandir(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets');
	$return = 1;
	foreach($Tickets as $Ticket)
	{
		$Ticket = GBL_SANITISE_NUMBER_ONLY($Ticket);
		if($return <= $Ticket)
			$return = $Ticket+1;
	}
	return $return;
}

if(!defined('GBL_SMTCKS_WEBSITE'))
	$content = $gbl_smtcks_style.GBL_SMTCKS_ACT_NEW().GBL_SMTCKS_NEW_TICKET();

function GBL_SMTCKS_ACT_NEW() {
	global $GBLCOM, $GBL_SMTCKS;
	
	if($GBLCOM['GBL_ADMIN_ACT'] == '')
		return '';
	
	if($GBLCOM['GBL_ADMIN_ACT'] == 'Create Ticket')
	{
		if(function_exists('GBL_SMTCKS_NEW_TICKET_HANDLE'))
			return GBL_SMTCKS_NEW_TICKET_HANDLE();
		else
			return GBL_NOTIFICATION('There was an error creating your ticket. Please try again later.', 'indianred', 'black', 10);
	}
	return '';
}

function GBL_SMTCKS_NEW_TICKET($type = null) {
	global $GBLCOM, $GBL_SMTCKS;
	
	$gbl_smtcks_secondary_fields = '';
	$gbl_smtcks_per_box = 0;
	$gbl_smtcks_primary_details = GBL_CREATE_HTML('textarea', 'gbl_smtcks_0', str_replace('!£"*', ',', $GBL_SMTCKS['DETAILS']), 'id="gbl_smtcks_details_0"');
	if(defined('GBL_SMTCKS_WEBSITE')) {
		$gbl_smtcks_chars = '(Min. '.$GBLCOM['GBL_SMTCKS_MAXDETS'].' Characters)';} else {
		$gbl_smtcks_chars = '';}
	$gbl_smtcks_primaryL0 = '<div id="gbl_smtcks_primary"><table><thead><tr><th>Ticket Details '.$gbl_smtcks_chars.'</th></tr></thead>';
	$gbl_smtcks_primaryL1 = '<tbody><tr><td>'.$gbl_smtcks_primary_details.'</td></tr><tr><td style="text-align: center;"><input class="btn" type="submit" name="gblact" value="Create Ticket"></td></tr></tbody></table></div>';
	$gbl_settings_L1_KEYS = array_keys($GBL_SMTCKS['SETTINGS']);
	$gbl_settings_L1_KEYS_LAST = array_pop($gbl_settings_L1_KEYS);
	foreach($GBL_SMTCKS['SETTINGS'] as $gbl_settings_L1_ID => $gbl_settings_L1) {
		if(strlen($gbl_settings_L1) > 50) {	
			$gbl_settings_L1 = explode(',', $gbl_settings_L1, 22);
			if(defined('GBL_SMTCKS_WEBSITE')) {
				if($gbl_settings_L1[0] == 'TKS'&$gbl_settings_L1[4]&!$gbl_settings_L1[6]) {
					$GBL_SMTCKS_FULL = true;
					if($gbl_settings_L1[5]) {
						$gbl_smtcks_starred = '<a style="color: red;">*</a>';} else {
						$gbl_smtcks_starred = '';}
				} else {$GBL_SMTCKS_FULL = false;}
			} else {
				if($gbl_settings_L1[0] == 'TKS'&$gbl_settings_L1[4]) {
					$GBL_SMTCKS_FULL = true;
					$gbl_smtcks_starred = '';} else {
					$GBL_SMTCKS_FULL = false;}
			}
			if($GBL_SMTCKS_FULL) {
				$gbl_settings_L1[1] = GBL_SANITISE_TEXT_FIELD($gbl_settings_L1[1]);
				if(isset($_POST['gbl_smtcks_'.$gbl_settings_L1[1]])) {
					if($gbl_settings_L1[2] == 'select') {
						$gbl_smtcks_value = explode(',', $gbl_settings_L1[21], -1);
						$gbl_smtcks_whatsselected = GBL_SANITISE_TEXT_FIELD($_POST['gbl_smtcks_'.$gbl_settings_L1[1]]);
					} else {
						//if($gbl_settings_L1[2] == 'email') {
						//$gbl_smtcks_value = GBL_SANITISE_EMAIL($_POST['gbl_smtcks_'.$gbl_settings_L1[1]]);} else {
						$gbl_smtcks_value = GBL_SANITISE_TEXT_FIELD($_POST['gbl_smtcks_'.$gbl_settings_L1[1]]);//}
						$gbl_smtcks_whatsselected = null;
					}
				} else {
					if($gbl_settings_L1[2] == 'select') {
						$gbl_smtcks_value = explode(',', $gbl_settings_L1[21], -1);} else {
						$gbl_smtcks_value = null;}
					$gbl_smtcks_whatsselected = null;
				}
				
				$gbl_smtcks_per_box++;
				if($gbl_smtcks_per_box > 2) {
					$gbl_smtcks_per_box = 1;
					$gbl_smtcks_secondary_fields .= '</div><div id="gbl_smtcks_divs">';
				}
				
				$gbl_smtcks_secondary_fields .= '<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">'.ucfirst(str_replace('_', ' ', htmlentities($gbl_settings_L1[3]))).$gbl_smtcks_starred.'</span><span id="gbl_smtcks_setting_right">
'.GBL_CREATE_HTML($gbl_settings_L1[2], 'gbl_smtcks_'.$gbl_settings_L1[1], $gbl_smtcks_value, 'placeholder="'.$gbl_settings_L1[8].'" style="width: auto;"', $gbl_smtcks_whatsselected).'
</span></div>
';
				if($gbl_settings_L1_KEYS_LAST == $gbl_settings_L1_ID) {
					$gbl_smtcks_secondary_fields .= '</div>';
				}
			}
		}
	}
	
	$gbl_smtcks_secondaryL0 = '<div id="gbl_smtcks_secondary"><table><thead><tr><th>Settings</th></tr></thead><tbody><tr><td><div id="gbl_smtcks_divs">';
	$gbl_smtcks_secondaryL1 = '</td></tr></tbody></table></div>';
	if($type != null)
		return '<form method="post" action="">'.GBL_ADMIN_CONTROL_INSERTS("").$gbl_smtcks_secondaryL0.$gbl_smtcks_secondary_fields.$gbl_smtcks_secondaryL1.$gbl_smtcks_primaryL0.$gbl_smtcks_primaryL1.'</form>';
	else
		return '<form method="post" action="">'.GBL_ADMIN_CONTROL_INSERTS("").'<div id="gbl_smtcks_center"><div id="gbl_smtcks_admin">'.$gbl_smtcks_secondaryL0.$gbl_smtcks_secondary_fields.$gbl_smtcks_secondaryL1.'</div><div id="gbl_smtcks_admin_main">'.$gbl_smtcks_primaryL0.$gbl_smtcks_primaryL1.'</div></div></form>';
}
/*'.str_replace($GBLCOM['GBL_ADMIN_PAGE'], 'ticket_list', $GBL_SMTCKS['A_HREF']).'*/


function GBL_SMTCKS_NEW_TICKET_VALIDATE() {
	global $GBLCOM, $GBL_SMTCKS;
	$gbl_smtcks_toret = false;
	if(defined('GBL_SMTCKS_WEBSITE')) {
		if(strlen($GBL_SMTCKS['DETAILS']) < $GBLCOM['GBL_SMTCKS_MAXDETS']) {
			$gbl_smtcks_toret .= 'Ticket Details cannot be shorter than '.$GBLCOM['GBL_SMTCKS_MAXDETS'].' characters.<br />';
		}
		$gbl_smtcks_monthyear = strtotime(date('M Y'));
		if(GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$gbl_smtcks_monthyear.'.tkl')) {
			foreach($GBLCOM['GBL_ADMIN_ADR_LINES'] as $GBL_SMTCKS_TKLL0)
			{
				if($GBL_SMTCKS_TKLL0[0] == 'TKL'&$GBL_SMTCKS_TKLL0[4] == $_SERVER['REMOTE_ADDR'])
				{
					if($GBL_SMTCKS_TKLL0[3] > time() - ($GBLCOM['GBL_SMTCKS_TIMEWAIT']*60))
					{
						$gbl_smtcks_toret .= 'You have to wait until '.date('H:i:s A', $GBL_SMTCKS_TKLL0[3] + ($GBLCOM['GBL_SMTCKS_TIMEWAIT']*60)).' before creating a new ticket.'."<br />";
						break;
					}
				}
			}
		}
		foreach($GBL_SMTCKS['SETTINGS'] as $gbl_settings_L1) {
			if(strlen($gbl_settings_L1) > 50) {
				$gbl_settings_L1 = explode(',', $gbl_settings_L1, 22);
				$gbl_settings_L1[1] = GBL_SANITISE_TEXT_FIELD($gbl_settings_L1[1]);
				if(isset($_POST['gbl_smtcks_'.$gbl_settings_L1[1]])) {
					if($gbl_settings_L1[4]&$gbl_settings_L1[5]&!$gbl_settings_L1[6]) {
						if($gbl_settings_L1[2] == 'email') {
							$gbl_smtcks_post = GBL_SANITISE_TEXT_FIELD($_POST['gbl_smtcks_'.$gbl_settings_L1[1]]);
							//$gbl_smtcks_post = GBL_SANITISE_EMAIL($_POST['gbl_smtcks_'.$gbl_settings_L1[1]]);
							if(strpos($gbl_smtcks_post, '@') == false|strpos($gbl_smtcks_post, '.') == false) {
								$gbl_smtcks_toret .= 'Your '.ucfirst(str_replace('_', ' ', $gbl_settings_L1[3])).' is invalid.<br />';
								continue;
							}} else {
								$gbl_smtcks_post = GBL_SANITISE_TEXT_FIELD($_POST['gbl_smtcks_'.$gbl_settings_L1[1]]);
							if(strlen($gbl_smtcks_post) < 1) {
								$gbl_smtcks_toret .= 'Field '.ucfirst(str_replace('_', ' ', $gbl_settings_L1[3])).' cannot be empty.<br />';
							}
						}
					}
				}
			}
		}
	} else {
		if(strlen($GBL_SMTCKS['DETAILS']) < 1) {$gbl_smtcks_toret .= 'Ticket Details cannot be empty.';}
	}
	return $gbl_smtcks_toret;
}

function GBL_SMTCKS_NEW_TICKET_HANDLE() {
	global $GBLCOM, $GBL_SMTCKS;
	$GBLCOM['GBL_ADMIN_ADR_LINES'] = array();
	$test = GBL_SMTCKS_NEW_TICKET_VALIDATE();
	if($test == true) {return GBL_NOTIFICATION($test, 'orange', 'black', 10);}
	$gbl_smtcks_post = array();
	$gbl_smtcks_timec = time();
	$GBL_SMTCKS_TKLL0 = array();
	$GBL_SMTCKS_TEMP_ADR = array();
	$GBL_SMTCKS_ARRAY=  array();
	$GBL_SMTCKS_TKLNOW = strtotime(date('M Y')).'.tkl';
	
	foreach($GBL_SMTCKS['SETTINGS'] as $gbl_settings_L1) {
		$gbl_settings_L1 = explode(',', $gbl_settings_L1);
		if($gbl_settings_L1[0] == 'TKS') {
			$gbl_settings_L1[1] = GBL_SANITISE_TEXT_FIELD($gbl_settings_L1[1]);
			
			if(isset($_POST['gbl_smtcks_'.$gbl_settings_L1[1]]))
				$gbl_smtcks_post[] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $_POST['gbl_smtcks_'.$gbl_settings_L1[1]]));//}
			else
				$gbl_smtcks_post[] = '';
		}
	}
	
	$gbl_smtcks_ticketlists = scandir(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID']);
	foreach($gbl_smtcks_ticketlists as $GBL_TICKETLIST_L0)
	{
		if(substr($GBL_TICKETLIST_L0, -4) == '.tkl')
			$GBL_SMTCKS_TKLL0[] = $GBL_TICKETLIST_L0;
	}
	
	if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$GBL_SMTCKS_TKLNOW))
		GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$GBL_SMTCKS_TKLNOW);
	
	if(!isset($GBLCOM['GBL_ADMIN_ADR_LINES'][0][0]))
	{
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0] = GBL_ADMIN_CREATE_ADR('HEADER', '', 2);
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][1] = 'ID';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][2] = 'GBL_ADMIN_USER';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][3] = 'TIME CREATED';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][4] = 'IP';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][20] = 'CUSTOM FIELDS';
	}
	
	$GBL_SMTCKS_TEMP_ADR = GBL_ADMIN_CREATE_ADR('TKL', '', 2);
	$GBL_SMTCKS_TEMP_ADR[1] = GBL_SMTCKS_LAST_ENTRY();
	$GBL_SMTCKS_TEMP_ADR[2] = $GBLCOM['GBL_ADMIN_USER'];
	$GBL_SMTCKS_TEMP_ADR[3] = $gbl_smtcks_timec;
	$GBL_SMTCKS_TEMP_ADR[4] = $_SERVER['REMOTE_ADDR'];
	
	foreach($gbl_smtcks_post as $gbl_smtcks_post_id => $gbl_smtcks_post_val)
		$GBL_SMTCKS_TEMP_ADR[20+$gbl_smtcks_post_id] = $gbl_smtcks_post_val;
	
	$GBLCOM['GBL_ADMIN_ADR_LINES'][] = $GBL_SMTCKS_TEMP_ADR;
	
	if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
		GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'], $GBL_SMTCKS_TKLNOW);
	
	GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$GBL_SMTCKS_TKLNOW);
	
	$GBLCOM['GBL_ADMIN_ADR_LINES'] = array(array('HEAD','ID','DATE CREATED','WHO BY','EDITED','','','','',''), array('COM','1',$gbl_smtcks_timec,$GBLCOM['GBL_ADMIN_USER'],'','','','','', str_replace("\n", '_br_', $GBL_SMTCKS['DETAILS'])));
	
	GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$GBL_SMTCKS_TEMP_ADR[1]);
	
	if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
		GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets', $GBL_SMTCKS_TEMP_ADR[1]);
	
	// E-mail
	$GBL_SMTCKS_ARRAY = explode(',', $GBLCOM['GBL_SMTCKS_EMAILS']);
	if($GBL_SMTCKS_ARRAY[0] == 1)
	{
		if(GBL_ADMIN_MYNAME == 'GlobelWP') {$GBL_WHOTO = get_option('admin_email');} else {
			if(isset($_SERVER['SERVER_ADMIN']))
				$GBL_WHOTO = $_SERVER['SERVER_ADMIN'];
			else
				$GBL_WHOTO = 'noreply@'.GBL_ADMIN_BASEURI_PLAIN;
		}
		
		GBL_ADMIN_SENDMAIL('noreply@'.$_SERVER['SERVER_NAME'], $GBL_WHOTO, 'Simple Tickets [New Ticket]', 'A new ticket has been created by '.$GBLCOM['GBL_ADMIN_USER'].' at '.date('H:i:s A, d M Y', $gbl_smtcks_timec).'.');
	}
	
	return GBL_NOTIFICATION('Your ticket has been created.', 'green', 'white', 5);
}

?>