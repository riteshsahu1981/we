<?php
class Album_Model_UserAlbum {
    protected $_id;
    protected $_name;
    protected $_date; 
    protected $_status;
    protected $_categoryId;
    protected $_location;
    protected $_description;
    protected $_tags;
    protected $_enableComments;
    protected $_enableLikes;
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
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
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
            $this->setMapper(new Album_Model_UserAlbumMapper());
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

   	public function setDate($date)
    {
        $this->_date = (string) $date;
        return $this;
    }

    public function getDate()
    {
        return $this->_date;
    }
    
    public function getStatus()
    {
        return $this->_status;
    }

    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }   

    public function getCategoryId()
    {
        return $this->_categoryId;
    }

    public function setCategoryId($categoryId)
    {
        $this->_categoryId = (int) $categoryId;
        return $this;
    } 

    public function getLocation()
    {
        return $this->_location;
    }

    public function setLocation($location)
    {
        $this->_location = (string) $location;
        return $this;
    }        

  
    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription($description)
    {
        $this->_description= (string) $description;
        return $this;
    }
    
    public function getTags()
    {
        return $this->_tags;
    }

    public function setTags($tags)
    {
        $this->_tags = (string) $tags;
        return $this;
    }    
    public function getEnableComments()
    {
        return $this->_enableComments;
    }

    public function setEnableComments($enableComments)
    {
        $this->_enableComments = (string) $enableComments;
        return $this;
    }   
   

	public function getEnableLikes()
    {
        return $this->_enableLikes;
    }

    public function setEnableLikes($enableLikes)
    {
        $this->_enableLikes = (string) $enableLikes;
        return $this;
    }
    
    
   

    public function getAddedon()
    {
        return $this->_addedon;
    }


    public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }

    public function getUpdatedon()
    {
        return $this->_updatedon;
    }

    public function setUpdatedon($updatedon)
    {
        $this->_updatedon= (int) $updatedon;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function setUserId($userId)
    {
        $this->_userId= (int) $userId;
        return $this;
    }
    
    
	/*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
			$model = new Album_Model_UserAlbum();
            $model->setId($row->id)
						->setName($row->name)
	                  	->setDate($row->date)
	                  	->setStatus($row->status)
	                  	->setCategoryId($row->category_id)
	                  	->setLocation($row->location)
	                  	->setDescription($row->description)
	                  	->setTags($row->tags)
	                  	->setEnableComments($row->enable_comments)
	                  	->setEnableLikes($row->enable_likes)
	                  	->setAddedon($row->addedon)
	                  	->setUpdatedon($row->updatedon)
	                  	->setUserId($row->user_id)
                  
						
                  ;
    	
             return $model;
    }
    
    public function save()
    {
     	$data = array(
            'name'   			=> $this->getName(),
     		'date'   		=> $this->getDate(),
        	'status'  		=> $this->getStatus(),
        	'category_id'		=> $this->getCategoryId(),
        	'location' 		=> $this->getLocation(),
     		'description'	 			=> $this->getDescription(),
        	'tags'   			=> $this->getTags(),
     		'enable_comments'   			=> $this->getEnableComments(),
     		'enable_likes'	=> $this->getEnableLikes(),
     		'user_id'	=> $this->getUserId()
     		
        	
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
        	$data['updatedon']=time();
            $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
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
    
   
   public function createAlbumSelectBox($where,$id)
   {
   	  $data = $this->fetchAll($where);
   	  $selected = '';
   	  $select = "<select name='album_id' class='form' id='album_id'>";
   	  foreach($data as $row){
   	  	if($row->getId()==$id)
   	  	{
   	  		$selected  = "selected";
   	  		
   	  	}
   	  	$select .= "<option $selected value = '".$row->getId()."'>".$row->getName()."</option>";
   	  }
   	  $select .="</select>";
   	  return $select;
   	
   } 
    /*----Data Manupulation functions ----*/

   
   
}