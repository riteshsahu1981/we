<?php

class Application_Model_Advice {
    protected $_id;
	 protected $_categoryId;
    protected $_identifire;
    protected $_content;
    protected $_title;
	protected $_name;
    protected $_metaTitle;
    protected $_metaDescription;
    protected $_metaKeyword;
    protected $_status;
    protected $_addedon;
    protected $_updatedon;
    protected $_userId;
    protected $_synopsis;
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
            $this->setMapper(new Application_Model_AdviceMapper());
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
	
	public function setCategoryId($categoryId)
    {
        $this->_categoryId = $categoryId;
        return $this;
    }
    public function getCategoryId()
    {
        return $this->_categoryId;
    }
    
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
	public function getTitle()
    {
        return $this->_title;
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
    
   public function setSynopsis($synopsis)
    {
        $this->_synopsis = (string) $synopsis;
        return $this;
    }

    public function getSynopsis()
    {
        return $this->_synopsis;
    }
    
    public function setIdentifire($identifire)
    {
        $this->_identifire = (string) $identifire;
        return $this;
    }

    public function getIdentifire()
    {
        return $this->_identifire;
    }
    
    public function setContent($content)
    {
        $this->_content = (string) $content;
        return $this;
    }

    public function getContent()
    {
        return $this->_content;
    }
    
  	public function setMetaTitle($metaTitle)
    {
        $this->_metaTitle = (string) $metaTitle;
        return $this;
    }

    public function getMetaTitle()
    {
        return $this->_metaTitle;
    }
    
	public function setMetaDescription($metaDescription)
    {
        $this->_metaDescription = (string) $metaDescription;
        return $this;
    }

    public function getMetaDescription()
    {
        return $this->_metaDescription;
    }

    public function setMetaKeyword($metaKeyword)
    {
        $this->_metaKeyword= (string) $metaKeyword;
        return $this;
    }

    public function getMetaKeyword()
    {
        return $this->_metaKeyword;
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
    	$model=new Application_Model_Advice();
        $model->setId($row->id)
                  ->setCategoryId($row->category_id)
				  ->setTitle($row->title)
				  ->setIdentifire($row->identifire)
                  ->setContent($row->content)
                  ->setMetaTitle($row->meta_title)
                  ->setName($row->name)
                  ->setMetaDescription($row->meta_description)
                  ->setMetaKeyword($row->meta_keyword)
                  ->setStatus($row->status)
                  ->setAddedon($row->addedon)
                  ->setSynopsis($row->synopsis)
                  ->setUpdatedon($row->updatedon)
                  ->setUserId($row->user_id)
                  ;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
			'category_id'   => $this->getCategoryId(),
            'title'   => $this->getTitle(),
	  	  	'identifire'   => $this->getIdentifire(),
		    'name'	  => $this->getName(),
  	  		'content'   => $this->getContent(),
  	  	    'synopsis'   => $this->getSynopsis(),
  	  		'meta_title'   => $this->getMetaTitle(),
  	  		'meta_description'   => $this->getMetaDescription(),
  	  		'meta_keyword'   => $this->getMetaKeyword(),
  	  		'status'   => $this->getStatus(),		
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
    

	
    public function getAdviceCategory($option=null)
    {
    	 $obj=new Application_Model_Advice();
         $entries=$obj->fetchAll();
         $arrCountry=array();
         if(!is_null($option))
         $arrCountry['']=$option;
         foreach($entries as $entry)
         {         
         	$arrCountry[$entry->getId()]=$entry->getTitle();	
         }
         return $arrCountry;
    }



    public static function getStaticContent($identifire){
    	
    	$model=new Application_Model_Advice();
    	
		$where="identifire='{$identifire}'";
		$row=$model->fetchRow($where);
		return $row; 
    }
}
