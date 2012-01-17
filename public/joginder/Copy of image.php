<?php 
ini_set("max_execution_time", 0);

##################################################################################################

//$xml = simplexml_load_file("http://localhost/xmlwork/xmlfiles/biens_uk.xml");
$xmlpath="http://www.rent-villas-france.com/servicespub/rent/biens/uk";
$xmlpath="image.xml";
$xml = simplexml_load_file($xmlpath) or die("Unable to load XML file!");

// Get Images (Start)
	$final_arr = array();
	$image_xml = simplexml_load_file($xmlpath) or die("Unable to load XML file!");
        
	foreach($image_xml->children() as $image_child) {
            
		foreach($image_child as $subchild_image) {
                    
			$tagNameImage = $subchild_image->getName();
			$tagValueImage = trim($subchild_image);
			if($tagNameImage == 'ref') {
				$index = $tagValueImage;
			}
			$final_arr[$index][$tagNameImage] = $tagValueImage;
		}
                print_r($final_arr);exit;
	}
// Get Images (End)
        echo "<pre>";
var_dump($final_arr);
exit;
@chmod("public/upload/listing_photos1", 0755);

foreach($xml->children() as $child)
{
 	
	foreach($child as $subchild) {
		$tagName = $subchild->getName();
		$tagValue = trim($subchild);
		if($tagName == 'ref'){
		 	$data['roi2'] = $tagValue; 
		}else if($tagName == 'nom') {
			$data['title_1'] = $tagValue; 
		}else if($tagName == 'nbchambre'){
			$data['no_bedrooms'] = $tagValue; 	
		}else if($tagName == 'capacite'){
			$data['max_guests'] = $tagValue; 	
		}else if($tagName == 'A_Intern'){
			$A_Intern = $tagValue; 
		}else if($tagName == 'A_Extern'){
			$A_Extern = $tagValue; 
		}else if($tagName == 'situation'){
			$situation = $tagValue; 
		}else if($tagName == 'descriptif'){
			$descriptif = $tagValue; 
		}else if($tagName == 'comment'){
			$comment = $tagValue; 
		}else if($tagName == 'type'){
			$data['listing_type_id']  = $subchild; 
		}else if($tagName == 'picine'){
			$data['facilities_outdoor']  = ($tagValue == 'oui')?'67':''; 
		}else if($tagName == 'animaux'){
			$data['suitability']  = ($tagValue == 'oui')?'pets:1':'pets:0' ; 
		}else if($tagName == 'ville'){
			$data['address']  =$tagValue; 
		}else if($tagName == 'codepostal'){
			$data['zip_code']  =$tagValue; 
		}else if($tagName == 'pimg'){
			$data['pimg']  =$tagValue; 
		}else if($tagName == 'pimage_url'){	
			$data['pimage_url']  =$tagValue; 
		}	
	}
		
		//saveImageToServer($data['pimage_url'].$data['pimg']);
		//saveImageToServer($final_arr[$data['roi2']]['image_url'].$final_arr[$data['roi2']]['simg']);
		saveImageToServer($final_arr[$data['roi2']]['image_url'].$final_arr[$data['roi2']]['bimg']);
		
		unset($data);
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
}

echo "File Import Completed";
?>