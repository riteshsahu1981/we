<?php 
	$dir    = 'listing_images';
	$files 	= scandir($dir);
	echo "Total Files: ".count($files);
	echo "<br /><br />File Names: <br /><br />";
//	foreach($files as $k=>$v) {
//		echo $v."<br />";
//	}
?>