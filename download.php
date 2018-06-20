<?php 
if (isset($_REQUEST['GLOBALS']) OR isset($_REQUEST['absoluteurl']) OR isset($_REQUEST['amilogged']) OR isset($_REQUEST['theme_path'])) { exit; } 
include("config.php");
include($absoluteurl."core/functions.php");
$filename = $_GET['filename'];
$filename = str_replace("/", "", $filename); // Replace / in the filename 
$filename = str_replace("\\", "", $filename); // Replace \ in the filename
$filename_path = $absoluteurl.$upload_dir.$filename; // absolute path of the filename to download
if (file_exists($filename_path) ) {
	$file_media = divideFilenameFromExtension($filename);
	$fileData = checkFileType($file_media[1],$absoluteurl);
	$podcast_filetype=$fileData[0];
	$filemimetype=$fileData[1];
	$isFileSupported = $fileData[2];
	if ($isFileSupported == TRUE AND $file_media[1]==$podcast_filetype AND !publishInFuture($filename_path)) {
		if(ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off');
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: $filemimetype");
		header("Content-Disposition: attachment; filename=".basename($filename_path).";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($filename_path));
		readfile("$filename_path");
		exit();	
	}
}

?>