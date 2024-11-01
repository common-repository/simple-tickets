<?php
/*
Globel Administrator Library File
*/
// Exit if file accessed directly ///
global $GBLCOM;

defined('GBL_ADMIN_RUNNING_STATE') or die('Forbidden Includes Function For file: '.pathinfo(__FILE__, PATHINFO_FILENAME));
////////////////////////////////////
$path1 = "";
$path2 = "";
$htmlheader = "";
$htmlfooter = "";

if ($GBLCOM['GBL_ADMIN_TAB'] == "")
	{
	$path1 = GBL_ADMIN_EXTENSIONS_DIR."/".$GBLCOM['GBL_ADMIN_BOOT_TAB']."/";
	if (is_dir($path1))
		{
		$GBLCOM['GBL_ADMIN_TAB'] = $GBLCOM['GBL_ADMIN_BOOT_TAB'];
		if ($GBLCOM['GBL_ADMIN_PAGE'] == "")
			{
			$path1 = GBL_ADMIN_EXTENSIONS_DIR."/".$GBLCOM['GBL_ADMIN_TAB']."/".$GBLCOM['GBL_ADMIN_BOOT_PAGE'].".ftr.php";
			$path2 = GBL_ADMIN_EXTENSIONS_DIR."/".$GBLCOM['GBL_ADMIN_TAB']."/".$GBLCOM['GBL_ADMIN_BOOT_PAGE'].".mnu.php";
			if ((FILE_EXISTS($path1)) || (FILE_EXISTS($path2)))
				{
				$GBLCOM['GBL_ADMIN_PAGE'] = $GBLCOM['GBL_ADMIN_BOOT_PAGE'];
				}
			else {$GBLCOM['GBL_ADMIN_BOOT_PAGE'] = ""; $GBLCOM['GBL_ADMIN_PAGE'] = "";}
			}
		}
	else {$GBLCOM['GBL_ADMIN_BOOT_TAB'] = ""; $GBLCOM['GBL_ADMIN_TAB'] = "";}
	}

//$GBL_MY_CSS = GBL_ADMIN_BASEURI_MYPATH."/Themes/'.$GBLCOM['GBL_ADMIN_THEME'].'/css";
$content = "";

if ($GBLCOM["GBL_ADMIN_HEADER"] == "on"){$PAGEheader = '';} // REM FOR WORDPRESS
else {$PAGEheader = "";}

if ($GBLCOM["GBL_ADMIN_FOOTER"] == "on"){$PAGEfooter = '';} // REM FOR WORDPRESS
else {$PAGEfooter = "";}

$output = "";
$selectedTAB = $GBLCOM['GBL_ADMIN_TAB']; 
$selectedPAGE = $GBLCOM['GBL_ADMIN_PAGE'];
$path1 = "";
$path2 = "";


/// get content page
if ($GBLCOM['GBL_ADMIN_PAGE'] != "")
	{
	$path1 = GBL_ADMIN_EXTENSIONS_DIR."/".$GBLCOM['GBL_ADMIN_TAB']."/".$GBLCOM['GBL_ADMIN_PAGE'].".mnu.php";
	$path2 = GBL_ADMIN_EXTENSIONS_DIR."/".$GBLCOM['GBL_ADMIN_TAB']."/".$GBLCOM['GBL_ADMIN_PAGE'].".ftr.php";
	}
elseif (($GBLCOM['GBL_ADMIN_TAB'] != "") && ($GBLCOM['GBL_ADMIN_TAB'] != "dashboard")){$path1 = GBL_ADMIN_EXTENSIONS_DIR."/".$GBLCOM['GBL_ADMIN_TAB']."/".$GBLCOM['GBL_ADMIN_TAB'].".php";}
elseif ($GBLCOM['GBL_ADMIN_TAB'] == "dashboard"){$path1 = GBL_ADMIN_THEMES_DIR.'/dashboard.php';}
else {$path1 = GBL_ADMIN_THEMES_DIR.'/blankpage.php';}
if (FILE_EXISTS($path1)){include_once($path1);}
elseif (FILE_EXISTS($path2)){include_once($path2);}
//print $path1.'<BR>';
//print $path2.'<BR>';
// TIMER
//for ($i=0; $i <= 10; $i++) {
//    if ($content == ""){sleep(1);}
//	else {break;}
//}


$selectedTAB = $GBLCOM['GBL_ADMIN_TAB'];
$selectedPAGE = $GBLCOM['GBL_ADMIN_PAGE'];

### START MAIN NAV
$commonlink = "?";
if (GBL_ADMIN_MYNAME == "GlobelWP"){$commonlink .= "_wpnonce=".$GBLCOM['GBL_ADMIN_KEEP_TRACK']."&page=".GBL_WORDPRESS_ADMIN.'&';}//
elseif (GBL_ADMIN_MYNAME == "index"){$commonlink .= "gbltrk=".$GBLCOM['GBL_ADMIN_KEEP_TRACK'];}
$commonlink .= "&gblcmd=admin";
$mainNav = GBL_LOCAL_GET_TOPNAV_TABS($commonlink);
$commonlink = $commonlink."&gbltab=".$selectedTAB;
### END MAIN NAV

### START SIDE NAV
$sideNav = GBL_LOCAL_GET_SIDENAV_TABS($selectedTAB,$selectedPAGE,$commonlink);
### END SIDE NAV
/// ################### HACK
$GBL_MY_CSS = GBL_ADMIN_BASEURI_MYPATH.'/Themes/'.$GBLCOM['GBL_ADMIN_THEME'].'/css/GBLadmin.css';

if (GBL_ADMIN_MYNAME == "index")
	{
		

		
$htmlheader .= <<<HTMLHEADER
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="pragma" content="no-cache" />
<title>Free Counters Admin</title>
</head>
<body> 
	<!-- CSS -->
	<link href="$GBL_MY_CSS" rel="stylesheet" type="text/css" media="screen" />
HTMLHEADER;

$htmlfooter .= <<<HTMLFOOTER
</body>
</html>
HTMLFOOTER;

	}
else {$htmlheader = ""; $htmlfooter = "";}

//GBL_ADMIN_WP_STYLE($GBL_MY_CSS.'/GBLadmin.css');
//GBL_ADMIN_INSERT_CSS($GBL_MY_CSS.'/GBLadmin.css');
//	Moved to init.lib.php, Line 73 & 82 - 85

// check for any errors
if (is_array($GBLCOM['GBL_ADMIN_ERRORS'])){$errorcontent = GBL_ADMIN_GET_ERRORS();}
else {$errorcontent = "";}

//////////// INSERT PAGE HEAD AND FOOT
if($GBLCOM['GBL_ADMIN_TAB'] == 'dashboard') {
$output .= <<<ADMIN_OUT
$htmlheader
	<div id="wrapper">
    	$PAGEheader
        <!-- mainNav-->
        $mainNav
        <!-- end mainNav -->
        <div id="containerHolder">
			<div id="container" style="padding: 25px; background: #F6F6F6;">
                <!--  main -->
                <div style="width: 95%; margin: 0 auto; text-align: center;">
				$errorcontent
				$content
                </div>
                <div class="clear"></div>
            </div>
        </div>	
        $PAGEfooter
    </div>
    <!-- wrapper -->
$htmlfooter

ADMIN_OUT;
} 
else 
{
$output .= <<<ADMIN_OUT
$htmlheader
	<div id="wrapper">
    	$PAGEheader
        <!-- mainNav-->
        $mainNav
        <!-- end mainNav -->
        <div id="containerHolder">
			<div id="container">
        		<div id="sidebar">
                <!-- sideNav -->
				
                $sideNav
               <!-- sideNav -->
                </div>    
                <!-- sidebar -->
                <!--  main -->
                <div id="main">
				$errorcontent
				$content
                </div>
                <div class="clear"></div>
            </div>
        </div>	
        $PAGEfooter
    </div>
    <!-- wrapper -->
$htmlfooter
ADMIN_OUT;
}

print $output;
?>
