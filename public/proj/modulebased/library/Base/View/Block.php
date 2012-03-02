<?php
/*
 * Author : Ritesh Kumar Sahu
 * email : riteshsahu1981@gmail.com
 * phone : 098171901519
 */
class Base_View_Block{
	
	
	public function getBlock($region="blocks")
	{
		$blocks=array();
		if(Zend_Registry::isRegistered($region))
		{
			$blocks=Zend_Registry::get($region);
		}
			
		return $blocks;
	}

	
	public function setBlock($blocks, $region="blocks")
	{
		if(is_array($blocks))
		{
			$base=new Base_Array();
   			$base->orderBy($blocks, 'order', 'desc');
			Zend_Registry::set($region, $blocks);
		}
		else 
			"Invalid Array";
	}
	
	public function addBlock($block, $region="blocks")
	{
		if(is_array($block))
		{
			if(!isset($block['path']))
			$block['path']="/layouts/scripts/page/blocks";
			
			$blocks=$this->getBlock($region);
			if(count($blocks)>0)
				array_push($blocks,$block);
			else
				$blocks[]=$block;
			$this->setBlock($blocks,$region);
		}
		else 
			echo "Invalid Array";
	}
	
	public function removeBlock($blockName, $region="blocks"){
		
		$newBlocks=array();
		$blocks=$this->getBlock($region);
		if(count($blocks)>0){
			foreach($blocks as $block)
			{
				if($block['name']!=$blockName){
					array_push($newBlocks,$block);
				}
			}
			$this->setBlock($newBlocks, $region);
		}
		
	}
}