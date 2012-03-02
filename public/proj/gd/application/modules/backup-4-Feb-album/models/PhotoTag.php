<?php
class Album_Model_PhotoTag {
    protected $_id;
    protected $_photoId;
    protected $_userId;
    protected $_taggedId;
    protected $_keyword;
    protected $_photoTag;
    protected $_htmlTag;
    protected $_counter;
    protected $_created;
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
            $this->setMapper(new Album_Model_PhotoTagMapper());
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

    public function setUserId($userId)
    {
        $this->_userId = (int) $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function setTaggedId($taggedId)
    {
        $this->_taggedId = (int) $taggedId;
        return $this;
    }

    public function getTaggedId()
    {
        return $this->_taggedId;
    }
    
    public function setKeyword($keyword)
    {
        $this->_keyword= (string) $keyword;
        return $this;
    }
    
    public function getKeyword()
    {
        return $this->_keyword;
    }
    
    public function setPhotoTag($photoTag)
    {
        $this->_photoTag = (string) $photoTag;
        return $this;
    }
    
    public function getPhotoTag()
    {
        return $this->_photoTag;
    }
    
    public function setHtmlTag($htmlTag)
    {
        $this->_htmlTag = (string) $htmlTag;
        return $this;
    }
    
    public function getHtmlTag()
    {
        return $this->_htmlTag;
    }

    public function setCounter($counter)
    {
        $this->_counter = (string) $counter;
        return $this;
    }

    public function getCounter()
    {
        return $this->_counter;
    }
    
    public function setCreated($created)
    {
        $this->_created = (int) $created;
        return $this;
    }
    
    public function getCreated()
    {
        return $this->_created;
    }   
    
	/*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
	$model = new Album_Model_PhotoTag();
        $model->setId($row->id)
                ->setPhotoId($row->photo_id)
                ->setUserId($row->user_id)
                ->setTaggedId($row->tagged_id)
                ->setKeyword($row->keyword)
                ->setPhotoTag($row->photo_tag)
                ->setHtmlTag($row->html_tag)
                ->setCounter($row->counter)
                ->setCreated($row->created);
    	
             return $model;
    }
    
    public function save()
    {
     	$data = array(
                'photo_id'   	=> $this->getPhotoId(),
     		'user_id'	=> $this->getUserId(),
                'tagged_id'     => $this->getTaggedId(),
     		'keyword'	=> $this->getKeyword(),
     		'photo_tag' 	=> $this->getPhotoTag(),
     		'html_tag' 	=> $this->getHtmlTag(),
                'counter' 	=> $this->getCounter(),
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['created']=time();
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