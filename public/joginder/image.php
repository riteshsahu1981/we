<?php 
ini_set("max_execution_time", 0);

##################################################################################################

$xmlpath="http://localhost/xmlwork/xmlfiles/biens_uk.xml";
$xmlpath="image.xml";
$xml = simplexml_load_file($xmlpath) or die("Unable to load XML file!");
$ctr=0;

//@chmod("public/upload/listing_photos1", 0755);
@chmod("listing_images/", 0777);
foreach($xml->children() as $child)
{

	$image_url=$child->image_url.$child->bimg;
	saveImageToServer($image_url);
}

function saveImageToServer($img,$fullpath='basename'){
	if($fullpath=='basename'){
		$fullpath = basename($img);
	}
	$dir_name	=	"listing_images/";
	$ch = curl_init ($img);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	$rawdata=curl_exec($ch);
	curl_close ($ch);
        
	if(file_exists($dir_name.$fullpath)){
		unlink($dir_name.$fullpath);
	}
	$fp = fopen($dir_name.$fullpath,'x');
	fwrite($fp, $rawdata);
	fclose($fp);
        global $ctr;
        $ctr++;
}

echo "Total $ctr file(s) imported successfully!";
?>