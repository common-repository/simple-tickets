<?php
/*
Globel Administrator Library File for wordpress
*/
// Exit if file accessed directly ///
global $GBLCOM, $GBLMNUORDER;
defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
///////////////////////////////////////

function GBL_ADMIN_WRAP_ACCORDION($HTMLCONTENTS, $GBLCOMNAME)// as array
{
global $GBLCOM;
$ACCORDION = array_fill(0, 50, "");
$ACCORDION[0] = "ACCORDION"; // if not set below
$ACCORDION[1] = "checked";
if(isset($GBLCOM[$GBLCOMNAME])){$ACCORDION = explode(",",$GBLCOM[$GBLCOMNAME]);}
$wrapcount = 1;
$name = '';
$featurename = '';
$ACCcond = '';
$wrapped = "\n".'<!-- Start Accordion Wrapper -->'."\n";
$wrapped .= '<div class="accordion vertical">';
$wrapped .= '<ul>';

foreach ($HTMLCONTENTS as $key => $item)
	{
	$featurename = $key;
	
	$name = 'ACCORDION'.$wrapcount;
	$ACCcond = $ACCORDION[$wrapcount];
	$wrapped .= '<li>';
	$wrapped .= '<input type="checkbox" id="'.$name.'" name="'.$name.'" value="checked" '.$ACCcond.' />'; //
	$wrapped .= '<label for="'.$name.'">'.$featurename.'</label>';
	$wrapped .= '<div class="content">';
	$wrapped .= $item;
	$wrapped .= '</div>';
	$wrapped .= '</li>';
	
	$wrapcount++;
	}
$wrapped .= '</ul>';
$wrapped .= "\n".'<!-- End Accordion Wrapper -->'."\n";
return $wrapped;
}

/**
 * Minifies stylesheet definitions
 *
 * @param 	string	$FILE	Stylesheet definitions as string
 * @return 	string		Minified stylesheet definitions
 * @author 		Joe Scylla <joe.scylla@gmail.com>
 * @copyright 	2008 Joe Scylla <joe.scylla@gmail.com>
 * Modified for Globel
 */
function GBL_ADMIN_CONDENSE_CSS($FILE)
{
$FILE = trim($FILE);
$FILE = str_replace("\r\n", "\n", $FILE);
$search = array("/\/\*[\d\D]*?\*\/|\t+/", "/\s+/", "/\}\s+/");
$replace = array(null, " ", "}\n");
$FILE = preg_replace($search, $replace, $FILE);
$search = array("/\\;\s/", "/\s*\{\\s*/", "/\\:\s+\\#/", "/,\s+/i", "/\\:\s+\\\'/i", "/\\:\s+([0-9A-Z\-]+)/i");
$replace = array(";", "{", ":#", ",", ":\'", ":$1");
$FILE = preg_replace($search, $replace, $FILE);
$FILE = str_replace("\n", null, $FILE);
return $FILE;
}

function GBL_ADMIN_GET_ERRORS()
{
global $GBLCOM;
$LIST = "";
$output = "";
$colback = "";
$coltext = "";
$displaytime = "";
$persist = "";
$persistime = "";
$cannedMSGnum = "";
$MYTITLE = "";
$DISPLAYTITLE = "";
/*
FORMAT:
IF YOU WANT TO RETURN A TITLE
$GBLCOM['GBL_ADMIN_ERRORS']["TITLE OF ERROR"][] = "ERROR MSG"; TO INSERT TITLED ERROR!
$GBLCOM['GBL_ADMIN_ERRORS'][] = "BUGGER1<BR>"; TO INSERT ONE LINE ERROR!

$GBLCOM['GBL_ADMIN_ERRORS_STYLE']["TITLE OF ERROR"] = "$colback,$coltext,$displaytime";

$msg,$colback,$coltext,$displaytime
*/
//print '<pre>';
//print_r($GBLCOM['GBL_ADMIN_ERRORS']);
//print '</pre>';

if  (is_array($GBLCOM['GBL_ADMIN_ERRORS']))
	{
	foreach ($GBLCOM['GBL_ADMIN_ERRORS'] as $key => $TITLE)
		{
		$MYTITLE = $key;// AS TITLE
		if (is_array($TITLE))
			{
			$MYTITLE = $key;// AS TITLE
			//$DISPLAYTITLE = '#myelement { -vendor-animation-duration: 3s; -vendor-animation-delay: 10s; -vendor-animation-iteration-count: infinite;}';
			$DISPLAYTITLE = '<h1 class="animated pulse">'.$MYTITLE.'</h1>';// infinite
			$ERRORS = $TITLE;
			foreach ($ERRORS as $key => $error)
				{
				$LIST .= $error."<BR>";
				}
			}
		else {$LIST .= $TITLE."<BR>";}
		
		if ((is_array($GBLCOM['GBL_ADMIN_ERRORS_STYLE'])) && (isset($GBLCOM['GBL_ADMIN_ERRORS_STYLE'][$MYTITLE])))
			{
			list($colback,$coltext,$fontweight,$displaytime,$persist,$persistime,$cannedMSGnum) = explode( ',', $GBLCOM['GBL_ADMIN_ERRORS_STYLE'][$MYTITLE]);
			}
		else {$colback = "#fff"; $coltext = "#000"; $fontweight = ""; $displaytime = "7"; $persist = "no"; $persistime = "1h"; $cannedMSGnum = "0";}// default
		
		$output .= '<div style="width: 99%; margin: 5px auto; background-color: '.$colback.'; color: '.$coltext.'; font-weight: '.$fontweight.'">';
		$output .= '<BR>'.$DISPLAYTITLE.'<P>'.$LIST.'</P><BR>';
		$output .= '</div>';
		//<h1 class="animated infinite bounce">Example</h1>
		$LIST = "";
		$MYTITLE = "";
		$DISPLAYTITLE = "";
		}
/* FORMAT GBL_ADMIN_ERRORS_STYLE
0 = DIV background color either text or hash
1 = DIV text colour either text or hash
2 = text font weight i.e. bold
3 = DIV display time if JS enabled 0=infinity 1++ = seconds
4 = message persistance setting yes/no 
5 = persistance time i.e. hour day etc.
6 = Canned Message = message list or file by numbers when this is enabled with any number above zero or null you do not need to use GBL_ADMIN_ERRORS
** NEW ** THINKING ABOUT
7 = INSERT INTO MESSAGES EITHER BOX OR ERROR LIST
8 = SEND EMAIL MESSAGE NOTIFY
*/
	// TODO CHANGE FORMAT PLAIN DIV O/P <div id="Notification">$LIST</div>
	// DO FEEDBACK MESSAGE IF JAVA LIB NOT INSTALLED && ANYTHING ELSE?
	// DO DISSMISS MESSAGE IF PERSISTANT
	// DO PERSISTANT LIB
	// DO ADD TO LOG AND/OR SEND EMAIL I.E. PASSWORD CHANGE
	return $output;
	}
else {return "";}
}

function GBL_ADMIN_MAKE_CHECK_DIR($target)
{
/**
 * Wordpress contributed Recursive directory creation based on full path.
 * Will attempt to set permissions on folders.
 * Was Wordpress @since 2.0.1 from
 * @param string $target Full path to attempt to create.
 * @return bool Whether the path was created. True if path already exists.
 * Modded for Globel Library .........
 */
// From php.net/mkdir plus user contributed notes.
$target = str_replace( '//', '/', $target );

/*
 * Safe mode fails with a trailing slash under certain PHP versions.
 * Use rtrim() instead of untrailingslashit to avoid formatting.php dependency.
 */
$target = rtrim($target, '/');
if (empty($target)){$target = '/';}


if ((file_exists($target)) && (is_dir($target))){return true;}
	//return @is_dir( $target );

// We need to find the permissions of the parent folder that exists and inherit that.
$target_parent = dirname( $target );
while ('.' != $target_parent && ! is_dir($target_parent)){$target_parent = dirname($target_parent);}

// Get the permission bits.
if ($stat = @stat($target_parent)){$dir_perms = $stat['mode'] & 0007777;} else{$dir_perms = 0777;}

if (@mkdir($target,$dir_perms,true)){
	/*
	 * If a umask is set that modifies $dir_perms, we'll have to re-set
	 * the $dir_perms correctly with chmod()
	 */
	if ($dir_perms != ($dir_perms & ~umask()))
		{
		$folder_parts = explode('/',substr($target,strlen($target_parent)+1));
		for ($i = 1, $c = count($folder_parts); $i <= $c; $i++)
			{
			@chmod($target_parent.'/'.implode('/',array_slice($folder_parts,0,$i)),$dir_perms);
			}
		}
	return true;
}
return false;
}
//GBL_ADMIN_CREATE_ADR("name of line i.e. ADR", "VALUE for each field i.e. 0", "segments 6 i.e. 6x50 = 300"); 
function GBL_ADMIN_CREATE_ADR($NAME, $DEFVALUE, $SEGMENTS = NULL)
{
$elements = 51;
$division = '||DIV||';
if ($DEFVALUE == ""){$DEFVALUE = NULL;}
if (($SEGMENTS == "") || ($SEGMENTS <= "0")){$SEGMENTS = "1";}
if (($SEGMENTS > "6")){$SEGMENTS = "6";}
if ($NAME == ""){$NAME = "HEADER";}
if (($SEGMENTS == "1") || ($SEGMENTS == NULL))
	{
	$ADR = array_fill(0, $elements, $DEFVALUE);
	$ADR[0] = $NAME;
	$ADR[$elements] = $elements;
	return $ADR;
	}
elseif (($SEGMENTS > 1) && ($SEGMENTS <= 6))
	{
	$expandelements = $elements * $SEGMENTS;
	$ADR = array_fill(0, $expandelements+1, $DEFVALUE);
	$ADR[0] = $NAME;
	if(isset($ADR[$elements])){$ADR[$elements] = $division;}
	if(isset($ADR[$elements*2])){$ADR[$elements*2] = $division;}
	if(isset($ADR[$elements*3])){$ADR[$elements*3] = $division;}
	if(isset($ADR[$elements*4])){$ADR[$elements*4] = $division;}
	if(isset($ADR[$elements*5])){$ADR[$elements*5] = $division;}
	$ADR[$expandelements] = $expandelements;
	return $ADR;
	}
else {print "too many segments";}
/*
PRED FIXED LINES
[0] => CAT (ALWAYS THE HEADER)
[51] => ||DIV|| (FIXED)
[102] => ||DIV|| (FIXED)
[153] => ||DIV|| (FIXED)
[204] => ||DIV|| (FIXED)
[255] => ||DIV|| (FIXED)
[306] => 306 (LAST TOTAL)
*/
return false;
}

function GBL_ADMIN_SAVE_ADR($FILE)
{
global $GBLCOM;
$newlines = "";
$GBLCOM['GBL_ADMIN_ADR_LINES'] = str_replace(array("\n\n", "\t\t", "\r\r"), array("\n", "\t", "\r"), $GBLCOM['GBL_ADMIN_ADR_LINES']);
foreach ($GBLCOM['GBL_ADMIN_ADR_LINES'] as $line)
	{
		
	// ALWAYS INCLUDE HEADER FIRST i.e. array[0] is header of CSV file
	//$line = trim($line); = WRONG PLACE
	//$line = str_replace(array("\n", "\t", "\r"), "", $line);
	if (($line != "") and (!empty($line)))
		{
		//print $line;
		if(is_array($line))
			{
			$newlines .= implode($line, ",")."\n";
			}
		else 
			{
			$line = trim($line);
			$newlines .= $line."\n";
			}
		}
	//print $line;
	}
///$newlines = str_replace( "\n\n", "\n",$newlines);
if (GBL_SAVE_FILE_CONTENTS($FILE, $newlines)){return true;}
else {return false;}
}

function GBL_ADMIN_FETCH_ADR($FILE,$RETURNLINES = null)
{
global $GBLCOM;
$filecontent = "";
$filelines = "";
$GBLCOM['GBL_ADMIN_ADR_LINES'] = null;
if ($RETURNLINES == ""){$RETURNLINES = false;}
if(file_exists($FILE))
	{
	$filecontent = GBL_OPEN_FILE_CONTENTS($FILE);
	if (($filecontent != "") || ($filecontent != null))
		{
		$filelines = explode("\n", $filecontent);
		if ($RETURNLINES){$GBLCOM['GBL_ADMIN_ADR_LINES'] = $filelines;}
		else
			{
			foreach ($filelines as $line){if ($line != ""){$GBLCOM['GBL_ADMIN_ADR_LINES'][] = explode(",", $line);}}
			return true;
			}
		}
	else {return false;}
	}
else {return false;}
}


function GBL_OPEN_FILE_CONTENTS($FILE)
{
global $GBLCOM;
if (file_exists(GBL_ADMIN_INCLUDES_DIR."/encoder.ftr.php")){include_once(GBL_ADMIN_INCLUDES_DIR."/encoder.ftr.php");}
$FILE_HANDLE = fopen($FILE, 'r');
flock($FILE_HANDLE, LOCK_SH);
$MYCONTENT = "";
$MYCONTENT = file_get_contents($FILE);
fclose($FILE_HANDLE);

if ((isset($GBLCOM['GBL_ADMIN_ENCODE_DATA'])) && (isset($GBLCOM['GBL_ADMIN_ENCODE_SALT'])))
	{
		/*	LUKE 01.02/2017 This fixes the Simple Tickets GBL_ADMIN_FETCH_ADR i.e. before the GBL_ADMIN_DECODE is called  $MYCONTENT is good and GBL_ADMIN_ENCODE_SALT is NULL.
			When this function (GBL_ADMIN_DECODE) is called (it contains this check if SALT is null within it) it tries to decode or encode the $MYCONTENT variable.*/
	if($GBLCOM['GBL_ADMIN_ENCODE_SALT'] != NULL)
		{
		if (function_exists('GBL_ADMIN_DECODE'))
			{
			$MYCONTENT = GBL_ADMIN_DECODE($MYCONTENT,$GBLCOM['GBL_ADMIN_ENCODE_SALT']);
			}
		}
	}
return $MYCONTENT;
}
/*
function GBL_OPEN_FILE_CONTENTS($FILE)
{
global $GBLCOM;
if (file_exists(GBL_ADMIN_INCLUDES_DIR."/encoder.ftr.php")){include_once(GBL_ADMIN_INCLUDES_DIR."/encoder.ftr.php");}
$FILE_HANDLE = fopen($FILE, 'r');
flock($FILE_HANDLE, LOCK_SH);
$MYCONTENT = "";
$MYCONTENT = file_get_contents($FILE);
fclose($FILE_HANDLE);

if ((isset($GBLCOM['GBL_ADMIN_ENCODE_DATA'])) && (isset($GBLCOM['GBL_ADMIN_ENCODE_SALT'])))
	{
	if (function_exists('GBL_ADMIN_DECODE'))
		{
		$MYCONTENT = GBL_ADMIN_DECODE($MYCONTENT,$GBLCOM['GBL_ADMIN_ENCODE_SALT']);
		}
	}
return $MYCONTENT;
}
*/
function GBL_ADMIN_CREATE_POST_ERROR($message,$errornumber)
{
global $GBLCOM;	
$MyFile = GBL_ADMIN_DATA_PO_ADMIN.'/Inbox/'.$errornumber.'.err';
	if (!FILE_EXISTS($MyFile))
		{
		if (file_put_contents($MyFile, $message)){$success = true;}else {$success = false;};
		return $success;
		}

}

function GBL_SAVE_FILE_CONTENTS($FILE,$CONTENT)
{
global $GBLCOM;
if (file_exists(GBL_ADMIN_INCLUDES_DIR."/encoder.ftr.php")){include_once(GBL_ADMIN_INCLUDES_DIR."/encoder.ftr.php");}
$MYCONTENT = $CONTENT;
//PRINT $CONTENT;
// CHANGE FOR UNIVERSAL AND NOT JUST WP
//goto 453643
//*********************** $DIR CHECK leading slash and double **********************//
//CHECK FOR AND/OR CREATE REQUIRED FILES
$DIR = dirname($FILE);
if (!file_exists($DIR.'/index.php')){GBL_CHECKCREATE_STOPFILE($DIR.'/index.php');}
//********************************************************
if((isset($_REQUEST['_wpnonce'])) && (GBL_ADMIN_MYNAME == "GlobelWP"))
	{
	$GBL_ADMIN_KEEP_TRACK = ''; // moved from goto 453643
	$MyKey = 'hRF54pF';	
	
	$GBL_ADMIN_KEEP_TRACK = $_REQUEST['_wpnonce']; // no sanitisation needed as per wordpress email
	if (wp_verify_nonce($GBL_ADMIN_KEEP_TRACK, $MyKey))
		{

			
		$FILE = str_replace('//', '/',$FILE);
		if ((isset($GBLCOM['GBL_ADMIN_ENCODE_DATA'])) && (isset($GBLCOM['GBL_ADMIN_ENCODE_SALT'])))
			{
			if (($GBLCOM['GBL_ADMIN_ENCODE_DATA'] == "on") && ($GBLCOM['GBL_ADMIN_ENCODE_SALT'] != ""))
				{
				if (function_exists('GBL_ADMIN_ENCODE'))
					{
					$MYCONTENT = GBL_ADMIN_ENCODE($MYCONTENT,$GBLCOM['GBL_ADMIN_ENCODE_SALT']);
					}
				}
			}
		if (file_put_contents($FILE, $MYCONTENT,  LOCK_EX | LOCK_SH)){return true;}
		else {return false;}
		}
	else 
		{
		wp_die('Invalid nonce specified', GBL_ADMIN_APP_NAME_SHORT);
		return false;
		}
	}
elseif((GBL_ADMIN_MYNAME == "index"))
	{
	$FILE = str_replace('//', '/',$FILE);
	//$GBLCOM['GBL_ADMIN_KEEP_TRACK'] = $GBLCOM['GBL_ADMIN_TRK'];
	if ((isset($GBLCOM['GBL_ADMIN_ENCODE_DATA'])) && (isset($GBLCOM['GBL_ADMIN_ENCODE_SALT'])))
		{
		if (($GBLCOM['GBL_ADMIN_ENCODE_DATA'] == "on") && ($GBLCOM['GBL_ADMIN_ENCODE_SALT'] != ""))
			{
			if (function_exists('GBL_ADMIN_ENCODE'))
				{
				$MYCONTENT = GBL_ADMIN_ENCODE($MYCONTENT,$GBLCOM['GBL_ADMIN_ENCODE_SALT']);
				}
			}
		}
	if (file_put_contents($FILE, $MYCONTENT,  LOCK_EX | LOCK_SH)){return true;}
	else 
		{
		/// May be permisions problem so try
		$GBL_DESTINATION = $FILE."_could_not_write";
		if (FILE_EXISTS($FILE) == false){copy($FILE, $GBL_DESTINATION); unlink($FILE);} // DELETE OLD FILE AND MAKE A COPY OF IT
		if (file_put_contents($FILE, $MYCONTENT,  LOCK_EX | LOCK_SH)){return true;} //TRY AGAIN
		else {return false;}
		}
	
	}
else 
	{
	return false;
	}
		
}

function GBL_ADMIN_CONTROL_INSERTS($URL)
{
global $GBLCOM;
$value = '';
//print $URL;
if (GBL_ADMIN_MYNAME == "GlobelWP")
	{
	if ($URL != "")
		{
		$value = $URL."&_wpnonce=".$GBLCOM['GBL_ADMIN_KEEP_TRACK']."&page=".GBL_WORDPRESS_ADMIN.'&gbltab='.$GBLCOM['GBL_ADMIN_TAB'].'&gblpage='.$GBLCOM['GBL_ADMIN_PAGE'];
		}
	else
		{
		$value = "\n".'<!-- START HIDE FIELDS -->'."\n";
		$value .= '<input value="'.$GBLCOM['GBL_ADMIN_TAB'].'" name="gbltab" type="hidden">'."\n";
		$value .= '<input value="'.$GBLCOM['GBL_ADMIN_PAGE'].'" name="gblpage" type="hidden">'."\n";
		 // INSERT FOR WORDPRESS
		$value .= '<input value="'.GBL_WORDPRESS_ADMIN.'" name="page" type="hidden">'."\n";
		$value .= '<input value="'.$GBLCOM['GBL_ADMIN_KEEP_TRACK'].'" name="_wpnonce" type="hidden">'."\n";
		$value .= '<!-- END HIDE FIELDS -->'."\n";
		}
	}
elseif (GBL_ADMIN_MYNAME == "index")
	{
	if ($URL != "")
		{
		$value = $URL."&gbltrk=".$GBLCOM['GBL_ADMIN_KEEP_TRACK'].'&gbltab='.$GBLCOM['GBL_ADMIN_TAB'].'&gblpage='.$GBLCOM['GBL_ADMIN_PAGE'];
		}
	else
		{
		$value = "\n".'<!-- START HIDE FIELDS -->'."\n";
		$value .= '<input value="'.$GBLCOM['GBL_ADMIN_TAB'].'" name="gbltab" type="hidden">'."\n";
		$value .= '<input value="'.$GBLCOM['GBL_ADMIN_PAGE'].'" name="gblpage" type="hidden">'."\n";
		$value .= '<input value="'.$GBLCOM['GBL_ADMIN_KEEP_TRACK'].'" name="gbltrk" type="hidden">'."\n";
		$value .= '<!-- END HIDE FIELDS -->'."\n";
		}
	}
else {$value = $URL;}
return $value;
}

function GBL_SANITISE_PASSWORD($TXT) /// NOT FOR WORDPRESS
{
$TXT = strip_tags($TXT); // strip out any HTML
$TXT = preg_replace('/\s+/S', " ", $TXT); //replace all multiple white-spaces, tabs and new-lines
$TXT = preg_replace("/[^a-zA-Z0-9@!~]/", "", $TXT); /// allow only chars @ ! or ~
return $TXT;
}

function GBL_SANITISE_EMAIL($TXT)
{
global $GBLCOM;
if (GBL_ADMIN_MYNAME == "GlobelWP"){$TXT = sanitize_email($TXT);return $TXT;}
elseif (GBL_ADMIN_MYNAME == "index")
	{ /// NOTICE HERE! RETURN ERROR
	///$GBLCOM['GBL_ADMIN_ERROR_STATE'] = "OK";
	///$GBLCOM['GBL_ADMIN_ERROR_MESSAGE'] = "";
	/// NOTE: NOT SUBS BUT DOMAIN EXT
	//print '..........................................................'.$TXT;
	$errorcount = 0;
	
//$local = '';
//$domain = '';
//print $TXT.'<br>';
	
	$GBLCOM['GBL_ADMIN_ERROR_STATE'] = "OK";
	if (($TXT == "") || ($TXT == null)){return "";}
	if (strlen($TXT) <= 4 ){$errorcount++; $GBLCOM['GBL_ADMIN_ERROR_STATE'] = "ERR"; $GBLCOM['GBL_ADMIN_ERROR_MESSAGE'] = $errorcount.". Email Too Short\n";} // email_too_short
	if (strpos($TXT, '@', 1 ) === false ){$errorcount++; $GBLCOM['GBL_ADMIN_ERROR_STATE'] = "ERR"; $GBLCOM['GBL_ADMIN_ERROR_MESSAGE'] = $errorcount.". No AT in Email\n";} //email_no_at
//print $local.'='.$domain.'<br>';

	list( $local, $domain ) = explode( '@', $TXT, 2 );// Split out the local and domain parts
	$local = preg_replace( '/[^a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]/', '', $local );
	if ('' === $local){$errorcount++; $GBLCOM['GBL_ADMIN_ERROR_STATE'] = "ERR"; $GBLCOM['GBL_ADMIN_ERROR_MESSAGE'] = $errorcount.". Invalid Email Name\n";} //local_invalid_chars
	$domain = preg_replace( '/\.{2,}/', '', $domain );// Test for sequences of periods
	if ('' === $domain){$errorcount++; $GBLCOM['GBL_ADMIN_ERROR_STATE'] = "ERR"; $GBLCOM['GBL_ADMIN_ERROR_MESSAGE'] = $errorcount.". Email Domain Incorrect\n";} // domain_period_limits
	$subs = explode( '.', $domain );// Split the domain into subs
	// Assume the domain will have at least two subs
	if (2 > count($subs)){$errorcount++; $GBLCOM['GBL_ADMIN_ERROR_STATE'] = "ERR"; $GBLCOM['GBL_ADMIN_ERROR_MESSAGE'] = $errorcount.". Email Domain Extensions Incorrect\n";} //domain_no_periods

	$new_subs = array();// Create an array that will contain valid subs
	// Loop through each sub
	foreach ( $subs as $sub ) 
		{
		// Test for leading and trailing hyphens etc.
		$sub = trim( $sub, " \t\n\r\0\x0B-" );

		// Test for invalid characters etc.
		$sub = preg_replace( '/[^a-z0-9-]+/i', '', $sub );

		// If there's anything left, add it to the valid subs
		if ('' !== $sub){$new_subs[] = $sub;}
		}
	// If there aren't 2 or more valid subs
	if (2 > count($new_subs)){$errorcount++; $GBLCOM['GBL_ADMIN_ERROR_STATE'] = "ERR"; $GBLCOM['GBL_ADMIN_ERROR_MESSAGE'] = $errorcount.". Email Invalid Domain Extensions \n";} //domain_no_valid_subs
	// Join valid subs into the new domain
	$domain = join( '.', $new_subs );
	// Put the email back together
	$email = $local . '@' . $domain;
	
	// Congratulations your email made it!
	if ($GBLCOM['GBL_ADMIN_ERROR_STATE'] == "ERR"){return $TXT;}
	else {return $email;}
	}
else {die("Globel Administrator Wrong boot Filename? The Filename was: ".GBL_ADMIN_MYNAME);}

///return array($a, $b, $c);

}

function GBL_SANITISE_TEXT_FIELD($TXT)
{
global $GBLCOM;
if (GBL_ADMIN_MYNAME == "GlobelWP"){$TXT = sanitize_text_field($TXT);return $TXT;}
elseif (GBL_ADMIN_MYNAME == "index")
	{ /// NOTICE HERE! RETURN ERROR
	// PROCESS TXT
	$TXT = strip_tags($TXT); // strip out any HTML
	$TXT = preg_replace('/\s+/S', " ", $TXT); //replace all multiple white-spaces, tabs and new-lines
	$TXT = preg_replace("/[^a-zA-Z0-9@ \/:._\,-]/", "", $TXT); /// allow only chars, numbers and spaces _ - @ . : /, ............................

	return $TXT;
	}
else {die("Globel Administrator Wrong boot Filename? The Filename was: ".GBL_ADMIN_MYNAME);}
}

function GBL_SANITISE_TEXT_ONLY($TXT)
{
$TXT = strip_tags($TXT); // strip out any HTML
$TXT = preg_replace('/\s+/S', " ", $TXT); //replace all multiple white-spaces, tabs and new-lines
$TXT = preg_replace("/[^a-zA-Z]/", "", $TXT); /// allow only chars
return $TXT;
}

function GBL_SANITISE_NUMBER_ONLY($TXT) 
{
$output ="not again"; 
if ( is_numeric($TXT)){$output=intval( $TXT);}
else {
//add_action( 'admin_notices', 'is not a number!' );
//_e( 'is not a number!' );
}
return $output;
}

function GBL_ADMIN_SENDMAIL($FROM,$TO,$SUBJECT,$MESSAGE,$HEADERS = null)
{
global $GBLCOM;
IF(EMPTY($FROM)) {return;}
IF(EMPTY($SUBJECT)) {return;}
$HEADERS[] = 'From: '.$SUBJECT.' <'.$FROM.'>';

$FROM =	GBL_SANITISE_EMAIL($FROM);
$TO = GBL_SANITISE_EMAIL($TO);
$MESSAGE = GBL_SANITISE_TEXT_FIELD($MESSAGE);
//$HEADERS = sanitize_text_field($HEADERS);

if(GBL_ADMIN_MYNAME == 'GlobelWP') {
remove_filter('wp_mail_from', 'bp_core_email_from_address_filter' );
remove_filter('wp_mail_from_name', 'bp_core_email_from_name_filter');
wp_mail($TO, $SUBJECT, $MESSAGE, $HEADERS, '');} else {
@mail($TO, $SUBJECT, $MESSAGE, implode("\r\n", $HEADERS), '');} 
///print "email sent";

}

function GBL_SET_BOOT_PAGE()
{
global $GBLCOM, $GBLMNUORDER;
if ($GBLCOM['GBL_ADMIN_ACT'] == "gblsaveasfavouritepage")
	{
	$GBLCOM['GBL_ADMIN_BOOT_PAGE'] = $GBLCOM['GBL_ADMIN_PAGE'];
	$GBLCOM['GBL_ADMIN_BOOT_TAB'] = $GBLCOM['GBL_ADMIN_TAB'];
	GBL_SAVE_COMFILE($GBLCOM,"","","GBL_ADMIN_APP_NAME",GBL_ADMIN_APP_NAME,"GBLCOM",GBL_ADMIN_DATA_DIR."/");
	}

	if (($GBLCOM['GBL_ADMIN_TAB'] == $GBLCOM['GBL_ADMIN_BOOT_TAB']) && ($GBLCOM['GBL_ADMIN_PAGE'] == ""))
	{$GBLCOM['GBL_ADMIN_PAGE'] = $GBLCOM['GBL_ADMIN_BOOT_PAGE']; $GBLCOM['GBL_ADMIN_ISBOOTPAGE'] = True;}
	elseif (($GBLCOM['GBL_ADMIN_TAB'] == "") && ($GBLCOM['GBL_ADMIN_PAGE'] == ""))
	{$GBLCOM['GBL_ADMIN_PAGE'] = $GBLCOM['GBL_ADMIN_BOOT_PAGE']; $GBLCOM['GBL_ADMIN_TAB'] = $GBLCOM['GBL_ADMIN_BOOT_TAB']; $GBLCOM['GBL_ADMIN_ISBOOTPAGE'] = True;}

	if (($GBLCOM['GBL_ADMIN_PAGE'] == $GBLCOM['GBL_ADMIN_BOOT_PAGE']) && ($GBLCOM['GBL_ADMIN_BOOT_PAGE'] != "") &&
		($GBLCOM['GBL_ADMIN_BOOT_TAB'] == $GBLCOM['GBL_ADMIN_TAB']) && ($GBLCOM['GBL_ADMIN_TAB'] != "")){$GBLCOM['GBL_ADMIN_ISBOOTPAGE'] = True;}
	elseif (($GBLCOM['GBL_ADMIN_BOOT_TAB'] == $GBLCOM['GBL_ADMIN_TAB']) && ($GBLCOM['GBL_ADMIN_BOOT_PAGE'] == "")){$GBLCOM['GBL_ADMIN_ISBOOTPAGE'] = True;}
	else {$GBLCOM['GBL_ADMIN_ISBOOTPAGE'] = false;}
}


Function GBL_GET_SCRIPT_HEADER()
{
$RETURN_OUTPUT = "";
$RETURN_OUTPUT .= <<<RETURN_OUTPUT
<?php
//Globel Administrator Library File
// Exit if file accessed directly
global \$GBLCOM;
defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
RETURN_OUTPUT;
return $RETURN_OUTPUT;
}

Function GBL_GET_SCRIPT_FOOTER()
{
$RETURN_OUTPUT = "";
$RETURN_OUTPUT .= <<<RETURN_OUTPUT


?>
RETURN_OUTPUT;
return $RETURN_OUTPUT;
}

/****************************** LUKE BUILD ******************************
BASIC - GBL_CREATE_HTML(type=, name=, value=, style=, placeholder=, min=, max=)
-------------------------- TYPES --------------------------
[MIN] TEXTAREA - GBL_CREATE_HTML('textarea', 'example_1', '', '', '', '', '')
[MAX] TEXTAREA - GBL_CREATE_HTML('textarea', 'example_1', 'default value', 'background: blue;', 'example 1')

[MIN] TEXT - GBL_CREATE_HTML('text', 'example_2', '', '', '', '', '')
[MAX] TEXT - GBL_CREATE_HTML('text', 'example_2', 'default value', 'background: blue;', 'example 2')

[MIN] NUMBER - GBL_CREATE_HTML('number', 'example_3', '', '', '', '', '')
[MAX] NUMBER - GBL_CREATE_HTML('number', 'example_3', 'default value', 'style', 'example 3', 'min value', 'max value')

[MIN] SELECT - GBL_CREATE_HTML('select', 'example_4', '', '', '', '', '')
[MAX] SELECT - GBL_CREATE_HTML('select', 'example_4', array('option 1', 'option 2', 'option 3'), 'style', 'example 4')
GBL_CREATE_HTML('select', 'example_4', 'asas', 'min=gyugh max=ji plasc=oo');
GBL_CREATE_HTML('text', 'example_4', 'asas', "", array('option 1', 'option 2', 'option 3'), 'style', 'example 4'));
## KEY ##
[MIN] - Minimum keys required for the f ield to work.
[MAX] - All the additional fields are listed after the [MIN] keys that are optional to the user.
*/
function GBL_CREATE_HTML($TYPE, $NAME, $VALUE, $ADDITIONAL, $SELECTED = null) {
	
	$DEFAULTOUT = "";
	
	if($TYPE !== ''&$NAME !== ''&!is_array($ADDITIONAL)&!is_array($TYPE)&!is_array($NAME)) {
		if(is_array($VALUE)) {
			switch($TYPE) {
				case 'select':
				foreach($VALUE as $DEFAULTDATA) 
					{
					if ($DEFAULTDATA == $SELECTED)
						{
						$DEFAULTOUT .= '<option selected>'.$DEFAULTDATA.'</option>'; 	
							
						}
					else {$DEFAULTOUT .= '<option>'.$DEFAULTDATA.'</option>'; }
					}
				return '<select name="'.$NAME.'" '.$ADDITIONAL.'>'.$DEFAULTOUT.'</select>';
			}
		} else {
			switch($TYPE) {
				case in_array($TYPE, array('button', 'checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month', 'number', 'password', 'radio', 'range', 'reset', 'search', 'submit', 'tel', 'text', 'time', 'url', 'week')):
				return '<input type="'.$TYPE.'" name="'.$NAME.'" value="'.$VALUE.'" '.$ADDITIONAL.'>';
				
				case 'textarea':
				return '<textarea name="'.$NAME.'" '.$ADDITIONAL.'>'.$VALUE.'</textarea>';
			}
		}
		return 'No field with name: <b>'.$TYPE.'</b> found.';
	} else {
		return '$TYPE and $NAME cannot be empty and cannot be array/s.';
	}
}

function GBL_SAVE_COMFILE($COMARRAY,$FKEY,$FVAL,$LKEY,$LVAL,$ANAME,$FDIR)
{
//PRINT "BLANK";
/*
$COMARRAY = ARRAY TO BUILD
$FKEY = FIRST KEY TO ADD TO ARRAY
$FVAL = FIRST VALUE TO ADD TO ARRAY
$LKEY = LAST KEY TO ADD TO ARRAY
$LVAL = FIRST VALUE TO ADD TO ARRAY
$ANAME = ARRAY NAME WILL ALSO BE ARRAY FILE NAME
$FDIR = FILE DIR TO SAVE TO
*/
global $GBLCOM;
$success = false;
$arraytext = ""; 
$COMFILE = "";
$HEADER = GBL_GET_SCRIPT_HEADER();
if (empty($COMARRAY)){$COMARRAY = array("EMPTY_NAME" => "NULL");}// IF NULL CREATE EMPTY ARRAY#
///last and first key removed as save by whole now
/// change to GBL_ADMIN_COMFILE_IGNORELIST
$GBLCOM["GBL_ADMIN_GBLCOM_IGNORE"] = preg_replace('/\s+/S', "", $GBLCOM["GBL_ADMIN_GBLCOM_IGNORE"]); //replace all multiple white-spaces, tabs and newlines
$GBLCOM["GBL_ADMIN_GBLCOM_IGNORE"]  = str_replace( ",,", ",",$GBLCOM["GBL_ADMIN_GBLCOM_IGNORE"] ); /// clean out double comma
$GBL_ADMIN_GBLCOM_IGNORE = explode(",",$GBLCOM['GBL_ADMIN_GBLCOM_IGNORE']);
foreach($GBL_ADMIN_GBLCOM_IGNORE as $key => $value)
	{
	if (array_key_exists($value,$COMARRAY)){unset($COMARRAY[$value]);} // REMOVE IGNORE ITEMS
	}
$arraytext = var_export($COMARRAY, true); 

$COMFILE.= <<<COMFILE
$HEADER

\$$ANAME = $arraytext

?>
COMFILE;
if ($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes"){GBL_BACKUP($FDIR."/",$ANAME.".PHP");}

//PRINT $COMFILE;

if (GBL_SAVE_FILE_CONTENTS($FDIR."/".$ANAME.'.PHP', $COMFILE)){$success = true;}else {$success = false;};
return $success;
}

function GBL_NOTIFICATION($message, $backgroundcolor, $textcolor, $timefade)
{
$message = str_replace('\'', '', $message);
if($timefade !== 0) 
 {
 $timefade = $timefade * 1000;
return <<<data
<script>
jQuery("#Notification").html("<p style='background-color: $backgroundcolor; color: $textcolor;'><b>$message</b></p>").fadeIn('slow').animate({opacity: 1.0}, $timefade).fadeOut('slow');
</script>
data;
 }
else {
return <<<data
<script>
jQuery("#Notification").html('<p style="background-color: $backgroundcolor; color: $textcolor;"><b>$message</b></p>');
</script>
data;
 }
}

function GBL_LOCAL_GET_SIDENAV_TABS($selectedTAB,$selectedPAGE,$commonlink)
{
global $GBLCOM, $GBLMNUORDER;
if ($selectedTAB == "dashboard"){$sideNav = ""; return $sideNav;} /// escape if dashboard
else{$buildMNU = false;}

//if (FILE_EXISTS(GBL_ADMIN_USER_PERMISSIONS_DIR."/".$GBLCOM['GBL_WORDPRESS_USER']))
//{include GBL_ADMIN_USER_PERMISSIONS_DIR."/".$GBLCOM['GBL_WORDPRESS_USER']; }

$scandir = GBL_ADMIN_EXTENSIONS_DIR."/".$selectedTAB."/";
$files = scandir($scandir);
########################################################
if (file_exists($scandir."GBLMNUORDER.LIB.PHP")){include_once($scandir."GBLMNUORDER.LIB.PHP");}
else{$GBLMNUORDER["temp_fix"] = "NULL";$buildMNU = true;}
// remove foreach and do search...........
foreach ($files as $fileinfo)
	{
	//$count = 0;
    if ($fileinfo != "." && $fileinfo != "..")
    	{
		if ((strpos($fileinfo, ".mnu.php") !== false) || (strpos($fileinfo, ".hdr.php") !== false) || (strpos($fileinfo, ".ftr.php") !== false))
			{
			$fileinfo = str_replace(".php","",$fileinfo);
			if ((is_array($GBLMNUORDER)) && (!in_array($fileinfo,$GBLMNUORDER)))
				{	
				$GBLMNUORDER[] = $fileinfo;
				$buildMNU = true;
				}
			}	
		}
	}
$builtmnu = "";
$firstpage = "";

if ((is_array($GBLMNUORDER)))
	{
	ksort($GBLMNUORDER,SORT_REGULAR);}
$Lastkey = GBL_GET_LASTKEY($GBLMNUORDER);
$sideNav = '<ul id="SideNavMenu" class="SideNavMenu">';
//$sideNav .= '<li><BR><BR><BR><BR><HR></li>';
$sideNav .= '<div class="menuadvertisement"><BR><BR><BR><BR></div><HR>';


$IMAGESTYLE = "\n".'<style type="text/css">'."\n";

foreach($GBLMNUORDER as $key => $value)
	{
	if (file_exists($scandir.$value.".php"))
		{
		if ((strpos($value, ".mnu") !== false) || (strpos($value, ".ftr") !== false))
			{
			$builtmnu .= '"'.$key.'" => "'.$value.'",'."\n";
			$value = str_replace(".ftr","",$value);
			$value = str_replace(".mnu","",$value);
			$Tab = ucwords($selectedTAB);
			$Arrayname = $value;//
			$words = str_replace("_"," ",$value);
			$image = $scandir.$value.".png";
			
			if(isset(${"$Tab"}))
				{
				$TabArray = ${"$Tab"}; 
				if(isset($TabArray[$Arrayname]))
					{
					
					$Perms = $TabArray[$Arrayname];
					}
					// Notices perms not set for page etc.
				}
			else {$Perms = "1";}
			
			if ($Perms == "1")
				{
				if (FILE_EXISTS($image))
					{
					$GBL_MY_IMAGE = GBL_ADMIN_BASEURI_MYPATH."/Extension/".basename($scandir)."/".$value.".png";
					$imageinsert = '<img alt="'.$value.'" height="16" width="16" style="float: left" src="'.$GBL_MY_IMAGE.'" />';
					$IMAGESTYLE .= 'li.'.$value.' {';
					$IMAGESTYLE .= 'background: url(‘'.$GBL_MY_IMAGE.'’) no-repeat left top; height: 16px; padding-left: 1px; padding-top: 1px;}'."\n";

					}
				else 
					{
					$GBL_MY_IMAGE = GBL_ADMIN_BASEURI_MYPATH."/Extension/_includes/default.png";
					$imageinsert = '<img alt="default" height="16" width="16" style="float: left" src="'.$GBL_MY_IMAGE.'" />';
					$IMAGESTYLE .= 'li.linedefault {';
					$IMAGESTYLE .= 'background: url(‘'.$GBL_MY_IMAGE.'’) no-repeat left top; height: 1px; padding-left: 1px; padding-top: 1px;}'."\n";
					}
				$sideNav .= '     <li id=”linedefault”>'.'<a class=”linedefault” href="'.$commonlink.'&gblpage='.$value.'">'.ucwords($words).'</a></li>'."\n";
				/**/
				
				}
			}
		elseif (strpos($value, ".hdr") !== false)
			{
			$builtmnu .= '"'.$key.'" => "'.$value.'",'."\n";
			$value = str_replace(".hdr","",$value);
			$words = str_replace("_"," ",$value);
			$sideNav .= '     <li><BR><div style="color: #39F; font-weight: bold; text-align:center;">'.ucwords($words).'</div><BR></li>'."\n";
			}
			
		}
		else {unset($GBLMNUORDER[$key]); $buildMNU = true;}
	}
if(isset($GBLCOM["GBL_ADMIN_BOOT_MENU"])){$sideNav .= $GBLCOM["GBL_ADMIN_BOOT_MENU"];}

if ($GBLCOM['GBL_ADMIN_TAB'] != "dashboard")
	{
	$sideNav .= '<li><BR><div style="color: #39F; font-weight: bold; text-align:center;">'.'Panel Version: '.GBL_ADMIN_VERSION;
	$sideNav .= '</div><BR></li>'."\n ";// 
	}
$sideNav .= '</ul>';


$IMAGESTYLE .= '</style>'."\n";

//if ($buildMNU){GBL_BUILD_MENU($builtmnu,$scandir);}
$find = '&gblpage='.$selectedPAGE.'">';
$replace = '&gblpage='.$selectedPAGE.'" class="active">';
$sideNav = str_replace ($find,$replace,$sideNav);

return $IMAGESTYLE.$sideNav;
}

function GBL_ADMIN_ADDTO_GBLCOM_IGNORE($IGNORE)
{
global $GBLCOM;
if (strpos($GBLCOM['GBL_ADMIN_GBLCOM_IGNORE'], $IGNORE) === false){$GBLCOM['GBL_ADMIN_GBLCOM_IGNORE'] .= ','.$IGNORE; return true;}
else {return false;}
}

function GBL_BUILD_MENU($builtmnu,$DIR)
{
global $GBLCOM;
$PHPfile = "";
$PHPfile.= <<<PHPFILE1
<?php
//Globel Administrator Library File
// Exit if file accessed directly
global \$GBLCOM, \$GBLMNUORDER;
global \$GBLCOM;
defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
\$GBLMNUORDER = array(
$builtmnu
);
?>

PHPFILE1;
if ($GBLCOM["GBL_ADMIN_SAVE_BACKUPS"] == "yes"){GBL_BACKUP($DIR,"GBLMNUORDER.LIB.PHP");} 
GBL_SAVE_FILE_CONTENTS($DIR."GBLMNUORDER.LIB.PHP", $PHPfile);
}

# Highlight PAGE

function GBL_GET_LASTKEY($gblarray){if ((is_array($gblarray))){end($gblarray);return key($gblarray);}}
#################################################################

function GBL_BACKUP($GBL_PATH, $GBL_FILE)
{
// function to save file backups / revisions in order with date and time stamp!
global $GBLCOM;
$maxfiles = "10000";

$GBL_SRCFILE = $GBL_PATH."/".$GBL_FILE;
$GBL_SRCFILE = str_replace( '///', '/',$GBL_SRCFILE); // remove triple slash
$GBL_SRCFILE = str_replace( '//', '/',$GBL_SRCFILE);  // remove D slash
$digitlen = strlen($maxfiles); // get max number
$digits = str_repeat("0", $digitlen); // set number of digits all zero
/**/
$GLOBPath = $GBL_SRCFILE.'.BK*';
$MyFiles = glob($GLOBPath);
$MyFiles = array_map('basename',$MyFiles);
$MyFile = end($MyFiles); // GET LAST BACKUP REVISION
$MyFile = preg_replace('/\s+/S', "", $MyFile); //replace all multiple white-spaces, tabs and new-lines
if ($MyFile != "")
	{
	list( $waste, $lastnumber ) = explode( '.BK', $MyFile); // get number	
	///$lastnumber = $lastnumber.".33633"; // test whole number just in case
	$lastnumber = intval($lastnumber); // get whole number	
	}
else {$lastnumber = "B";}

if (is_integer($lastnumber)){$RevStart = $lastnumber;} // start at last file
else{$RevStart = "1";} // no files exist then start at 1

// DO IF FILES > MAXFILES 
// DO notice maxfiles reached either delete old files or archive system

//print $RevStart.'<br><br>';
//print $MyFile.'<br><br>';
//print_r($MyFiles).'<br><br>';
//exit;

// THIS SAVES REVISIONS OF FILES
if ((FILE_EXISTS($GBL_SRCFILE)) && ($GBLCOM['GBL_ADMIN_SAVE_BACKUPS'] == "yes"))
	{
	$i = $RevStart;
	while ($i <= $maxfiles)
		{
		$len = strlen($i); // get len of count
		$digits = substr($digits, 0, -$len);
		$digits = $digits.$i;
		$GBL_DESTINATION = $GBL_PATH."/".$GBL_FILE.".BK".$digits;
		if (FILE_EXISTS($GBL_DESTINATION) == false){copy($GBL_SRCFILE, $GBL_DESTINATION); break;}
		$i++;
		}
	}
}

function GBL_CHECKCREATE_STOPFILE($FILE)
{
$FILE = str_replace('//', '/',$FILE);
$PHPFILE2 = "";
$HEADER = GBL_GET_SCRIPT_HEADER();
$PHPFILE2.= <<<PHPFILE2
$HEADER


?>
PHPFILE2;
file_put_contents($FILE, $PHPFILE2);
//if (){return true;}
//else {return false;}
//GBL_SAVE_FILE_CONTENTS($FILE, $PHPFILE2);

}

#################################################################
function GBL_LOCAL_GET_TOPNAV_TABS($commonlink)
{
global $GBLCOM;

$scandir = GBL_ADMIN_EXTENSIONS_DIR."/";
$dirs = scandir($scandir);
$mainNav = '<ul id="TopNavMenu">'; //mainNav
if ($GBLCOM["GBL_ADMIN_DASHBOARD"] == "on"){$mainNav .= '     <li><a href="'.$commonlink.'&gbltab=dashboard">DASHBOARD</a></li>'."\n";}
$GBL_MY_IMAGE = "";

//if (FILE_EXISTS(GBL_ADMIN_USER_PERMISSIONS_DIR."/".$GBLCOM['GBL_WORDPRESS_USER']))
//{include GBL_ADMIN_USER_PERMISSIONS_DIR."/".$GBLCOM['GBL_WORDPRESS_USER']; }

foreach ($dirs as $fileinfo)
	{
    if (is_dir($scandir.$fileinfo) && $fileinfo != "." && $fileinfo != ".." && strpos($fileinfo, "_") === false)
    	{
		$Arrayname = ucwords($fileinfo);
		if(isset(${"$Arrayname"})){$TabArray = ${"$Arrayname"}; $Perms = $TabArray[$Arrayname];} //
		else {$Perms = "1";}
		if ($Perms == "1")
			{
			$image = $scandir.$fileinfo.'/'.$fileinfo.".png";
			if (FILE_EXISTS($image))
				{
				$GBL_MY_IMAGE = GBL_ADMIN_BASEURI_MYPATH."/Extension/".$fileinfo."/".$fileinfo.".png";
				$imageinsert = '<img alt="'.$fileinfo.'" height="25" width="25" style="float: left" src="'.$GBL_MY_IMAGE.'" />';
				}else {$imageinsert = "";}
				
			$TABTitle = strtoupper(str_replace('-', ' ', $fileinfo));
			$mainNav .= '     <li>'.'<a href="'.$commonlink.'&gbltab='.$fileinfo.'">'.$imageinsert.' '.$TABTitle.'</a></li>'."\n";
			}
   		}
	}
if ($GBLCOM['GBL_ADMIN_LOGOFF_TAB']){$mainNav .= '     <li>'.'<a href="'.$commonlink.'&gbltab=logoff&gblcmd=logoff">LOG OFF</a></li>'."\n";}

$mainNav .= '</ul>';
# Highlight TAB
$selectedTAB = $GBLCOM['GBL_ADMIN_TAB']; 
$selectedPAGE = $GBLCOM['GBL_ADMIN_PAGE'];
if ($selectedTAB == ""){$selectedTAB = "dashboard";}
$find = '&gbltab='.$selectedTAB.'">';
$replace = '&gbltab='.$selectedTAB.'" class="active">';
$mainNav = str_replace ($find,$replace,$mainNav);

return $mainNav;
}

function GBL_CREATE_RAND($len)
{
global $GBLCOM;
if ($len == ""){echo "Could not create rand!"; exit;}
$randomnum = "";
$base="ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789";
$max=strlen($base)-1;
mt_srand((double)microtime()*1000000);
while (strlen($randomnum)<$len)$randomnum.=$base{mt_rand(0,$max)};
return $randomnum;	
}

function GBL_CHECK_CLEAR_AGED_USER_TRACKING()
{
global $GBLCOM;
//print "here";
//$GBLCOM['GBL_ADMIN_LOGON_TIMEOUT'] = 1;
//$GBLCOM['GBL_ADMIN_LOGON_TIMEOUT_PERIOD'] = "hours";
//minutes hours days weeks months
// IF FILE LIFE 0 THEN NEVER DELETE FILE & EXIT
if ($GBLCOM['GBL_ADMIN_LOGON_TIMEOUT'] > 0)
	{
	//print "here";
	if ($GBLCOM['GBL_ADMIN_LOGON_TIMEOUT_PERIOD'] == "minutes"){$filelife = $GBLCOM['GBL_ADMIN_LOGON_TIMEOUT'] * 60;}//life allowed of file in mins
	elseif ($GBLCOM['GBL_ADMIN_LOGON_TIMEOUT_PERIOD'] == "hours"){$filelife = $GBLCOM['GBL_ADMIN_LOGON_TIMEOUT'] * 60 * 60;}
	elseif ($GBLCOM['GBL_ADMIN_LOGON_TIMEOUT_PERIOD'] == "days"){$filelife = $GBLCOM['GBL_ADMIN_LOGON_TIMEOUT'] * 60 * 60 * 24;}
	elseif ($GBLCOM['GBL_ADMIN_LOGON_TIMEOUT_PERIOD'] == "weeks"){$filelife = $GBLCOM['GBL_ADMIN_LOGON_TIMEOUT'] * 60 * 60 * 24 * 7;}
	elseif ($GBLCOM['GBL_ADMIN_LOGON_TIMEOUT_PERIOD'] == "months"){$filelife = $GBLCOM['GBL_ADMIN_LOGON_TIMEOUT'] * 60 * 60 * 24 * 7 * 30;}
	else {$filelife = 1 * 60 * 60 * 24 * 7;}// preset week
	$filecount =0;
	$fileage =0;
	$filecountmax = 3; /// delete max 5 files
	$epochNOW = time();
	$filepath = GBL_ADMIN_USER_ONLINE_FILES.'/';
	$trackingfiles = scandir($filepath);

	foreach ($trackingfiles as $filename)
		{
		if (is_file ($filepath.$filename))
			{
			$filetime = filemtime ($filepath.$filename);
			$fileage = $filetime + $filelife;
			
			IF ($filecount >= $filecountmax){break;}
			if ($fileage <= $epochNOW)
				{
				unlink($filepath.$filename);
				$filecount - 1;
				}
			elseif($fileage > $epochNOW)
				{

				}
			$filecount++;
			}
		}	
	}
}

function GBL_ADMIN_CHECK_REGISTRATION()
{
global $GBLCOM;
$fields_string = "gblcmd=checkregistered&gbltkn=".$GBLCOM['GBL_ADMIN_NET_TOKEN'];
$result = GBL_SENDTO_CURL(GBL_ADMIN_REPOSITORY, $fields_string);
list($LEVEL, $KEY) = explode("=", $result);
//print $LEVEL."<br>";
if ($GBLCOM['GBL_ADMIN_REG_LEVEL'] != $LEVEL)
	{
	$GBLCOM['GBL_ADMIN_REG_LEVEL'] = $LEVEL;
	GBL_SAVE_COMFILE($GBLCOM,"","","","","GBLCOM",GBL_ADMIN_DATA_DIR."/"); /// save advanced contact ID number
	RETURN TRUE;
	}
ELSE {RETURN FALSE;}
}


function GBL_SENDTO_CURL($target, $data)
{
global $GBLCOM;
$GBLcurl = curl_init();
curl_setopt($GBLcurl,CURLOPT_TIMEOUT, 5);
curl_setopt($GBLcurl,CURLOPT_URL, $target);
curl_setopt($GBLcurl,CURLOPT_POST, count($data));
curl_setopt($GBLcurl,CURLOPT_POSTFIELDS, $data);
curl_setopt($GBLcurl, CURLOPT_RETURNTRANSFER, true); // stop result display echo!
$GBL_RESULT = curl_exec($GBLcurl);

/* IF CURL ERROR
if (curl_errno($GBLcurl)) 
	{
	$GBL_RESULT = "ERR=10003";
	}///$GBL_RESULT = "ERR=".curl_error($GBLcurl);
*/
curl_close($GBLcurl);
return $GBL_RESULT;
}

?>
