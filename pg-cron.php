<?php
if (isset($_REQUEST['GLOBALS']) OR isset($_REQUEST['absoluteurl']) OR isset($_REQUEST['amilogged']) OR isset($_REQUEST['theme_path'])) { exit; } 
ob_start(); 
$startTime = time();
if (!isset($absoluteurl)) { 
	include("core/includes.php"); 
	if (!isset($_GET["key"]) OR isset($_GET["key"]) AND $_GET["key"] != $installationKey) {
	exit;
	} 
$includedInIndexPHP = FALSE;
} 
else {
$includedInIndexPHP = TRUE; 
}

if (isset($cronAutoIndex) AND $cronAutoIndex == TRUE AND $includedInIndexPHP == FALSE) {
	
	$episodesCounter = autoIndexingEpisodes();
	
	if ($episodesCounter > 0 AND $includedInIndexPHP == FALSE) {
	generatePodcastFeed(TRUE,NULL,FALSE);
	echo ' -- '.$episodesCounter.' '._("додаден нов аудио фаил"); 
	}
	
}

if (isset($cronAutoRegenerateRSS) AND $cronAutoRegenerateRSS == TRUE) {
	if ($includedInIndexPHP == TRUE) {
		$RSSFeedURL = $absoluteurl.$feed_dir."feed.xml";
		$lastRSSFeedBuild = NULL;
		if (file_exists($RSSFeedURL)) {
		$lastRSSFeedBuild = filemtime($RSSFeedURL);
		}
		if (isset($cronAutoRegenerateRSScacheTime) AND time() - $lastRSSFeedBuild > $cronAutoRegenerateRSScacheTime)  {
			$episodesinFeedCounter = generatePodcastFeed(TRUE,NULL,FALSE);
		}
	}
	else {
	$episodesinFeedCounter = generatePodcastFeed(TRUE,NULL,FALSE);
		if ($episodesinFeedCounter > 0 AND $includedInIndexPHP == FALSE) {
		echo ' -- '._("RSS:").' '.$episodesinFeedCounter.' '._("аудио фаилови");
		}
	}
	

}

	if ($includedInIndexPHP == FALSE) {
		$tempusFugit=time()-$startTime;
		echo ' -- '._("Време на извршување (секунди):").' '.$tempusFugit; 
	}


ob_end_flush();
	
?>