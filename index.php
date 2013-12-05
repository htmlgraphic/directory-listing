<?php
include("config.inc.php");
//if (isset($_SESSION['rateadmin'])) {
//	// Proceed to directory listing.
//}else{
//	header('Location: http://downloads.htmlgraphic.com/');
//}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="HTMLgraphic Designs" />
<meta name="description" content="directory listing" />
<title>Directory Listings of <? echo str_replace("?/","",urlDecode($_SERVER["REQUEST_URI"])); ?> - HTMLgraphic Designs</title>
<?php
$textcolor = "#333";           #TEXT COLOUR
$bgcolor = "#fff";             #PAGE BACKGROUND COLOUR

$normalcolor = "#FFC162";         #TABLE ROW BACKGROUND COLOUR
$normalcolor_alt = "#FFBA53";         #TABLE ROW BACKGROUND COLOUR ALT.
$normalfilecolor = "#e0e0e0";        #TABLE ROW FILE BACKGROUND COLOUR
$normalfilecolor_alt = "#efefef";        #TABLE ROW FILE BACKGROUND COLOUR ALT
$highlightcolor = "#FED595";      #TABLE ROW BACKGROUND COLOUR WHEN HIGHLIGHTED
$headercolor = "#036";        	  #TABLE HEADER BACKGROUND COLOUR
$bordercolor = "#202750";         #TABLE BORDER COLOUR

?>
<style type="text/css" media="screen">
<!--
body {color: <? echo $textcolor; ?>; font: tahoma, small verdana,arial,helvetica,sans-serif; margin: 5px 0px 70px 5px;  background-color: <? echo $bgcolor; ?>;}
table {font-family: tahoma, Verdana; font-size: 10pt; border: 0px;}
.fldrow {background-color: <?=$normalcolor; ?>;}
.fldrow_alt {background-color: <?=$normalcolor_alt; ?>;}
.frow {background-color: <?=$normalfilecolor; ?>;}
.frow_alt {background-color: <?=$normalfilecolor_alt; ?>;}
a:link, a:visited, a:active { color: <? echo $textcolor; ?>;  text-decoration: none;}
a:hover {color: <? echo $textcolor; ?>;  text-decoration: none;}
img {border: 0;}
#bottomborder {border: <? echo $bordercolor;?>;border-style: solid;border-top-width: 0px;border-right-width: 0px;border-bottom-width: 1px;border-left-width: 0px}
.copy {text-align: center; color: <? echo $textcolor; ?>; font-family: tahoma, Verdana, Geneva, sans-serif;  font-size: 7pt; text-decoration: underline;}
th {font-weight: bold; color: #FFFFFF; text-align: left; background-color:#999;}
/* highlighted row colouring */
tr:hover { background-color: <?=$highlightcolor?>; cursor: pointer; cursor: hand;}
.d {text-align: right; white-space: nowrap;}
-->
</style>

<script type="text/javascript">
function alternate(id){
 if(document.getElementsByTagName){  
   var table = document.getElementById(id);  
   var rows = table.getElementsByTagName("tr");  
   for(i = 0; i < rows.length; i++){          
 //manipulate rows
     if(i % 2 == 0){
       rows[i].className = "fldrow";
     }else{
       rows[i].className = "fldrow_alt";
     }      
   }
 }
}

function alternate2(id){
 if(document.getElementsByTagName){
   var table = document.getElementById(id);
   var rows = table.getElementsByTagName("tr");
   for(i = 0; i < rows.length; i++){
 //manipulate rows
     if(i % 2 == 0){
       rows[i].className = "frow";
     }else{
       rows[i].className = "frow_alt";
     }
   }
 }
}

</script>
</head>
<body onload="alternate('dl0');alternate2('dl1');">
<?
function fsize($file) {
          
        //Setup some common file size measurements.
        $kb=1024;
        $mb=1048576;
        $gb=1073741824;
        $tb=1099511627776;
       
        //Get the file size in bytes.
        $size = sprintf("%u",filesize($file));
       
        //Format file size
       
        if($size < $kb) {
        return $size." bytes";
        }
        else if($size < $mb) {
        return round($size/$kb,2)." kB";
        }
        else if($size < $gb) {
        return round($size/$mb,2)." MB";
        }
        else if($size < $tb) {
        return round($size/$gb,2)." GB";
        }
        else {
        return round($size/$tb,2)." TB";
        }
}
?>
<?php 
	//  false - don't allow switching to the parent-directory of this script
	// true - allow simple switching to the parent-directory (via 'href')

	$allow_parent = true;

	//configuration ends here---------------------------------------------------------------------------------------------------------------------------

//=======================================================================================
        $url = str_replace("/","",$_SERVER["REQUEST_URI"]);
        $path = str_replace($public_dir .'?',"",$url);
        $path = urldecode($path);

	$SCRIPT_NAME='';
#	$SCRIPT_NAME=getenv("SCRIPT_NAME");
	//put directory content in arrays-----------------------------------------------------------------------------------------------------------------
	if (!isset($path)) { $path = ""; }
	//if (!file_exists($path)) { echo "<h2>file not found!</h2>"; exit; }
	if (strstr($path,"..")) { echo "<h2>invalid path!</h2>"; exit; }
	$base_dir = getcwd();
	chdir(DATA_ROOT);
	$current_dir = getcwd();
	$directory = dir(DATA_ROOT.$path);	

	$directories_array = array();
	$files_array = array();
	while ($file = $directory->read()) {
		$check_file = DATA_ROOT.$path."/".$file;
		if (is_dir($check_file) AND $file != ".") 	{ 
			$directories_array[] = $file; 
		}
		if (is_file($check_file)) 			{ 
			$files_array[] = $file; 
		}
	}
	$directory->close();
	

	//sort and output the arrays-----------------------------------------------------------------------------------------------------------------------
	echo "<h2>Directory listing for ".basename($current_dir)."</h2>";
	echo "<table id=\"dl0\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"670\">";
	echo "<tr><th>Name</th><th class=\"d\">Date</th></tr>";
	sort($directories_array);
	foreach($directories_array as $value) {
		//if ($value=="..")	{ $new_path=strrev(substr(strstr(substr(strstr(strrev($path),"/"),1),"/"),1)); }
		if ($value=="..")     { 
			//$new_path=substr($path,0,strrpos($path,"/")); 
			$path_data = explode("/", $path);
			if (count($path_data) > 2) {
				$new_path = "";
				//we are > 1 deep
				for ($x = 0; $x < count($path_data)-1; $x++) {
					if ($x > 0) {
						$to_add = "/";
					}
					else {
						$to_add = "";
					}
					$to_add .= $path_data[$x];
					$new_path .= $to_add;
				}
			}
			else {
				$new_path = "";
			}
		}
		else			{ $new_path=$path."/".$value; }

		if (($value != "..") OR ($base_dir != $current_dir)) {
		echo "<tr onclick=\"window.location.href='$SCRIPT_NAME?".rawurlencode($new_path)."';\"><td><a href='$SCRIPT_NAME?".rawurlencode($new_path)."'>$value/</a></td><td class=\"d\">".gmdate("M d Y H:i",filemtime($value))."</td></tr>"; }
//		elseif ($allow_parent == "true") {
//			echo "<tr><td></td><td></td><td>".gmdate("d M Y H:i",filemtime($value))."</td></tr>"; }
	}
	echo "</table>";
	
	echo "<table id=\"dl1\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"670\">";
	echo "<tr><th>Name</th><th>Size</th><th class=\"d\">Date</th></tr>";
	sort($files_array);
	foreach($files_array as $value) {
		if($value != basename($SCRIPT_NAME) or $public_dir!="./") {
		$filesize = fsize($value);
			echo '<tr>';
			echo '<td><a href="/'. $public_dir .'/x_transfer.php?file='. rawurlencode($path. "/" .$value) .'">'. $value .'</a></td>';
			echo '<td nowrap="nowrap">'. $filesize .'</td><td class="d">'. gmdate("M d Y H:i",filemtime($value)) .'</td></tr>';
		}
	}
	echo "</table>";
?>	
<br />
<a href="/" class="copy">Downloadable Directory Listing &copy; HTMLgraphic</a>
<!--
<script>
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-824111-6");
pageTracker._setDomainName(".htmlgraphic.com");
pageTracker._setAllowLinker(true);
pageTracker._setAllowHash(false);
pageTracker._trackPageview();
} catch(err) {}</script>
-->
</body>
</html>

