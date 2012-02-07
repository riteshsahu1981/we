<?php
class Application_Model_TravelGuidesSlides {
    protected $_id;
    protected $_slideTitle;
    protected $_slideType;
    protected $_slideImage;
	protected $_slideText;
	protected $_slideLinkLabel;
    protected $_slideLinkUrl;
    protected $_slideLinkTarget;
	protected $_weight;
    protected $_status;
    protected $_addedon;
    protected $_updatedon;
    protected $_userId;
    protected $_mapper;   
    
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid table property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid table property'.$method);
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
	
 	public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }    
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_TravelGuidesSlidesMapper());
        }
        return $this->_mapper;
    }
    
 	public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    public function getId()
    {
        return $this->_id;
    }
    
    public function setSlideTitle($slideTitle)
    {
        $this->_slideTitle = (string) $slideTitle;
        return $this;
    }
	public function getSlideTitle()
    {
        return $this->_slideTitle;
    }
	
	public function setSlideType($slideType)
    {
        $this->_slideType = (string) $slideType;
        return $this;
    }
    public function getSlideType()
    {
        return $this->_slideType;
    }
    
    public function setSlideImage($slideImage)
    {
        $this->_slideImage = (string) $slideImage;
        return $this;
    }
    public function getSlideImage()
    {
        return $this->_slideImage;
    }
	
	public function setSlideText($slideText)
    {
        $this->_slideText = (string) $slideText;
        return $this;
    }
    public function getSlideText()
    {
        return $this->_slideText;
    }
	
	public function setSlideLinkLabel($slideLinkLabel)
    {
        $this->_slideLinkLabel = (string) $slideLinkLabel;
        return $this;
    }
    public function getSlideLinkLabel()
    {
        return $this->_slideLinkLabel;
    }
    
    public function setSlideLinkUrl($slideLinkUrl)
    {
        $this->_slideLinkUrl = (string) $slideLinkUrl;
        return $this;
    }
    public function getSlideLinkUrl()
    {
        return $this->_slideLinkUrl;
    }
    
  	public function setSlideLinkTarget($slideLinkTarget)
    {
        $this->_slideLinkTarget = (string) $slideLinkTarget;
        return $this;
    }
    public function getSlideLinkTarget()
    {
        return $this->_slideLinkTarget;
    }
    
    public function setWeight($weight)
    {
        $this->_weight= (int) $weight;
        return $this;
    }
    public function getWeight()
    {
        return $this->_weight;
    }

    public function setStatus($status)
    {
        $this->_status= (int) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }    
    
	public function setUserId($userId)
    {
        $this->_userId= (int) $userId;
        return $this;
    }
    public function getUserId()
    {
        return $this->_userId;
    }	
    
	public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }
    public function getAddedon()
    {
        return $this->_addedon;
    }
    
	public function setUpdatedon($updatedon)
    {
        $this->_updatedon = (int) $updatedon;
        return $this;
    }
    public function getUpdatedon()
    {
        return $this->_updatedon;
    }
	
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model = new Application_Model_TravelGuidesSlides();
        $model->setId($row->id)
              ->setSlideTitle($row->slide_title)
              ->setSlideType($row->slide_type)
              ->setSlideImage($row->slide_image)
              ->setSlideText($row->slide_text)
			  ->setSlideLinkLabel($row->slide_link_label)
			  ->setSlideLinkUrl($row->slide_link_url)
			  ->setSlideLinkTarget($row->slide_link_target)
              ->setWeight($row->weight)
              ->setStatus($row->status)
              ->setUserId($row->user_id)
			  ->setAddedon($row->addedon)              
              ->setUpdatedon($row->updatedon)              
              ;
             return $model;
    }
    
    public function save()
    {
      	$data = array(
            'slide_title'		=> $this->getSlideTitle(),
	  	  	'slide_type'   		=> $this->getSlideType(),
		    'slide_image'		=> $this->getSlideImage(),
  	  		'slide_text'   		=> $this->getSlideText(),
			'slide_link_label'	=> $this->getSlideLinkLabel(),
			'slide_link_url'	=> $this->getSlideLinkUrl(),
			'slide_link_target' => $this->getSlideLinkTarget(),
			'weight'   			=> $this->getWeight(),
  	  		'status'   			=> $this->getStatus(),		
        	'user_id' 			=> $this->getUserId(),
        );
				        
        if (null === ($id = $this->getId()))
		{
            unset($data['id']);
             $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
        	$data['updatedon']=time();
            return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }        
    }//end function


    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result))
		{
            return false;
        }
        $row = $result->current();
        $res=$this->setModel($row);
        return $res;
    }
	

    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        $resultSet = $this->getMapper()->getDbTable()->fetchAll($where, $order , $count , $offset);
        $entries   = array();
        foreach ($resultSet as $row) 
        {
            $res=$this->setModel($row);
            $entries[] = $res;
        }
        return $entries;        
    }
    
    public function fetchRow($where)
    {
    	$row = $this->getMapper()->getDbTable()->fetchRow($where);

       	if(!empty($row))
       	{
 			$res=$this->setModel($row);
 			return $res;
       	}
       	else 
       	{
       		return false;
       	}        
    }   
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }    
}
