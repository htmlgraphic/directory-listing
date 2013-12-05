<?php
session_start();

/*
        $db_host                = "mysql.htmlgraphic.com";
        $db_user                = "dl_oads";
        $db_password            = "xpasdf23";
        $db_name                = "htmlgraphic_com";
*/

#$dbconn = mysql_connect($db_host,$db_user,$db_password) or die ("Error: could not connect to the database");
#mysql_select_db($db_name,$dbconn) or die ("Error: Could not select database");

// $hostID is a variable set by each download server to continue to read
// the correct data directory after a sync. It also keeps important variables
// with sensitive information secure.

// 1 = advance
// 2 = dart
$hostID = 1;

if ($hostID == 1) {
        define(DATA_ROOT,'/home/gege/VIDEOS');
} elseif ($hostID == 2) {
        define(DATA_ROOT,'/home/cheap_rsync2/downloads.htmlgraphic.com/downloads/data/downloads');
}

$public_dir = "media";
?>
