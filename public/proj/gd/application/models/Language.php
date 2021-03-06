<?php

class Application_Model_Language
{
    protected $_id;
    protected $_name;
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
            throw new Exception('Invalid language property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid language property');
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
            $this->setMapper(new Application_Model_LanguageMapper());
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
    
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }
    

    
	public function setUserId($userId)
    {
        $this->_userId= $userId;
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
    	$model=new Application_Model_Language();
        $model->setId($row->id)
                  ->setName($row->name)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ->setUserId($row->user_id)
                  
                  ;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
            'name'   => $this->getName(),
        	'user_id' => $this->getUserId(),
  	  		
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
             $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
        	$data['updatedon']=time();
            return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }
        
    }


    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result)) {
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
    
    public function getLanguage($option=null)
    {
    	$arrLang=array();
    	if(!is_null($option))
    		$arrLang['']=$option;
		$language=$this->fetchAll();
		foreach($language as $row)
		{
			$arrLang[$row->getId()]=$row->getName();
		}   
		return $arrLang;  	
    }
    
    public function getLanguageCombo($type)
    {
	    $where="type='{$type}'";
		$actor=$this->fetchAll($where);
		echo "<select class='selectbox' onchange='search_movie()' name='language' id='language'>";
		echo "<option value=''>Language</option>";
		foreach($actor as $row)
		{
			$selected="";
        		if(isset($_REQUEST['language']) && $_REQUEST['language']==$row->getId())
        			$selected="selected='selected'";
      		echo "<option ".$selected." value='".$row->getId()."'>".$row->getName()."</option>";
		}
		echo "</select>";
    }

    /*----Data Manupulation functions ----*/

	public function getLanguageArray($type)
    {
    	$arrLanguage=Array();
    	$where="type='{$type}'";
		$language=$this->fetchAll($where);
		foreach($language as $row)
		{
      		$arrLanguage[$row->getId()]=$row->getName();
		}
		return $arrLanguage;
    }
    
	public function getLanguagesByItemId($item_id, $type)
    {
    	$languagesArray=array();
    	$extrasM=new Application_Model_Extras();
        $extras=$extrasM->fetchAll("identifire='language' and type='{$type}' and item_id='{$item_id}'");
        foreach($extras as $extra)
        {
        	$language=$this->find($extra->getExtraId());
        	if(false!==$language)
        	{
        		$languagesArray[$language->getId()]=$language->getName();
        	}
        }
        return $languagesArray;
    }
}

