<?php
class Application_Model_CountryImages
{
    protected $_id;
	protected $_countryId;
    protected $_slideTitle;
	protected $_altText;
    protected $_countryImage;
	protected $_slideLinkUrl;
    protected $_slideLinkTarget;
	protected $_weight;
    protected $_status;
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
            $this->setMapper(new Application_Model_CountryImagesMapper());
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
	
	public function setCountryId($countryId)
    {
        $this->_countryId= (int) $countryId;
        return $this;
    }
    public function getCountryId()
    {
        return $this->_countryId;
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
	
	public function setAltText($altText)
    {
        $this->_altText = (string) $altText;
        return $this;
    }
	public function getAltText()
    {
        return $this->_altText;
    }
	
	public function setCountryImage($countryImage)
    {
        $this->_countryImage = (string) $countryImage;
        return $this;
    }
    public function getCountryImage()
    {
        return $this->_countryImage;
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
    
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model = new Application_Model_CountryImages();
        $model->setId($row->id)
              ->setCountryId($row->country_id)
              ->setCountryImage($row->country_image)
			  ->setSlideTitle($row->slide_title)
			  ->setAltText($row->alt_text)
			  ->setSlideLinkUrl($row->slide_link_url)
			  ->setSlideLinkTarget($row->slide_link_target)
			  ->setWeight($row->weight)
              ->setStatus($row->status);
		return $model;
    }
    
    public function save()
    {
      	$data = array(
            'country_id'		=> $this->getCountryId(),
	  	  	'country_image'		=> $this->getCountryImage(),
			'slide_title'		=> $this->getSlideTitle(),
			'alt_text'			=> $this->getAltText(),
			'slide_link_url'	=> $this->getSlideLinkUrl(),
			'slide_link_target' => $this->getSlideLinkTarget(),
			'weight'   			=> $this->getWeight(),
  	  		'status'   			=> $this->getStatus()
        );
				        
        if (null === ($id = $this->getId()))
		{
            unset($data['id']);
            //$data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
        	//$data['updatedon']=time();
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
