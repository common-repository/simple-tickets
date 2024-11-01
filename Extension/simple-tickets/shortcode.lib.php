<?php
if(GBL_ADMIN_MYNAME == "GlobelWP") 
{
	add_shortcode('GBL_SMTCKS', 'GBL_SMTCKS_NEW');
	add_shortcode('GBL_SMTCKS_LIST', 'GBL_SMTCKS_LIST');
}

function GBL_SMTCKS_NEW($shortcode)
{
	global $GBLCOM, $GBL_SMTCKS;
	
	if(!defined('GBL_SMTCKS_WEBSITE')) {define('GBL_SMTCKS_WEBSITE', true);}
	include_once('new_ticket.mnu.php');
	
	if(!isset($shortcode['type']))
	{
		wp_register_style('simple-tickets', $GBL_SMTCKS['DIR_URI'].'/simple-tickets.css');
		wp_enqueue_style('simple-tickets');
		
		wp_register_style('simple-tickets-sc', $GBL_SMTCKS['DIR_URI'].'/shortcode.css');
		wp_enqueue_style('simple-tickets-sc');
		
		return '<div id="gbl_smtcks_clear">'.GBL_SMTCKS_ACT_NEW().GBL_SMTCKS_NEW_TICKET(true).'</div>';
	}
	return GBL_SMTCKS_ACT_NEW().GBL_SMTCKS_NEW_TICKET(true);
}

function GBL_SMTCKS_LIST($shortcode)
{
	global $GBLCOM, $GBL_SMTCKS;
	
	$return = null;
	
	if(file_exists(dirname(__FILE__).'/simple-tickets.lib.php'))
		include_once(dirname(__FILE__).'/simple-tickets.lib.php');
	else
		return $return;
	
	$ticket_files = scandir(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID']);
	
	$list_control = null;
	$ticket_row = null;
	$ticket_link = null;
	$ticket_files = null;
	$ticket_fields = null;
	$ticket_styling = null;
	$ticket_status_id = null;
	$ticket_list_array = null;
	$ticket_fields_display = null;
	$ticket_headers_display = null;
	$tickets_display_sticky = null;
	$gbl_smtcks_display_no_ticks = null;
	$tickets_display_content = array();
	
	$ticket_colours = false;
	
	$tickets_display = array(array(), array(), array());
	
	if(!isset($GBL_SMTCKS['SETTINGS']))
		return $return;
	
	foreach($GBL_SMTCKS['SETTINGS'] as $ticket_headers)
	{
		$ticket_headers = explode(',', $ticket_headers, 22);
		
		if($ticket_headers[0] != 'TKS')
			continue;
		
		if(!$ticket_headers[4]|!$ticket_headers[7])
			continue;
		
		$ticket_headers_display .= '<th>'.ucfirst(str_replace('_', ' ', $ticket_headers[3])).'</th>';
		$ticket_fields_display[] = $ticket_headers[1];
		
		if($ticket_headers[3] == 'Status'&$ticket_headers[2] == 'select'&$ticket_headers[9] != null)
		{
			$ticket_status_id = $ticket_headers[1];
			$GBL_SMTCKS['tkl_views'] = explode(',', $ticket_status_id.','.substr($ticket_headers[21], 0, -1));
			$tickets_display = array_fill_keys(range(0, count($GBL_SMTCKS['tkl_views'])), array(''));
			
			
			$ticket_colours = @unserialize($ticket_headers[9]);
			if(is_array($ticket_colours))
			{
				foreach($ticket_colours as $ticket_colour_id => $ticket_colour)
				{
					$ticket_colour = GBL_SMTCKS_HEX_TO_RGB($ticket_colour);
					
					if($ticket_colour != 'inherit')
					{
						if(is_array($ticket_colour))
							$ticket_styling .= 'table tbody tr#GBL_SMTCKS_'.$ticket_colour_id.' td {background: rgb('.implode(', ', $ticket_colour[0]).');}
												table tbody tr#GBL_SMTCKS_'.$ticket_colour_id.':hover td {	background: rgb('.implode(', ', $ticket_colour[1]).');}';
						else
							$ticket_styling .= 'table tbody tr#GBL_SMTCKS_'.$ticket_colour_id.' td {background: $ticket_colour;}';
					}
				}
			}
		}
	}
	
	$list_control = GBL_SMTCKS_LIST_OPTIONS();
	
	$ticket_files = scandir(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID']);
	foreach($ticket_files as $ticket_file)
	{
		if(substr($ticket_file, -4) !== '.tkl')
			continue;
		
		$ticket_list_array = GBL_SMTCKS_VALIDATE_TKL(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/'.$ticket_file);
		
		if($ticket_list_array != null)
		{
			foreach($ticket_list_array as $ticket_entry)
			{
				$ticket_entry = explode(',', $ticket_entry);
				
				if(count($ticket_entry) < 19)
					continue;
				
				if(($ticket_entry[0] != 'TKL') && ($ticket_entry[0] != 'HEAD'))
					continue;
				
				$ticket_fields = null;
				$ticket_div_id = 'GBL_SMTCKS_'.$ticket_entry[$ticket_status_id+19];
				
				if(file_exists(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_entry[1]))
					$filemtime_ticket = filemtime(GBL_ADMIN_DATA_DIR.'/'.$GBLCOM['GBL_SMTCKS_ID'].'/Default/Tickets/'.$ticket_entry[1]);
				else
					$filemtime_ticket = null;
				
				foreach($ticket_fields_display as $ticket_field_display)
				{
					if(isset($ticket_entry[$ticket_field_display+19]))
					{
						if($ticket_entry[$ticket_field_display+19] == null)
							$ticket_additional_field = 'Empty';
						else
							$ticket_additional_field = $ticket_entry[$ticket_field_display+19];
					}
					
					$ticket_fields .= '<td><div id="gbl_smtcks_max_width">'.$ticket_additional_field.'</div></td>';
					
				}
				
				if($ticket_entry[2] == '')
					$ticket_entry[2] = 'Guest';
				
				$ticket_entry[3] = GBL_SMTCKS_TIMEELAPSED($filemtime_ticket);
				
				if($ticket_entry[5] == '1')
					$ticket_div_id = 'gbl_smtcks_sticky_ticket';
				
				$ticket_row = <<<data
<tr id="$ticket_div_id"><td>
<div id="gbl_smtcks_max_width">$ticket_entry[1]</div>
</td><td>
<div id="gbl_smtcks_max_width">$ticket_entry[2]</div>
</td><td>
<div id="gbl_smtcks_max_width">$ticket_entry[3]</div>
</td>$ticket_fields</tr>
data;
				
				if($ticket_entry[5] == '1')
					$tickets_display_sticky .= $ticket_row;
				else
				{
					$gbl_search_tkl_views = GBL_SANITISE_TEXT_ONLY($ticket_entry[19+$GBL_SMTCKS['tkl_views'][0]]);
					
					if($GBL_SMTCKS['tkl_sort'] == 'datemodified')
					{
						if(isset($tickets_display[$gbl_search_tkl_views][$filemtime_ticket]))
							$tickets_display[$gbl_search_tkl_views][$filemtime_ticket] .= $ticket_row;
						else
							$tickets_display[$gbl_search_tkl_views][$filemtime_ticket] = $ticket_row;
					}
					else
					{
						if(isset($tickets_display[$gbl_search_tkl_views][$ticket_entry[1]]))
							$tickets_display[$gbl_search_tkl_views][$ticket_entry[1]] .= $ticket_row;
						else
							$tickets_display[$gbl_search_tkl_views][$ticket_entry[1]] = $ticket_row;
					}
				}
			}
		}
	}
	
	if($GBL_SMTCKS['tkl_view'] != '0'&$GBL_SMTCKS['tkl_view'] != 'all'&isset($tickets_display[$GBL_SMTCKS['tkl_view']]))
		$tickets_display_content = $tickets_display[$GBL_SMTCKS['tkl_view']];
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
			foreach($tickets_display as $tickets_display_each)
			{
				foreach($tickets_display_each as $tickets_display_each_id => $tickets_display_each)
				{
					if(isset($tickets_display_content[$tickets_display_each_id]))
						$tickets_display_content[$tickets_display_each_id] .= $tickets_display_each;
					else
						$tickets_display_content[$tickets_display_each_id] = $tickets_display_each;
				}
			}
		}
	}
	
	if($GBL_SMTCKS['tkl_order'] == 'descending')
		ksort($tickets_display_content);
	else
		krsort($tickets_display_content);
	
	$tickets_display_content = implode('', $tickets_display_content);
	
	if($ticket_styling != null)
		$ticket_styling = '<style>'.$ticket_styling.'</style>';
	
	$return = <<<data
$ticket_styling

$list_control

<div id="gbl_smtcks_clear" style="margin: 0; width: 100%;">
<table>
<thead>
<tr id="gbl_smtcks_pointer">
<th style="width: 70px;">Ticket</th>
<th>User</th>
<th>Date Modified</th>
$ticket_headers_display

</tr>
</thead>

<tbody>

$tickets_display_sticky
$tickets_display_content

</tbody>
</table>
$gbl_smtcks_display_no_ticks
</div>

<!-- START SORT SCRIPT -->
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
<!-- END SORT SCRIPT -->
data;
	
	if(isset($shortcode['style']))
	{
		wp_register_style('simple-tickets', $GBL_SMTCKS['DIR_URI'].'/simple-tickets.css');
		wp_enqueue_style('simple-tickets');
		
		wp_register_style('simple-tickets-sc', $GBL_SMTCKS['DIR_URI'].'/shortcode.css');
		wp_enqueue_style('simple-tickets-sc');
	}
	
	
	return $return;
}
?>