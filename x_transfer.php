<?php
include("config.inc.php");
//if (isset($_SESSION['rateadmin'])) {
        // Proceed to directory listing.
//}else{
//        header('Location: http://downloads.htmlgraphic.com/');
//}
ini_set("max_execution_time", 4000);

function readfile_chunked($filename,$retbytes=true) {
   $chunksize = 1*(1024*1024); // how many bytes per chunk
   $buffer = '';
   $cnt =0;
   // $handle = fopen($filename, 'rb');
   $handle = fopen($filename, 'rb');
   if ($handle === false) {
       return false;
   }
   while (!feof($handle)) {
       $buffer = fread($handle, $chunksize);
       echo $buffer;
       flush();
       if ($retbytes) {
           $cnt += strlen($buffer);
       }
   }
       $status = fclose($handle);
   if ($retbytes && $status) {
       return $cnt; // return num. bytes delivered like readfile() does.
   }
   return $status;

}


	//$FullPath = $_SERVER['DOCUMENT_ROOT'].$_GET["file"];
	$FullPath = DATA_ROOT.$_GET['file'];
	$File = $_GET["file"];

           $file_extension = strtolower(substr(strrchr($File,"."),1));

           switch ($file_extension) {		   
   			case "asp": $ctype="text/plain"; break;			
			case "avi": $ctype="video/x-msvideo"; break;
			case "doc": $ctype="application/msword"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "gif": $ctype="image/gif"; break;
			case "pdf": $ctype="application/pdf"; break;
			case "png": $ctype="image/png"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "zip": $ctype="application/zip"; break;
			case "mov": $ctype="video/quicktime"; break;
			case "mpeg":
			case "mpg":
			case "mpe": $ctype="video/mpeg"; break;
			case "mp3": $ctype="audio/mpeg"; break;
			case "wav": $ctype="audio/x-wav"; break;
			case "rar": $ctype="application/x-rar-compressed"; break;
			case "tar": $ctype="application/x-tar-gzip"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "nrg": $ctype="application/octet-stream"; break;
			case "js": $ctype="text/plain"; break;
			case "old": $ctype="text/plain"; break;
			case "jpe": case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			default: $ctype="application/force-download";
           }

        if (!file_exists($FullPath)) {
               die("NO FILE HERE");}
	
	if (($File == "/x_transfer.php") || ($File == "/x_index.php") || ($File == "/login.php")) {
               die("NO FILE HERE");}

           header("Pragma: public");
           header("Expires: 0");
           header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
           header("Cache-Control: private",false);
           header("Content-Type: $ctype");
           header("Content-Disposition: attachment; filename=\"".basename($File)."\";");
           header("Content-Transfer-Encoding: binary");
           header("Content-Length: ".@filesize($FullPath));
		set_time_limit(900);
		//readfile("$filename");

		$fp = fopen($FullPath, "rb");
		fseek($fp, 0);
fpassthru($fp);
flush();
		
		#readfile_chunked($FullPath,false);
		
?>
