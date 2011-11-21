<?php
class Base_View_Helper_Blocks extends Zend_View_Helper_Abstract
{
	public $view;
	

	
	public function blocks($region, $path="/modules/block/views/blocks")
  	{
     
            //var_dump ($this->request);
            $request_uri=$_SERVER['REQUEST_URI'];
            $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
            if($config->seofriendlyurl=="1")
            {
                $seoUrlM=new Application_Model_SeoUrl();
                $seoUrl=$seoUrlM->fetchRow("seo_url='{$request_uri}'");
                if(false!==$seoUrl)
                {
                    $request_uri=$seoUrl->getActualUrl();
                }
                
            }
  		$regionM=new Block_Model_BlockRegion();
  		
  		$regionO=$regionM->fetchRow("alias='{$region}'");
  		
  		if($regionO===false)
  			return false;
	
  		$blockM=new Block_Model_Block();
  		$where=" (block_region_id='{$regionO->getId()}' || block_region_id='0')   and status='1'";
  		$order="weight desc";
  		$blocks=$blockM->fetchAll($where, $order);
  		if(count($blocks)>0)
  		{
  			$requestUrl=trim($request_uri);
  			$path=APPLICATION_PATH.$path."/".$region;
  			$this->view->addScriptPath($path);
  			foreach($blocks as $_block)
  			{
  				$flag=false;
  				$arrPaths=unserialize($_block->getVisibilityPaths());
  				foreach($arrPaths as $_path)
  				{
  					$_path=trim($_path);
  					if($_path==$requestUrl)
  					{
  						$flag=true;
  						break; //break the path loop
  					}  
  					else if(false!==strpos($_path,"*")) 
  					{
  						$_path=substr($_path,0,-2);
  						if($_path<>""){
							if(false!==strpos($requestUrl,$_path))
							{
								$flag=true;
								break; //break the path loop
							}
  						}else{
  							$flag=true;
								break; //break the path loop
  						}	  						
  					}
  					
  					
  				}//end of path loop
  				
  				if($flag==true)
  				{
  					if(trim($_block->getBody())=="")
	  				{

                                            if($_block->getAlias()=="recent-blog" && ($requestUrl=="/journal/my-journals" || $requestUrl=="/journal/journal-settings"))
                                            {
                                                //no need to display the block
                                            }
                                            else
                                            {
			 			echo $this->view->render($_block->getAlias().".phtml");
                                            }
                                            
	  				}
	  				else
	  				{
	  					echo $_block->getBody();
	  				}
  				}
  			}
  		}
  	}
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

   
	
}