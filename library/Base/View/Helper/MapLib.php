<?php
class Base_View_Helper_MapLib extends Zend_View_Helper_Abstract
{

	protected $_apiKey;
	public $view;
	
	public function mapLib($apiKey=null,$sensor="false",$v=3)
	{
                if($v<3)
                {
                    if(is_null($apiKey))
                    {
                            $map=new Base_Google_Map();
                            $this->_apiKey=$map->getApiKey();
                    }
                    else
                    {
                            $this->_apiKey=$apiKey;
                    }
                }
                
		if($v==3)
		{		
			$this->view->headScript()->appendFile('http://maps.google.com/maps/api/js?sensor='.$sensor);
		}
		else
		{
			$this->view->headScript()->appendFile('http://maps.google.com/maps?file=api&v=3&region=GB&sensor='.$sensor.'&key='.$this->_apiKey);
		}
		return $this;
	}

	public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
    
    public function setGear($gear='http://code.google.com/apis/gears/gears_init.js')
    {
    	$this->view->headScript()->appendFile($gear);
    }
}