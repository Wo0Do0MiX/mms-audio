<?php
header('Content-type: application/xml');
ob_start(); 
if (isset($_REQUEST['GLOBALS']) OR isset($_REQUEST['absoluteurl']) OR isset($_REQUEST['amilogged']) OR isset($_REQUEST['theme_path'])) { exit; } 

include("core/includes.php"); 

$ShowCategory = NULL;
if (isset($_GET['cat']) AND $_GET['cat'] != NULL) {
$ShowCategory = avoidXSS($_GET['cat']);
}

generatePodcastFeed(FALSE,$ShowCategory,FALSE);

ob_end_flush();

?>