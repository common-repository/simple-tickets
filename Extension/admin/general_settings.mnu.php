<?php
/*
Globel Administrator Library File
*/
// Exit if file accessed directly ///
global $GBLCOM, $buildCOM;
defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
$ACCORDIONCONSTANT = 'GBL_ADMIN_ACCORDION_'.'GENSETTINGS';
$FAQPAGELINK = GBL_ADMIN_EXTENSION_SITE.'/?gblqry=general_settings';
$GBLCOM['GBL_ADMIN_PAGE'] = "general_settings";
$gblnotification = "";
$msg = "";

$size = 'style="width: calc(100% - 10px);"';//display: block;background-color: #ddd;
$selected = '';
$colback = "";
$coltext = "";
$time = "7";
$MyFile = "";
$buildCOM = false;
$Features = "";
$headerbuttons = "";
$ERR1 = ""; $ERR2 = "";
$BK1 = ""; $BK2 = "";
$SW1 = ""; $SW2 = "";
$DB1 = ""; $DB2 = "";
$HD1 = ""; $HD2 = "";
$FT1 = ""; $FT2 = "";
$AD1 = ""; $AD2 = "";
$PR1 = ""; $PR2 = "";

if ($GBLCOM['GBL_ADMIN_ACT'] == "Save Settings")
	{
	//if(isset($_REQUEST["GBL_ADMIN_PHP_ERROR"])){$GBLCOM["GBL_ADMIN_PHP_ERROR"] = $_REQUEST["GBL_ADMIN_PHP_ERROR"];} /// REM FOR WORDPRESS
	if(isset($_REQUEST["GBL_ADMIN_SAVE_BACKUPS"])){$GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_SAVE_BACKUPS"]);}
	if(isset($_REQUEST["GBL_ADMIN_SWITCH_DISPLAY"])){$GBLCOM["GBL_ADMIN_SWITCH_DISPLAY"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_SWITCH_DISPLAY"]);}
	if(isset($_REQUEST["GBL_ADMIN_DASHBOARD"])){$GBLCOM["GBL_ADMIN_DASHBOARD"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_DASHBOARD"]);}
	if(isset($_REQUEST["GBL_ADMIN_HEADER"])){$GBLCOM["GBL_ADMIN_HEADER"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_HEADER"]);}
	if(isset($_REQUEST["GBL_ADMIN_FOOTER"])){$GBLCOM["GBL_ADMIN_FOOTER"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_FOOTER"]);}
	if(isset($_REQUEST["GBL_ADMIN_ADVANCED_FEATURES"])){$GBLCOM["GBL_ADMIN_ADVANCED_FEATURES"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_ADVANCED_FEATURES"]);}
	if(isset($_REQUEST["GBL_ADMIN_PRIMARY"])){$GBLCOM["GBL_ADMIN_PRIMARY"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_PRIMARY"]);}
	//if(isset($_REQUEST["GBL_ADMIN_THEME"])){$GBLCOM["GBL_ADMIN_THEME"] = GBL_SANITISE_TEXT_FIELD($_REQUEST["GBL_ADMIN_THEME"]);}
	
	
	
	/// ACCORDION settings ACCORDION1/ACCORDION2/ACCORDION3 ETC....
	
	$ACCORD[0] = "ACCORDION"; // for 5 part accordion
	if((isset($_REQUEST["ACCORDION1"])) && $_REQUEST["ACCORDION1"] == "checked"){$ACCORD[1] = "checked";}else {$ACCORD[1] = "";}
	if((isset($_REQUEST["ACCORDION2"])) && $_REQUEST["ACCORDION2"] == "checked"){$ACCORD[2] = "checked";}else {$ACCORD[2] = "";}
	if((isset($_REQUEST["ACCORDION3"])) && $_REQUEST["ACCORDION3"] == "checked"){$ACCORD[3] = "checked";}else {$ACCORD[3] = "";}
	if((isset($_REQUEST["ACCORDION4"])) && $_REQUEST["ACCORDION4"] == "checked"){$ACCORD[4] = "checked";}else {$ACCORD[4] = "";}
	if((isset($_REQUEST["ACCORDION5"])) && $_REQUEST["ACCORDION5"] == "checked"){$ACCORD[5] = "checked";}else {$ACCORD[5] = "";}
	$GBLCOM[$ACCORDIONCONSTANT] = implode(",",$ACCORD);

	$buildCOM = true;
	}
$selected = ' selected="selected"';
$EXT = "";
///if ($GBLCOM["GBL_ADMIN_PHP_ERROR"] == "yes"){$ERR1 = $selected;}else{$ERR2 = $selected;} /// REM FOR WORDPRESS
if ($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes"){$BK1 = $selected;}else{$BK2 = $selected;}
if ($GBLCOM["GBL_ADMIN_SWITCH_DISPLAY"] == "off"){$SW1 = $selected;}else{$SW2 = $selected;}
if ($GBLCOM["GBL_ADMIN_DASHBOARD"] == "off"){$DB1 = $selected;}else{$DB2 = $selected;}
if ($GBLCOM["GBL_ADMIN_HEADER"] == "off"){$HD1 = $selected;}else{$HD2 = $selected;}
if ($GBLCOM["GBL_ADMIN_FOOTER"] == "off"){$FT1 = $selected;}else{$FT2 = $selected;}
if ($GBLCOM["GBL_ADMIN_ADVANCED_FEATURES"] == "off"){$AD1 = $selected;}else{$AD2 = $selected;}
if ($GBLCOM["GBL_ADMIN_PRIMARY"] == "off"){$PR1 = $selected;}
else{
	///if ($GBLCOM["GBL_ADMIN_PRIMARY_KEY"] == ""){$GBLCOM["GBL_ADMIN_PRIMARY_KEY"] = GBL_CREATE_ID("30");}
	//$EXT = '<tr><td colspan="2">Put the following code in your slave panels: </td></tr>';
	//$EXT .= '<tr><td colspan="2">'.'This Server / Site Primary Key = '.$GBLCOM["GBL_ADMIN_PRIMARY_KEY"].''.'</td></tr>';
	$EXT .= '<tr><td align="right" valign="middle" width="50%">';
	$EXT .= 'This Server / Site Primary Key:';
	$EXT .= '</td><td align="left" valign="middle">';
	$EXT .= ''.$GBLCOM["GBL_ADMIN_PRIMARY_KEY"].'';
	$EXT .= '</td></tr>';
	/// SLAVE OFF = slave on = input master details
	//$EXT = ;
	$PR2 = $selected;
	}
// GET FEATURES THIS will go elsewhere...............

// HEADER BUTTONS
$headerbuttons = '<span style="float:right;">';
$headerbuttons .= '<a style="text-decoration: none;border:0;" href="'.$FAQPAGELINK.'" target="_blank">';
$headerbuttons .= '<img src="'.GBL_ADMIN_IMAGES.'/faq.png" title="Get Help?">';
$headerbuttons .= '</a>';
$headerbuttons .= '</SPAN>';

$THEMESELECTBOX = "";
$scandir = GBL_ADMIN_THEMES_DIR."/";
$dirs = scandir($scandir);
$THEMESELECTBOX = '<select name="GBL_ADMIN_THEME" '.$size.'>'."\n";
/// BUILD THEMES BOX
foreach ($dirs as $fileinfo)
	{
    if (is_dir($scandir.$fileinfo) && $fileinfo != "." && $fileinfo != "..")
    	{
		if ($fileinfo != "")
			{
			if ($fileinfo[0] != "_")
				{
				$ThemeTitle = ucwords(str_replace('_', ' ', $fileinfo));
				if ($GBLCOM['GBL_ADMIN_THEME'] == $fileinfo){$THEMESELECTBOX .= '<option value="'.$fileinfo.'"'.$selected.'>'.$ThemeTitle.'</option>'."\n";}
				else {$THEMESELECTBOX .= '<option value="'.$fileinfo.'">'.$ThemeTitle.'</option>'."\n";}
				}
			}
   		}
	}
$THEMESELECTBOX .= '</select>'."\n";
	
// $GBLCOM['GBL_ADMIN_THEME']


$HIDDEN1 = GBL_ADMIN_CONTROL_INSERTS('');

///print $HIDDEN1; exit;

//$featurename = "General Settings";

$Features = array ("General Settings"  => "");
//$Features["General Settings"] = "";
$Features["General Settings"] .= <<<Feature1
				<table>
					<thead>
						<tr>
							<th colspan="2">$headerbuttons</th>
						</tr>
					</thead>
				<tbody>
					<tr>
						<td align="left" valign="middle" width="50%">
						Auto Save Backups: </td>
						<td align="left" valign="middle">
						<select name="GBL_ADMIN_SAVE_BACKUPS" $size>
						  <option value="yes"$BK1>yes</option>
						  <option value="no"$BK2>no</option>
						</select>
						</td>
					</tr>
					<tr>
						<td align="left" valign="middle" width="50%">
						Display output from scripts:</td>
						<td align="left" valign="middle">
						<select name="GBL_ADMIN_SWITCH_DISPLAY" $size>
						  <option value="off"$SW1>off</option>
						  <option value="on"$SW2>on</option>
						</select>
						</td>
					</tr> 
					<tr>
						<td align="left" valign="middle" width="50%">
						Switch Globel Dashboard On or Off:
						</td>
						<td align="left" valign="middle">
						<select name="GBL_ADMIN_DASHBOARD" $size>
						  <option value="off"$DB1>off</option>
						  <option value="on"$DB2>on</option>
						</select>
						</td>
					</tr> 
					<tr>
						<td align="left" valign="middle" width="50%">
						Advanced Features On/Off:
						</td>
						<td align="left" valign="middle">
						<select name="GBL_ADMIN_ADVANCED_FEATURES" $size>
						  <option value="off"$AD1>off</option>
						  <option value="on"$AD2>on</option>
						</select>
						</td>
					</tr> 
					<tr>
						<td align="left" valign="middle" width="50%">
						Select Admin Theme:
						</td>
						<td align="left" valign="middle">
						$THEMESELECTBOX
						</td>
					</tr> 
				</tbody>
			</table>
Feature1;

if ($GBLCOM["GBL_ADMIN_ADVANCED_FEATURES"] == "on")
	{
	$CheckDir = GBL_ADMIN_EXTENSIONS_DIR.'/'.$GBLCOM['GBL_ADMIN_TAB'];// check for features in folder
	if (GBL_ADMIN_MAKE_CHECK_DIR($CheckDir))
		{
		$files = scandir($CheckDir.'/');
		foreach ($files as $file)
			{
			if ((strpos($file, ".ftr.php")) && ($file != ""))
				{
				$funk = str_replace(".","_",$file);
				include_once($CheckDir.'/'.$file);
				if (function_exists($funk))
					{
					list ($F1,$F2) = $funk();
					if ($F1 != ""){$Features[$F1] = $F2;}
					}
				//print '...............................................................'.$file.'<br>';
				}
			}
		}
	if (($GBLCOM['GBL_ADMIN_TAB'] == "admin") && ($GBLCOM['GBL_ADMIN_PAGE'] == "general_settings"))
		{
		$CheckDir = GBL_ADMIN_INCLUDES_DIR;// check for features in includes directory
		$files = scandir($CheckDir.'/');
		foreach ($files as $file)
			{
			if ((strpos($file, ".ftr.php")) && ($file != ""))
				{
				$funk = str_replace(".","_",$file);
				include_once($CheckDir.'/'.$file);
				if (function_exists($funk))
					{
					list ($F1,$F2) = $funk();
					if ($F1 != ""){$Features[$F1] = $F2;}
					}
				//print '...............................................................'.$file.'<br>';
				}
			}
		}
	}

$MYFEATURES = GBL_ADMIN_WRAP_ACCORDION($Features,$ACCORDIONCONSTANT); /// $Features = as an array || $ACCORDIONCONSTANT your GBLCOM string


//print "<pre>";
//print_r($ACCORDIONCONSTANT);
//print "</pre>";


if ($buildCOM)
	{
	//PRINT "BLANK";
	if (GBL_SAVE_COMFILE($GBLCOM,"","","GBL_ADMIN_APP_NAME",GBL_ADMIN_APP_NAME,"GBLCOM",GBL_ADMIN_DATA_DIR."/")) 
	{$msg .= "Settings Saved Successfully."; $colback = "yellow"; $coltext = "black";}	
	else {$msg = "Settings Error."; $colback = "red"; $coltext = "black";}
	}

if ($msg != ""){$gblnotification = GBL_NOTIFICATION($msg,$colback,$coltext,$time);}
// <div id="Notification">$gblnotification</div>
$content = '';
$content .= <<<CONTENT
<div id="Notification">$gblnotification</div>

<form action="" method="post">
	<div style="width: 99%; margin: 5px auto;">
$MYFEATURES
					<table>
						<tbody>
							<tr>
								<td colspan="2">
									<CENTER><input class="btn" name="gblact" value="Save Settings" id="btn" type="submit"></CENTER>
								</td>
							</tr>
						</tbody>
					</table>
				$HIDDEN1		
			</div>
	</div>
</form>
CONTENT;
/* //REM FOR NOW
		<tr>
			<td align="left" valign="middle" width="50%">
			Switch Header On/Off:
			</td>
			<td align="left" valign="middle">
			<select name="GBL_ADMIN_HEADER">
			  <option value="off"$HD1>off</option>
			  <option value="on"$HD2>on</option>
			</select>
			</td>
		</tr> 
		<tr>
			<td align="left" valign="middle" width="50%">
			Switch Footer On/Off:
			</td>
			<td align="left" valign="middle">
			<select name="GBL_ADMIN_FOOTER">
			  <option value="off"$FT1>off</option>
			  <option value="on"$FT2>on</option>
			</select>
			</td>
		</tr> 
		<tr>
			<td align="left" valign="middle" width="50%">
			Primary System On/Off:
			</td>
			<td align="left" valign="middle">
			<select name="GBL_ADMIN_PRIMARY">
			  <option value="off"$PR1>off</option>
			  <option value="on"$PR2>on</option>
			</select>
			
			</td>
		</tr> 
		$EXT

*/
?>
