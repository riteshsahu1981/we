<?php

class Application_Model_Widgets {
    protected $_id;
    protected $_widgetTitle;
    protected $_widgetType;
    protected $_widgetImage;
	protected $_widgetText;
	protected $_widgetAltText;
	protected $_widgetLinkLabel;
    protected $_widgetLinkUrl;
    protected $_widgetLinkTarget;
    protected $_widgetDesc;
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
            throw new Exception('Invalid game property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property'.$method);
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
            $this->setMapper(new Application_Model_WidgetsMapper());
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
    
    public function setWidgetTitle($widgetTitle)
    {
        $this->_widgetTitle = (string) $widgetTitle;
        return $this;
    }
	public function getWidgetTitle()
    {
        return $this->_widgetTitle;
    }
	
	public function setWidgetType($widgetType)
    {
        $this->_widgetType = (string) $widgetType;
        return $this;
    }
    public function getWidgetType()
    {
        return $this->_widgetType;
    }
    
    public function setWidgetImage($widgetImage)
    {
        $this->_widgetImage = (string) $widgetImage;
        return $this;
    }
    public function getWidgetImage()
    {
        return $this->_widgetImage;
    }
	
	public function setWidgetText($widgetText)
    {
        $this->_widgetText = (string) $widgetText;
        return $this;
    }
    public function getWidgetText()
    {
        return $this->_widgetText;
    }
	
	public function setWidgetAltText($widgetAltText)
    {
        $this->_widgetAltText = (string) $widgetAltText;
        return $this;
    }
    public function getWidgetAltText()
    {
        return $this->_widgetAltText;
    }
    
    public function setWidgetLinkLabel($widgetLinkLabel)
    {
        $this->_widgetLinkLabel = (string) $widgetLinkLabel;
        return $this;
    }
    public function getWidgetLinkLabel()
    {
        return $this->_widgetLinkLabel;
    }
    
    public function setWidgetLinkUrl($widgetLinkUrl)
    {
        $this->_widgetLinkUrl = (string) $widgetLinkUrl;
        return $this;
    }
    public function getWidgetLinkUrl()
    {
        return $this->_widgetLinkUrl;
    }
    
  	public function setWidgetLinkTarget($widgetLinkTarget)
    {
        $this->_widgetLinkTarget = (string) $widgetLinkTarget;
        return $this;
    }
    public function getWidgetLinkTarget()
    {
        return $this->_widgetLinkTarget;
    }
    
	public function setWidgetDesc($widgetDesc)
    {
        $this->_widgetDesc = (string) $widgetDesc;
        return $this;
    }
    public function getWidgetDesc()
    {
        return $this->_widgetDesc;
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
    	$model=new Application_Model_Widgets();
        $model->setId($row->id)
              ->setWidgetTitle($row->widget_title)
              ->setWidgetType($row->widget_type)
              ->setWidgetImage($row->widget_image)
              ->setWidgetText($row->widget_text)
			  ->setWidgetAltText($row->widget_alt_text)
              ->setWidgetLinkLabel($row->widget_link_label)
              ->setWidgetLinkUrl($row->widget_link_url)
              ->setWidgetLinkTarget($row->widget_link_target)
			  ->setWidgetDesc($row->widget_desc)
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
            'widget_title'		=> $this->getWidgetTitle(),
	  	  	'widget_type'   	=> $this->getWidgetType(),
		    'widget_image'	  	=> $this->getWidgetImage(),
  	  		'widget_text'   	=> $this->getWidgetText(),
			'widget_alt_text'  	=> $this->getWidgetAltText(),
  	  	    'widget_link_label' => $this->getWidgetLinkLabel(),
  	  		'widget_link_url'   => $this->getWidgetLinkUrl(),
  	  		'widget_link_target'=> $this->getWidgetLinkTarget(),
  	  		'widget_desc'   	=> $this->getWidgetDesc(),
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
