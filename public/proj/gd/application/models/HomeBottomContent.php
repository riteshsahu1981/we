<?php
class Application_Model_HomeBottomContent
{
    protected $_id;
    protected $_backgroundImage;
	protected $_leftTitle;
	protected $_leftText;
	protected $_rightTitle;
	protected $_rightText;
	protected $_status;
    protected $_userId;
	protected $_addedon;
    protected $_updatedon;
    protected $_mapper;
    
    public function __construct(array $options = null)
    {
        if (is_array($options))
		{
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Setting invalid table property');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Getting invalid table property'.$method);
        }
        return $this->$method();
    }
	
	public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }    
    public function getMapper()
    {
        if (null === $this->_mapper)
		{
            $this->setMapper(new Application_Model_HomeBottomContentMapper());
        }
        return $this->_mapper;
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value)
		{
            $method = 'set' . ucfirst($key);
		    if (in_array($method, $methods))
			{
                $this->$method($value);
            }
        }
        return $this;
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
    
    public function setBackgroundImage($backgroundImage)
    {
        $this->_backgroundImage = (string) $backgroundImage;
        return $this;
    }
    public function getBackgroundImage()
    {
        return $this->_backgroundImage;
    }
	
	public function setLeftTitle($leftTitle)
    {
        $this->_leftTitle = (string) $leftTitle;
        return $this;
    }
    public function getLeftTitle()
    {
        return $this->_leftTitle;
    }
	
	public function setLeftText($leftText)
    {
        $this->_leftText = (string) $leftText;
        return $this;
    }
    public function getLeftText()
    {
        return $this->_leftText;
    }
	
	public function setRightTitle($rightTitle)
    {
        $this->_rightTitle = (string) $rightTitle;
        return $this;
    }
    public function getRightTitle()
    {
        return $this->_rightTitle;
    }
	
	public function setRightText($rightText)
    {
        $this->_rightText = (string) $rightText;
        return $this;
    }
    public function getRightText()
    {
        return $this->_rightText;
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
    	$model = new Application_Model_HomeBottomContent();
        $model->setId($row->id)
              ->setBackgroundImage($row->background_image)
			  ->setLeftTitle($row->left_title)
			  ->setLeftText($row->left_text)
			  ->setRightTitle($row->right_title)
              ->setRightText($row->right_text)
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
            'background_image'	=> $this->getBackgroundImage(),
			'left_title'	  	=> $this->getLeftTitle(),
			'left_text'	  		=> $this->getLeftText(),
			'right_title'	  	=> $this->getRightTitle(),
  	  		'right_text' 		=> $this->getRightText(),
  	  		'status'   			=> $this->getStatus(),		
        	'user_id' 			=> $this->getUserId(),
        );
		if (null === ($id = $this->getId()))
		{
			unset($data['id']);
			$data['addedon'] = time();
			return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
			$data['updatedon'] = time();
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
