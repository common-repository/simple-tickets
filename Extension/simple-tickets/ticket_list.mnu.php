<?php
//Globel Administrator Library File
// Exit if file accessed directly
global $GBLCOM, $GBL_SMTCKS;

defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
if(file_exists(GBL_ADMIN_EXTENSIONS_DIR.'/simple-tickets/simple-tickets.lib.php')) {include_once('simple-tickets.lib.php');} else {die('0');}
$content = $gbl_smtcks_style.GBL_SMTCKS_ACT_LIST().GBL_SMTCKS_TKTLIST_INIT();

function GBL_SMTCKS_ACT_LIST()
{
	global $GBLCOM, $GBL_SMTCKS;
	
	if($GBLCOM['GBL_ADMIN_ACT'] == '')
		return '';
	
	switch($GBLCOM['GBL_ADMIN_ACT'])
	{
		case 'Update Settings':
		if(function_exists('GBL_SMTCKS_UPDATE_SETTINGS'))
			return GBL_SMTCKS_UPDATE_SETTINGS();
		else
			return GBL_NOTIFICATION('There was an error saving this ticket settings. Please try again later.', 'indianred', 'black', 10);
		
		case 'Create Comment':
		if(function_exists('GBL_SMTCKS_CREATE_COMMENT'))
			return GBL_SMTCKS_CREATE_COMMENT();
		else
			return GBL_NOTIFICATION('There was an error while trying to create new comment. Please try again later.', 'indianred', 'black', 10);
		
		case 'Update':
		if(isset($_POST['gbl_smtcks_comment_update']))
		{
			if(function_exists('GBL_SMTCKS_EDIT_COMMENT_HANDLE'))
				return GBL_SMTCKS_EDIT_COMMENT_HANDLE();
			else
				return GBL_NOTIFICATION('There was an error while trying to update the ticket/comment. Please try again later.', 'indianred', 'black', 10);
		}
	}
}

function GBL_SMTCKS_LAST_ENTRY()
{
	global $GBLCOM;
	$GBL_SEARCH = $GBLCOM['GBL_ADMIN_ADR_LINES'];
	unset($GBL_SEARCH[0]);
	if(empty($GBL_SEARCH))
		return 1;
	return max(array_column($GBL_SEARCH, 1))+1;
}

function GBL_SMTCKS_TKTLIST_INIT()
{
	if(isset($_POST['gbl_smtcks_delete_ticket']))
		return GBL_SMTCKS_DELETE_TICKET(GBL_SANITISE_TEXT_FIELD($_POST['gbl_smtcks_delete_ticket'])).GBL_SMTCKS_TICKET_LIST();
	
	if(isset($_GET['gbl_smtcks_tkt']))
	{
		$gbl_smtcks_tkt = GBL_SANITISE_TEXT_FIELD((int)$_GET['gbl_smtcks_tkt']);
		if(isset($_GET['gbl_smtcks_edit']))
			return GBL_SMTCKS_EDIT_COMMENT($gbl_smtcks_tkt, GBL_SANITISE_TEXT_FIELD((int)$_GET['gbl_smtcks_edit']));
		elseif(isset($_GET['gbl_smtcks_move']))
		{
			$content = ''; include(GBL_ADMIN_THEMES_DIR.'/blankpage.php');
			return $content;
		}
		elseif(isset($_POST['gbl_smtcks_delete_comment']))
			return GBL_SMTCKS_DELETE_COMMENT($gbl_smtcks_tkt, GBL_SANITISE_TEXT_FIELD($_POST['gbl_smtcks_delete_comment']));
		else
			return GBL_SMTCKS_VIEW_TICKET($gbl_smtcks_tkt);
	}
	else
		return GBL_SMTCKS_TICKET_LIST();
}

function GBL_SMTCKS_EDIT_COMMENT($ticket_id, $gbl_smtcks_comment)
{
	global $GBLCOM, $GBL_SMTCKS;
	
	$GBL_ADMIN_CONTROL_INSERTS = GBL_ADMIN_CONTROL_INSERTS("");
	if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id))
	{
		$gbl_smtcks_tkt_data = explode("\n", GBL_OPEN_FILE_CONTENTS(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id));
		foreach($gbl_smtcks_tkt_data as $gbl_smtcks_tkt_data1)
		{
			if(strlen($gbl_smtcks_tkt_data1) > 10)
			{
				$gbl_smtcks_tkt_data1 = explode(',', $gbl_smtcks_tkt_data1);
				
				if($gbl_smtcks_tkt_data1[1] == $gbl_smtcks_comment)
				{
					if($gbl_smtcks_comment == 1)
						$gbl_smtcks_editing = 'Editing Ticket ID: '.$ticket_id;
					else
						$gbl_smtcks_editing = 'Editing Comment ID: '.$gbl_smtcks_comment.' (Ticket ID: '.$ticket_id.')';
					
					$gbl_smtcks_tkt_data1[9] = str_replace('!£"*', ',', str_replace('_br_', "\n", $gbl_smtcks_tkt_data1[9]));
					$GBL_ADMIN_CONTROL_INSERTS_URL = $GBL_SMTCKS['A_HREF'];
					
					$tickets_control = '&gbl_smtcks_view='.$GBL_SMTCKS['tkl_view'].'&gbl_smtcks_sort='.$GBL_SMTCKS['tkl_sort'].'&gbl_smtcks_order='.$GBL_SMTCKS['tkl_order'];

					$gbl_smtcks_view_hidden = '<input value="'.$GBL_SMTCKS['tkl_view'].'" name="gbl_smtcks_view" type="hidden">';
					$gbl_smtcks_sort_hidden = '<input value="'.$GBL_SMTCKS['tkl_sort'].'" name="gbl_smtcks_sort" type="hidden">';
					$gbl_smtcks_order_hidden = '<input value="'.$GBL_SMTCKS['tkl_order'].'" name="gbl_smtcks_order" type="hidden">';
					
					return <<<data
<form method="post" action="?$GBL_ADMIN_CONTROL_INSERTS_URL&gbl_smtcks_tkt=$GBL_SMTCKS[ID]$tickets_control">
$GBL_ADMIN_CONTROL_INSERTS
$gbl_smtcks_view_hidden
$gbl_smtcks_sort_hidden
$gbl_smtcks_order_hidden
<div>
<table style="border: 0;" id="gbl_smtcks_center">
<tr>
<td>
<div id="gbl_smtcks_top_col">
<a href="?$GBL_ADMIN_CONTROL_INSERTS_URL$tickets_control" class="btn">Back to Ticket List</a>
</div>
<div id="gbl_smtcks_top_col">
<a href="?$GBL_ADMIN_CONTROL_INSERTS_URL&gbl_smtcks_tkt=$ticket_id$tickets_control" class="btn">Back to Ticket</a>
</div>
<div id="gbl_smtcks_top_col"></div>
</td>
</tr>
</table>
</div>
<div id="gbl_smtcks_ticket_list">
<table>
<thead>
<tr>
<th>
$gbl_smtcks_editing
</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="gbl_smtcks_edit" value="$gbl_smtcks_comment">
<textarea name="gbl_smtcks_comment_update" id="gbl_smtcks_max_width" rows="10">$gbl_smtcks_tkt_data1[9]</textarea>
</td>
</tr>
<tr>
<td>
<input type="submit" class="btn" name="gblact" value="Update">
</td>
</tr>
</tbody>
</table>
</div>
</form>
data;
				}
			}
		}
	}
	return GBL_SMTCKS_VIEW_TICKET($ticket_id).GBL_NOTIFICATION('An error has occured, please try again later.', 'indianred' , 'white', 5);
}

function GBL_SMTCKS_EDIT_COMMENT_HANDLE() {
	global $GBLCOM, $GBL_SMTCKS;
	$GBL_SMTCKS_TKI = GBL_SANITISE_TEXT_FIELD((int)$_GET['gbl_smtcks_tkt']);
	$GBL_SMTCKS_TKIE = GBL_SANITISE_TEXT_FIELD((int)$_POST['gbl_smtcks_edit']);
	$GBL_SMTCKS_COMDAT = GBL_SANITISE_TEXT_FIELD(str_replace("\n", '_br_', $_POST['gbl_smtcks_comment_update']));
	
	if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$GBL_SMTCKS_TKI))
	{
		GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$GBL_SMTCKS_TKI);
		$gbl_smtcks_tkd = $GBLCOM['GBL_ADMIN_ADR_LINES'];
		foreach($gbl_smtcks_tkd as $gbl_smtcks_tkd1id => $gbl_smtcks_tkd1)
		{
			if($gbl_smtcks_tkd1[1] == $GBL_SMTCKS_TKIE&$gbl_smtcks_tkd1[0] == 'COM')
			{
				$gbl_smtcks_tkd1[9] = stripslashes(str_replace(',', '!£"*', $GBL_SMTCKS_COMDAT));
				$gbl_smtcks_tkd1[4] = $GBLCOM['GBL_ADMIN_USER'];
				$gbl_smtcks_tkd[$gbl_smtcks_tkd1id] = $gbl_smtcks_tkd1;
				$GBLCOM['GBL_ADMIN_ADR_LINES'] = $gbl_smtcks_tkd;
				
				if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
					GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets', $GBL_SMTCKS_TKI);
				
				GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$GBL_SMTCKS_TKI);
				return GBL_NOTIFICATION('Your ticket/comment has been successfully updated.', 'green', 'white', 5);
			}
		}
	}
	return GBL_NOTIFICATION('There was an error while trying to update the ticket/comment. Please try again later.', 'indianred', 'black', 10);
}

function GBL_SMTCKS_DELETE_TICKET($gbl_smtcks_ticket_id, $gbl_smtcks_dcom = false) {
	global $GBLCOM, $GBL_SMTCKS;
	$gbl_smtcks_filetime = strtotime(date('M Y'));
	
	if(!$gbl_smtcks_dcom)
	{
		if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_ticket_id))
		{
			if(GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_ticket_id))
			{
				$gbl_smtcks_filetime = strtotime(date('M Y', $GBLCOM['GBL_ADMIN_ADR_LINES'][1][2]));
				unlink(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_ticket_id);
			}
		}
	}
	if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$gbl_smtcks_filetime.'.tkl'))
	{
		GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$gbl_smtcks_filetime.'.tkl');
		foreach($GBLCOM['GBL_ADMIN_ADR_LINES'] as $gbl_smtcks_tkl1id => $gbl_smtcks_tkl1)
		{
			if($gbl_smtcks_tkl1id == '0')
				continue;
			if($gbl_smtcks_tkl1[1] == $gbl_smtcks_ticket_id)
			{
				unset($GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_tkl1id]);
				
				if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
					GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'], $gbl_smtcks_filetime.'.tkl');
				
				GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$gbl_smtcks_filetime.'.tkl');
				return GBL_NOTIFICATION('Specified ticket has been deleted.', 'green', 'white', 5);
			}
		}
	}
	return GBL_NOTIFICATION('There was an error while attempting to delete a ticket. Please try again later.', 'indianred', 'black', 10);
}

function GBL_SMTCKS_DELETE_COMMENT($gbl_smtcks_tkt, $gbl_smtcks_comment) {
	global $GBLCOM, $GBL_SMTCKS;
	if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_tkt)) {
		if(GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_tkt))
		{
			foreach($GBLCOM['GBL_ADMIN_ADR_LINES'] as $gbl_smtcks_tk1id => $gbl_smtcks_tkd1)
			{
				if($gbl_smtcks_tkd1[0] == 'COM'&$gbl_smtcks_tkd1[1] == $gbl_smtcks_comment)
				{
					unset($GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_tk1id]);
					
					if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
						GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets', $gbl_smtcks_tkt);
					
					GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_tkt);
					return GBL_SMTCKS_VIEW_TICKET($gbl_smtcks_tkt).GBL_NOTIFICATION('Specified comment has been deleted', 'green', 'white', 5);
				}
			}
		}
	}
	return GBL_SMTCKS_VIEW_TICKET($gbl_smtcks_tkt).GBL_NOTIFICATION('There was an error while attempting to delete a comment. Please try again later.', 'indianred', 'black', 10);
}

function GBL_SMTCKS_TICKET_LIST() {
	global $GBLCOM, $GBL_SMTCKS;
	$gbl_smtcks_tickets = array(array(''), array(''), array(''));
	$GBL_SMTCKS_COLOUR = '';
	$GBL_SMTCKS_STYLE = '';
	$gbl_smtcks_whatfields_colors = array();
	$gbl_smtcks_tkl = scandir(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID']);
	$gbl_smtcks_tkl_headers = '';
	$gbl_smtcks_status_id = 0;
	$gbl_smtcks_2nd_header = '';
	$GBL_SMTCKS_COLOUR_D = '';
	$count_tickets = 0;
	
	$gbl_smtcks_display_no_ticks = null;
	$gbl_smtcks_tickets_sticky = null;
	$gbl_smtcks_ticket_data = null;
	$gbl_smtcks_control = null;
	$gbl_smtcks_display = array();
	
	foreach($GBL_SMTCKS['SETTINGS'] as $gbl_smtcks_tklL2)
	{
		if(strlen($gbl_smtcks_tklL2) > 20)
		{
			$gbl_smtcks_tklL2 = explode(',', $gbl_smtcks_tklL2, 22);
			if(count($gbl_smtcks_tklL2) > 21)
			{
				if($gbl_smtcks_tklL2[4]&$gbl_smtcks_tklL2[7]&$gbl_smtcks_tklL2[0] == 'TKS')
				{
					$gbl_smtcks_tkl_headers .= '<th>'.ucfirst(str_replace('_', ' ', $gbl_smtcks_tklL2[3])).'</th>';
					$gbl_smtcks_whatfields_arr[] = $gbl_smtcks_tklL2[1];
					if(isset($gbl_smtcks_tklL2[9])&$gbl_smtcks_tklL2[3] == 'Status'&$gbl_smtcks_tklL2[2] == 'select'&strlen($gbl_smtcks_tklL2[21]) > 3)
					{
						
						if(($gbl_smtcks_tklL2[9] == serialize(false) || @unserialize($gbl_smtcks_tklL2[9]) !== false))
							$gbl_smtcks_whatfields_colors = unserialize($gbl_smtcks_tklL2[9]);
						
						$gbl_smtcks_status_id = $gbl_smtcks_tklL2[1];
						$GBL_SMTCKS['tkl_views'] = explode(',', $gbl_smtcks_status_id.','.substr($gbl_smtcks_tklL2[21], 0, -1));
						
						$gbl_smtcks_tickets = array_fill_keys(range(0, count($GBL_SMTCKS['tkl_views'])), array(''));
						
						if(is_array($gbl_smtcks_whatfields_colors))
						{
							foreach($gbl_smtcks_whatfields_colors as $GBL_SMTCKS_WHAT_FIELDS_ID => $GBL_SMTCKS_WHAT_FIELDS)
							{
								$GBL_SMTCKS_COLOUR_D = GBL_SMTCKS_HEX_TO_RGB($GBL_SMTCKS_WHAT_FIELDS);
								if(is_array($GBL_SMTCKS_COLOUR_D))
								{
									$GBL_SMTCKS_STYLE .= '
table tbody tr#GBL_SMTCKS_'.$GBL_SMTCKS_WHAT_FIELDS_ID.' td {
	background: rgb('.implode(', ', $GBL_SMTCKS_COLOUR_D[0]).');
	
}
table tbody tr#GBL_SMTCKS_'.$GBL_SMTCKS_WHAT_FIELDS_ID.':hover td {
	background: rgb('.implode(', ', $GBL_SMTCKS_COLOUR_D[1]).');
	
}';
								} elseif($GBL_SMTCKS_COLOUR_D != 'inherit')
								{
									$GBL_SMTCKS_STYLE .= '
table tbody tr#GBL_SMTCKS_'.$GBL_SMTCKS_WHAT_FIELDS_ID.' td {
	background: '.$GBL_SMTCKS_COLOUR_D.';
	
}';
								}
							}
						}
					}
				}
			}
		}
	}
	
	$gbl_smtcks_control = GBL_SMTCKS_LIST_OPTIONS();
	$tkl_views_flipped = array_flip($GBL_SMTCKS['tkl_views']);
	
	foreach($gbl_smtcks_tkl as $gbl_smtcks_tklL0)
	{
		if(substr($gbl_smtcks_tklL0, -4) == '.tkl')
		{
			$gbl_smtcks_tklL0 = GBL_SMTCKS_VALIDATE_TKL(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$gbl_smtcks_tklL0);
			
			if($gbl_smtcks_tklL0 != null)
			{
			foreach($gbl_smtcks_tklL0 as $gbl_smtcks_tklL0_id => $gbl_smtcks_tklL1)
			{
				$gbl_smtcks_ticket_data = null;
				$gbl_smtcks_tklL1 = explode(',', $gbl_smtcks_tklL1);
				if(count($gbl_smtcks_tklL1) > 19)
				{
					if($gbl_smtcks_tklL1[0] != 'TKL')
						continue;
					
					$count_tickets++;
					$GBL_SMTCKS_TKT_LINK = $GBL_SMTCKS['A_HREF'].'&gbl_smtcks_tkt='.$gbl_smtcks_tklL1[1].'&gbl_smtcks_view='.$GBL_SMTCKS['tkl_view'].'&gbl_smtcks_sort='.$GBL_SMTCKS['tkl_sort'].'&gbl_smtcks_order='.$GBL_SMTCKS['tkl_order'];
					$gbl_smtcks_details = '';
					unset($gbl_smtcks_tklL1[0]);
					$GBL_SMTCKS_COLOUR = 'GBL_SMTCKS_'.$gbl_smtcks_tklL1[$gbl_smtcks_status_id+19];
					
					if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_tklL1[1]))
						$filemtime_ticket = filemtime(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_tklL1[1]);
					else
						$filemtime_ticket = null;
					
					foreach($gbl_smtcks_whatfields_arr as $gbl_smtcks_tklL2)
					{
						if(isset($gbl_smtcks_tklL1[$gbl_smtcks_tklL2+19]))
						{
							if($gbl_smtcks_tklL1[$gbl_smtcks_tklL2+19] == '')
								$gbl_smtcks_additional = 'Empty';
							else
								$gbl_smtcks_additional = $gbl_smtcks_tklL1[$gbl_smtcks_tklL2+19];
						}
						$gbl_smtcks_details .= <<<data
<td>
<a id="gbl_smtcks_tickets" href="$GBL_SMTCKS_TKT_LINK">
<div id="gbl_smtcks_max_width">$gbl_smtcks_additional</div>
</a>
</td>
data;
					}
					
					if($gbl_smtcks_tklL1[2] == '')
						$gbl_smtcks_tklL1[2] = 'Guest';
					
					$gbl_smtcks_tklL1[3] = GBL_SMTCKS_TIMEELAPSED($filemtime_ticket) . date(" (D, d M h:i A)", $filemtime_ticket);
					
					if($gbl_smtcks_tklL1[5] == '1')
						$GBL_SMTCKS_COLOUR = 'gbl_smtcks_sticky_ticket';
					
					$gbl_smtcks_ticket_data = <<<data
<tr id="$GBL_SMTCKS_COLOUR">
<td>
<a id="gbl_smtcks_tickets" href="$GBL_SMTCKS_TKT_LINK">
<div id="gbl_smtcks_max_width">$gbl_smtcks_tklL1[1]</div>
</a>
</td>
<td>
<a id="gbl_smtcks_tickets" href="$GBL_SMTCKS_TKT_LINK">
<div id="gbl_smtcks_max_width">$gbl_smtcks_tklL1[2]</div>
</a>
</td>
<td>
<a id="gbl_smtcks_tickets" href="$GBL_SMTCKS_TKT_LINK">
<div id="gbl_smtcks_max_width">$gbl_smtcks_tklL1[3]</div>
</a>
</td>
$gbl_smtcks_details
<td style="width: 40px; padding: 0 5px 0 5px;">
<button id="gbl_smtcks_delete_btn" name="gbl_smtcks_delete_ticket" value="$gbl_smtcks_tklL1[1]">
X
</button>
</td>
</tr>
data;
					
					if($gbl_smtcks_tklL1[5] == '1')
						$gbl_smtcks_tickets_sticky .= $gbl_smtcks_ticket_data;
					else
					{
						$gbl_search_tkl_views = GBL_SANITISE_TEXT_ONLY($gbl_smtcks_tklL1[19+$GBL_SMTCKS['tkl_views'][0]]);
						
						if($GBL_SMTCKS['tkl_sort'] == 'datemodified')
						{
							if(isset($gbl_smtcks_tickets[$gbl_search_tkl_views][$filemtime_ticket]))
								$gbl_smtcks_tickets[$gbl_search_tkl_views][$filemtime_ticket] .= $gbl_smtcks_ticket_data;
							else
								$gbl_smtcks_tickets[$gbl_search_tkl_views][$filemtime_ticket] = $gbl_smtcks_ticket_data;
						}
						else
						{
							if(isset($gbl_smtcks_tickets[$gbl_search_tkl_views][$gbl_smtcks_tklL1[1]]))
								$gbl_smtcks_tickets[$gbl_search_tkl_views][$gbl_smtcks_tklL1[1]] .= $gbl_smtcks_ticket_data;
							else
								$gbl_smtcks_tickets[$gbl_search_tkl_views][$gbl_smtcks_tklL1[1]] = $gbl_smtcks_ticket_data;
						}
					}
				}
			}
			}
		}
	}
	
	if($count_tickets >= 10)
	{
		$gbl_smtcks_2nd_header = '<thead>
<tr id="gbl_smtcks_pointer">
<th>Ticket</th>
<th>User</th>
<th>Last Modified</th>
'.$gbl_smtcks_tkl_headers.'
<th>Options</th>
</tr>
</thead>';
	}
	
	if($GBL_SMTCKS['tkl_view'] != '0'&$GBL_SMTCKS['tkl_view'] != 'all'&isset($gbl_smtcks_tickets[$GBL_SMTCKS['tkl_view']]))
		$gbl_smtcks_display = $gbl_smtcks_tickets[$GBL_SMTCKS['tkl_view']];
	else
	{
		if($GBL_SMTCKS['tkl_view'] != '0'&$GBL_SMTCKS['tkl_view'] != 'all')
		{
			$gbl_smtcks_display_no_ticks = <<<data
<table>
<tr id="gbl_smtcks_sticky_ticket">
<td>
No '$GBL_SMTCKS[tkl_view]' Tickets to display.
</td>
</tr>
</table>
data;
		}
		else
		{
			foreach($gbl_smtcks_tickets as $gbl_smtcks_ticket_arr)
			{
				foreach($gbl_smtcks_ticket_arr as $gbl_smtcks_ticket_arr2_id => $gbl_smtcks_ticket_arr2)
				{
					if(isset($gbl_smtcks_display[$gbl_smtcks_ticket_arr2_id]))
						$gbl_smtcks_display[$gbl_smtcks_ticket_arr2_id] .= $gbl_smtcks_ticket_arr2;
					else
						$gbl_smtcks_display[$gbl_smtcks_ticket_arr2_id] = $gbl_smtcks_ticket_arr2;
				}
			}
		}
	}
	
	if($GBL_SMTCKS['tkl_order'] == 'descending')
		ksort($gbl_smtcks_display);
	else
		krsort($gbl_smtcks_display);
	
	$gbl_smtcks_display = $gbl_smtcks_tickets_sticky.implode('', $gbl_smtcks_display);
	
	$gbl_smtcks_ticket_list = <<<data
<div id="gbl_smtcks_ticket_list">
<table>
<thead>
<tr id="gbl_smtcks_pointer">
<th>Ticket</th>
<th>User</th>
<th>Last Modified</th>
$gbl_smtcks_tkl_headers
<th>Options</th>
</tr>
</thead>
<tbody>
$gbl_smtcks_display
</tbody>
$gbl_smtcks_2nd_header
</table>
$gbl_smtcks_display_no_ticks
</div>
<script>
jQuery(document).ready(function($) {
	function sortTable(f,n){
		var rows = $('#gbl_smtcks_ticket_list table tbody tr').get();
		rows.sort(function(a, b) {
			var A = getVal(a);
			var B = getVal(b);
			if(A < B) {return -1*f;}
			if(A > B) {return 1*f;}
			return 0;
		});
		function getVal(elm){
			var v = $(elm).children('td').eq(n).text().toUpperCase();
			if($.isNumeric(v)){v = parseInt(v,10);}
			return v;
		}
		$.each(rows, function(index, row) {\$('#gbl_smtcks_ticket_list table').children('tbody').append(row);});
	}
	var f_sl = 1;
	$("#gbl_smtcks_ticket_list table thead th").click(function(){
		f_sl *= -1;
		var n = $(this).prevAll().length;
		sortTable(f_sl,n);
	});
});
</script>
data;
	return '<style>'.$GBL_SMTCKS_STYLE.'</style>'.$gbl_smtcks_control.'<form method="post" action="">'.$gbl_smtcks_ticket_list.'</form>';
}

function GBL_SMTCKS_VIEW_TICKET($ticket_id) {
	global $GBLCOM, $GBL_SMTCKS;
	$GBL_ADMIN_CONTROL_INSERTS = GBL_ADMIN_CONTROL_INSERTS("");
	$gbl_smtcks_primary = '';
	$gbl_smtcks_comments = array();
	$gbl_smtcks_per_box = 0;
	$gbl_smtcks_next = array('', $ticket_id, 0);
	$gbl_smtcks_prev = array('', $ticket_id);
	$ACCORD[0] = "ACCORDION"; // for 5 part accordion
	$i = 0;
	$once = true;
	$incremented = 1;
	$update = false;
	
	$gbl_smtcksstatick_sticky_options = '<option value="1">Yes</option><option selected value="0">No</option>';
	
	if(!file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id)) {
		$GBLCOM['GBL_ADMIN_ADR_LINES'] = array(
			0 => GBL_ADMIN_CREATE_ADR('HEAD', '', 2),
			1 => GBL_ADMIN_CREATE_ADR('COM', '', 2)
		);
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][1] = 'ID';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][2] = 'Date Created';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][3] = 'Who By';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][4] = 'Edited';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][0][9] = 'Details';
		
		$GBLCOM['GBL_ADMIN_ADR_LINES'][1][1] = '1';
		$GBLCOM['GBL_ADMIN_ADR_LINES'][1][2] = time();
		$GBLCOM['GBL_ADMIN_ADR_LINES'][1][3] = $GBLCOM['GBL_ADMIN_USER'];
		$GBLCOM['GBL_ADMIN_ADR_LINES'][1][9] = 'Ticket details (this ticket had an error while creating/modifying or deleting it).';
		
		if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
			GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets', $ticket_id);
		
		GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id);
		
	}
	else
		GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id);
	
	foreach($GBLCOM['GBL_ADMIN_ADR_LINES'] as $gbl_smtcks_detailsL1_id => $gbl_smtcks_detailsL1)
	{
		//	Temporary; delete in future
		while(isset($GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_detailsL1_id+$incremented]))
		{
			if($GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_detailsL1_id+$incremented][0] == 'COM'|$GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_detailsL1_id+$incremented][0] == 'HEAD')
				break;
		
			$gbl_smtcks_detailsL1[9] .= '_br_'.$GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_detailsL1_id+$incremented][0];
			$GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_detailsL1_id][9] = $gbl_smtcks_detailsL1[9];
			unset($GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_detailsL1_id+$incremented][0]);
			$incremented++;
			$update = true;
		}
		//	END
		
		if($gbl_smtcks_detailsL1[0] == 'COM')
		{
			$GBL_SMTCKS_MAINHREF = $GBL_SMTCKS['A_HREF'].'&gbl_smtcks_tkt='.$GBL_SMTCKS['ID'];
			if($gbl_smtcks_detailsL1[3] == '') {$gbl_smtcks_detailsL1[3] = 'Guest';} else {$gbl_smtcks_detailsL1[3] = GBL_SANITISE_TEXT_FIELD($gbl_smtcks_detailsL1[3]);}
			$gbl_smtcks_detailsL1[9] = str_replace('_br_', '<br />', GBL_SANITISE_TEXT_FIELD(str_replace('!£"*', ',', $gbl_smtcks_detailsL1[9])));
			if($gbl_smtcks_detailsL1[4] != '') {
				$gbl_smtcks_ifedited = '<br /><div id="gbl_smtcks_edited">Edited by <b>'.$gbl_smtcks_detailsL1[4].'</b></div>';} else {$gbl_smtcks_ifedited = '';}
			if($gbl_smtcks_detailsL1[1] == 1)
			{
				if($once)
				{
					$gbl_smtcks_timeticketcreated = strtotime(date('M Y', $gbl_smtcks_detailsL1[2]));
					$gbl_smtcks_detailsL1[2] = GBL_SMTCKS_TIMEELAPSED((int)$gbl_smtcks_detailsL1[2]) . date(" (D, d M h:i A)", (int)$gbl_smtcks_detailsL1[2]);
					$once = false;
				}
				$gbl_smtcks_primary = <<<data
<div id="gbl_smtcks_primary">
<table>
<thead>
<tr>
<th>
<span style="float: left;">
Ticket Details (Ticket: $ticket_id)
</span>
<div id="gbl_smtcks_setting_right">
<a id="gbl_smtcks_btn" style="line-height: inherit;" href="$GBL_SMTCKS_MAINHREF&gbl_smtcks_edit=$gbl_smtcks_detailsL1[1]" id="gbl_smtcks_btn">Edit Ticket</a> | 
<a id="gbl_smtcks_btn" style="line-height: inherit;" href="$GBL_SMTCKS_MAINHREF&gbl_smtcks_move=$gbl_smtcks_detailsL1[1]" id="gbl_smtcks_btn">Move Ticket</a> | 
<button id="gbl_smtcks_btn" name="gbl_smtcks_delete_ticket" value="$ticket_id">
Delete Ticket
</button>
</div>
</th>
</tr>
</thead>
<tbody>
<tr>
<td style="text-align: left; padding: 0 10px 0 10px;">
#$gbl_smtcks_detailsL1[1] | $gbl_smtcks_detailsL1[2] by <b>$gbl_smtcks_detailsL1[3]</b>
<br />
$gbl_smtcks_detailsL1[9]
$gbl_smtcks_ifedited
</td>
</tr>
</tbody>
</table>
</div>
data;
			} else {
				$gbl_smtcks_detailsL1[2] = GBL_SMTCKS_TIMEELAPSED($gbl_smtcks_detailsL1[2]) . date(" (D, d M h:i A)", $gbl_smtcks_detailsL1[2]);
				if($gbl_smtcks_detailsL1[3] == $GBLCOM['GBL_ADMIN_USER']) {
					$gbl_smtcks_whodid = 'background: #EFFFFF;';
				} else {
					$gbl_smtcks_whodid = 'background: #F6F6F6;';
				}
				
				$i++;
				$ACCORD[$i] = "checked";
				$gbl_smtcks_comments['<span style="float: left;">#'.$gbl_smtcks_detailsL1[1].' | '.$gbl_smtcks_detailsL1[2].' by <b>'.$gbl_smtcks_detailsL1[3].'</b></span><div id="gbl_smtcks_setting_right"><a id="gbl_smtcks_btn" href="'.$GBL_SMTCKS_MAINHREF.'&gbl_smtcks_edit='.$gbl_smtcks_detailsL1[1].'" id="gbl_smtcks_btn">Edit Comment</a> | <a id="gbl_smtcks_btn" href="'.$GBL_SMTCKS_MAINHREF.'&gbl_smtcks_move='.$gbl_smtcks_detailsL1[1].'" id="gbl_smtcks_btn">Move Comment</a> | <button id="gbl_smtcks_btn" name="gbl_smtcks_delete_comment" value="'.$gbl_smtcks_detailsL1[1].'">Delete Comment</button></div>'] = <<<data
<div id="gbl_smtcks_primary" style="margin: 5px auto; width: calc(100% - 10px)">
<table>
<tbody>
<tr>
<td style="text-align: left; padding: 0 10px 0 10px; $gbl_smtcks_whodid">
$gbl_smtcks_detailsL1[9]
$gbl_smtcks_ifedited
</td>
</tr>
</tbody>
</table>
</div>
data;
			}
		}
	}
	
	if($update)
	{
		if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
			GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets', $ticket_id);
		
		GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id);
	}
	
	$GBLCOM['GBL_ADMIN_ACCORDION_SMTCKS_COMMENTS'] = implode(",",$ACCORD);
	$gbl_smtcks_secondary_fields = '<div id="gbl_smtcks_divs">';
	$the_tklist = scandir(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID']);
	
	foreach($the_tklist as $the_tklist_each)
	{
		if(substr($the_tklist_each, -4) != '.tkl')
			continue;
		
		$gbl_smtcks_tkl = explode("\n", GBL_OPEN_FILE_CONTENTS(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$the_tklist_each));
		
		foreach($gbl_smtcks_tkl as $gbl_smtcks_tkl_L0) {
			if(strlen($gbl_smtcks_tkl_L0) > 50) {
				$gbl_smtcks_tkl_L0 = explode(',', $gbl_smtcks_tkl_L0);
				if($gbl_smtcks_next[2] < $gbl_smtcks_tkl_L0[1])
					$gbl_smtcks_next[2] = $gbl_smtcks_tkl_L0[1];
				
				if($gbl_smtcks_tkl_L0[1] == $ticket_id)
				{
					if($gbl_smtcks_tkl_L0[5] == '1')
						$gbl_smtcksstatick_sticky_options = '<option selected value="1">Yes</option><option value="0">No</option>';
					
					$gbl_settings_L1_KEYS = array_keys($GBL_SMTCKS['SETTINGS']);
					$gbl_settings_L1_KEYS_LAST = array_pop($gbl_settings_L1_KEYS);
					
					foreach($GBL_SMTCKS['SETTINGS'] as $gbl_settings_L1_ID => $gbl_settings_L1)
					{
						if(strlen($gbl_settings_L1) > 50) {
							$gbl_settings_L1 = explode(',', $gbl_settings_L1, 22);
							if($gbl_settings_L1[0] == 'TKS'&$gbl_settings_L1[4]) {
									if($gbl_settings_L1[2] == 'select') {
										$gbl_smtcks_value = explode(',', $gbl_settings_L1[21], -1);
										if(isset($gbl_smtcks_tkl_L0[$gbl_settings_L1[1]+19])) {
											$gbl_smtcks_whatsselected = GBL_SANITISE_TEXT_FIELD($gbl_smtcks_tkl_L0[$gbl_settings_L1[1]+19]);}
									} else {
										//if($gbl_settings_L1[2] == 'email') {
											//$gbl_smtcks_value = GBL_SANITISE_EMAIL($gbl_smtcks_tkl_L0[$gbl_settings_L1[1]+19]);} else {
											$gbl_smtcks_value = GBL_SANITISE_TEXT_FIELD($gbl_smtcks_tkl_L0[$gbl_settings_L1[1]+19]);//}
										$gbl_smtcks_whatsselected = null;
									}
								if($gbl_settings_L1[5]) {
									$gbl_smtcks_starred = '<a style="color: red;">*</a>';} else {
									$gbl_smtcks_starred = '';}
								
								$gbl_smtcks_per_box++;
								if($gbl_smtcks_per_box > 2) {
									$gbl_smtcks_per_box = 1;
									$gbl_smtcks_secondary_fields .= '</div><div id="gbl_smtcks_divs">';
								}
								
								$gbl_smtcks_secondary_fields .= '
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">
'.ucfirst(str_replace('_', ' ', htmlentities($gbl_settings_L1[3]))).$gbl_smtcks_starred.'
</span>
<span id="gbl_smtcks_setting_right">
'.GBL_CREATE_HTML($gbl_settings_L1[2], 'gbl_smtcks_'.$gbl_settings_L1[1], $gbl_smtcks_value, 'placeholder="'.$gbl_settings_L1[8].'"', $gbl_smtcks_whatsselected).'
</span>
</div>';
							}
						}
						
						if($gbl_settings_L1_KEYS_LAST == $gbl_settings_L1_ID) {
							$gbl_smtcks_secondary_fields .= '</div>';
						}
					}
					break;
				}
			}
		}
	}
		
	$gbl_smtcks_secondary_fields .= '<center>'.GBL_CREATE_HTML('submit', 'gblact', 'Update Settings', 'class="btn"').'</center>';
	
	$gbl_smtcks_secondary = <<<data
<div id="gbl_smtcks_secondary">
<table>
<thead>
<tr>
<th>
Settings
</th>
</tr>
</thead>
<tbody>
<tr><td>
<div id="gbl_smtcks_divs">
<div id="gbl_smtcks_setting">
<span id="gbl_smtcks_setting_left">
Sticky Ticket?
</span>
<span id="gbl_smtcks_setting_right">

<select name="gbl_smtckstatic_sticky">
$gbl_smtcksstatick_sticky_options
</select>

</span>
</div>
</div>


$gbl_smtcks_secondary_fields
</td></tr>
</tbody>
</table>
</div>
data;
	
	$tickets_control = '&gbl_smtcks_view='.$GBL_SMTCKS['tkl_view'].'&gbl_smtcks_sort='.$GBL_SMTCKS['tkl_sort'].'&gbl_smtcks_order='.$GBL_SMTCKS['tkl_order'];
	
	while($gbl_smtcks_next[0] == ''&$gbl_smtcks_next[1] <= $gbl_smtcks_next[2]) {
		$gbl_smtcks_next[1]++;
		if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_next[1])) {
			$gbl_smtcks_next[0] = '<a href="'.$GBL_SMTCKS['A_HREF'].'&gbl_smtcks_tkt='.$gbl_smtcks_next[1].$tickets_control.'" class="btn">Next Ticket</a>';
			break;
		}
	}
	
	while($gbl_smtcks_prev[0] == ''&$gbl_smtcks_prev[1] > 0) {
		$gbl_smtcks_prev[1]--;
		if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$gbl_smtcks_prev[1])) {
			$gbl_smtcks_prev[0] = '<a href="'.$GBL_SMTCKS['A_HREF'].'&gbl_smtcks_tkt='.$gbl_smtcks_prev[1].$tickets_control.'" class="btn">Previous Ticket</a>';
			break;
		}
	}
	$GBL_ADMIN_CONTROL_INSERTS_URL = $GBL_SMTCKS['A_HREF'];
	
	$gbl_smtcks_toppanel = <<<data
<div><table style="border: 0;" id="gbl_smtcks_center">
<tr><td><div id="gbl_smtcks_top_col">
<a href="?$GBL_ADMIN_CONTROL_INSERTS_URL$tickets_control" class="btn">Back to Ticket List</a>
</div><div id="gbl_smtcks_top_col">
$gbl_smtcks_prev[0]
</div><div id="gbl_smtcks_top_col">
$gbl_smtcks_next[0]
</div></td></tr></table></div>
data;
	if(count($gbl_smtcks_comments) >= 1) {
		$gbl_smtcks_comments = GBL_ADMIN_WRAP_ACCORDION($gbl_smtcks_comments,'GBL_ADMIN_ACCORDION_SMTCKS_COMMENTS').'</div>';
	} else {$gbl_smtcks_comments = '';}
	
	return $gbl_smtcks_toppanel.'<div id="gbl_smtcks_center"><form method="post" action=""><div id="gbl_smtcks_admin">'.$gbl_smtcks_secondary.'</div><div id="gbl_smtcks_admin_main">'.$gbl_smtcks_primary.'</div><div style="width: calc(100% - 14px); margin: 5px;">'.$gbl_smtcks_comments.'<div id="gbl_smtcks_settings"><textarea name="gbl_smtcks_new_comment" style="text-align: left;" id="gbl_smtcks_max_width" rows="10" placeholder="Your new comment here"></textarea><br /><input class="btn" type="submit" name="gblact" value="Create Comment"></div></div>'.$GBL_ADMIN_CONTROL_INSERTS.'</form></div>';
	
	return GBL_NOTIFICATION('This ticket does not exist.', 'orange', 'black', 5).GBL_SMTCKS_TICKET_LIST();
}

function GBL_SMTCKS_UPDATE_SETTINGS() {
	global $GBLCOM, $GBL_SMTCKS;
	$GBLCOM['GBL_ADMIN_ADR_LINES'] = array();
	$GBL_SMTCKS_ARRAY = null;
	
	if(isset($_GET['gbl_smtcks_tkt']))
	{
		$ticket_id = GBL_SANITISE_TEXT_FIELD((int)$_GET['gbl_smtcks_tkt']);
		if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id))
		{
			GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id);
			$the_tklist = scandir(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID']);
			
			foreach($the_tklist as $the_tklist_each)
			{
				if(substr($the_tklist_each, -4) != '.tkl')
					continue;
				
				GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$the_tklist_each);
				foreach($GBLCOM['GBL_ADMIN_ADR_LINES'] as $gbl_smtcks_tkl_L0_ID => $gbl_smtcks_tkl_L0)
				{
					if($gbl_smtcks_tkl_L0[1] == $ticket_id)
					{
						foreach($GBL_SMTCKS['SETTINGS'] as $GBL_SMTCKS_TKL_SETTINGS)
						{
							$GBL_SMTCKS_TKL_SETTINGS = explode(',', $GBL_SMTCKS_TKL_SETTINGS);
							if(!isset($GBL_SMTCKS_TKL_SETTINGS[1]))
								continue;
							
							if(isset($_POST['gbl_smtcks_'.$GBL_SMTCKS_TKL_SETTINGS[1]]))
							{
								//if($GBL_SMTCKS_TKL_SETTINGS[2] == 'email')
								//	$GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_tkl_L0_ID][$GBL_SMTCKS_TKL_SETTINGS[1]+19] = GBL_SANITISE_EMAIL(str_replace(',', '', $_POST['gbl_smtcks_'.$GBL_SMTCKS_TKL_SETTINGS[1]]));
								//else
									$GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_tkl_L0_ID][$GBL_SMTCKS_TKL_SETTINGS[1]+19] = GBL_SANITISE_TEXT_FIELD(str_replace(',', '', $_POST['gbl_smtcks_'.$GBL_SMTCKS_TKL_SETTINGS[1]]));
							}
						}
						
						if(isset($_POST['gbl_smtckstatic_sticky']))
							$GBLCOM['GBL_ADMIN_ADR_LINES'][$gbl_smtcks_tkl_L0_ID][5] = GBL_SANITISE_NUMBER_ONLY($_POST['gbl_smtckstatic_sticky']);
						
						if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
							GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'], $the_tklist_each);
						
						GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$the_tklist_each);
						
						touch(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id);
						
						// E-mail
						$GBL_SMTCKS_ARRAY = explode(',', $GBLCOM['GBL_SMTCKS_EMAILS']);
						if($GBL_SMTCKS_ARRAY[1] == 1) {
							if(GBL_ADMIN_MYNAME == 'GlobelWP') {$GBL_WHOTO = get_option('admin_email');} else {
								if(isset($_SERVER['SERVER_ADMIN']))
									$GBL_WHOTO = $_SERVER['SERVER_ADMIN'];
								else
									$GBL_WHOTO = 'noreply@'.GBL_ADMIN_BASEURI_PLAIN;
							}
							GBL_ADMIN_SENDMAIL('noreply@'.$_SERVER['SERVER_NAME'], $GBL_WHOTO, 'Simple Tickets [Ticket Update]', $GBLCOM['GBL_ADMIN_USER'].' just changed ticket settings in ticket: '.$ticket_id.' at '.date('H:i:s A, d M Y').'.');
						}
						return GBL_NOTIFICATION('Settings updated.', 'green', 'white', 5);
					}
				}
			}
		}
	}
	return GBL_NOTIFICATION('There was an error saving this ticket settings. Please try again later.', 'indianred', 'black', 10);
}

function GBL_SMTCKS_CREATE_COMMENT() {
	global $GBLCOM, $GBL_SMTCKS;
	$GBLCOM['GBL_ADMIN_ADR_LINES'] = array();
	$GBL_SMTCKS_TEMP_ADR = array();
	$GBL_SMTCKS_ARRAY = array();
	if(isset($_POST['gbl_smtcks_new_comment'])) {
		$gbl_smtcks_comment = GBL_SANITISE_TEXT_FIELD(str_replace("\n", '_br_', $_POST['gbl_smtcks_new_comment']));
		if(strlen($gbl_smtcks_comment) > $GBLCOM['GBL_SMTCKS_COMMENT_MIN']) {
			$ticket_id = GBL_SANITISE_TEXT_FIELD((int)$_GET['gbl_smtcks_tkt']);
			if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id)) {
				GBL_ADMIN_FETCH_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id);
				$comment_id = GBL_SMTCKS_LAST_ENTRY();
				
				$GBL_SMTCKS_TEMP_ADR = GBL_ADMIN_CREATE_ADR('COM', '');
				$GBL_SMTCKS_TEMP_ADR[1] = $comment_id;
				$GBL_SMTCKS_TEMP_ADR[2] = time();
				$GBL_SMTCKS_TEMP_ADR[3] = $GBLCOM['GBL_ADMIN_USER'];
				$GBL_SMTCKS_TEMP_ADR[9] = str_replace(',', '!£"*', $gbl_smtcks_comment);
				
				$GBLCOM['GBL_ADMIN_ADR_LINES'][] = $GBL_SMTCKS_TEMP_ADR;
				
				if($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes")
					GBL_BACKUP(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets', $ticket_id);
				
				GBL_ADMIN_SAVE_ADR(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_id);
				
				// E-mail
				$GBL_SMTCKS_ARRAY = explode(',', $GBLCOM['GBL_SMTCKS_EMAILS']);
				if($GBL_SMTCKS_ARRAY[1] == 1)
				{
					if(GBL_ADMIN_MYNAME == 'GlobelWP')
					{
						$GBL_WHOTO = get_option('admin_email');
					}
					else
					{
						if(isset($_SERVER['SERVER_ADMIN']))
							$GBL_WHOTO = $_SERVER['SERVER_ADMIN'];
						else
							$GBL_WHOTO = 'noreply@'.GBL_ADMIN_BASEURI_PLAIN;
					}
					GBL_ADMIN_SENDMAIL('noreply@'.$_SERVER['SERVER_NAME'], $GBL_WHOTO, 'Simple Tickets [New Comment]', 'A new comment has been created by '.$GBLCOM['GBL_ADMIN_USER'].' at '.date('H:i:s A, d M Y').".\nTicket ID: ".$ticket_id."\nComment ID: ".$comment_id);
				}
				return GBL_NOTIFICATION('Your comment has been created.', 'green', 'white', 5);
			}} else {
			return GBL_NOTIFICATION('Your comment has to consist of at least '.$GBLCOM['GBL_SMTCKS_COMMENT_MIN'].' characters.', 'indianred', 'black', 5);}
	}
	return GBL_NOTIFICATION('There was an error while trying to create new comment. Please try again later.', 'indianred', 'black', 10);
}



?>