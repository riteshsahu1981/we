<?php
class Album_Model_AlbumPhotoTag {
    protected $_id;
    protected $_photoId;
    protected $_tagId;
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
            $this->setMapper(new Album_Model_AlbumPhotoTagMapper());
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

    public function setPhotoId($photoId)
    {
        $this->_photoId= (int) $photoId;
        return $this;
    }
    
	public function getPhotoId()
    {
        return $this->_photoId;
    }

    public function setTagId($tagId)
    {
        $this->_tagId = (int) $tagId;
        return $this;
    }

	public function getTagId()
    {
        return $this->_tagId;
    }
    
	/*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
			$model = new Album_Model_AlbumPhotoTag();
            $model		->setId($row->id)
						->setPhotoId($row->photo_id)
						->setTagId($row->tag_id);
    	
             return $model;
    }
    
    public function save()
    {
     	$data = array(
            'photo_id'   		=> $this->getPhotoId(),
     		'tag_id'		=> $this->getTagId(),
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            return $this->getMapper()->getDbTable()->insert($data);
        } else {        	
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
       	}else{
       		return false;
       	}
    }   
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }
    /*----Data Manupulation functions ----*/  

		
   
}