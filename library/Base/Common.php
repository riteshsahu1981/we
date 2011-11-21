<?php
class Base_Common
{

    function getimgwidhtheightstr($currentimageinfo, $actualHeight, $actualwidth, $returntype="img")
    {
	list($width, $height, $type, $attr) = getimagesize($currentimageinfo);

            if($width >= $actualwidth && $height >= $actualHeight)
            {
                    //$str=" height=$actualHeight, width=$actualwidth";
                    if($width/$height > 1)
                    {
                            $str="width=$actualwidth";
                    }else{
                            $str="height=$actualHeight";
                    }

            }else if($width >= $actualwidth && $height <= $actualHeight){

                    $str=" width=$actualwidth";

            }else if($width <= $actualwidth && $height <= $actualHeight){

                    $str= "height= $height,  width = $width";

            }else if($width <= $actualwidth && $height >= $actualHeight){

                    $str=" height=$actualHeight";
            }

		if($returntype=="img"){
			return $str;
		}else{
			$str=str_replace(" ","&",$str);
			return parse_str($str);
		}
    }

    function getNameFromContent($content)
    {
            //preg_match_all('/<img[^>]+>/i',$news->getContent(), $result);
            preg_match_all('/(<span>)("[^"]*")(</span>)/i', $content, $result);

            return $result;
    }

    
}