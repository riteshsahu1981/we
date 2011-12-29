<?php
class Application_Model_Book {

    protected $_id;
    protected $_title;
    protected $_isbn;
    protected $_author;
    protected $_description;
    protected $_publisher;
    protected $_addedon;
    protected $_updatedon;
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
            throw new Exception('Invalid property specified '.$method );
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
            $this->setMapper(new Application_Model_BookMapper());
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

   public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setIsbn($isbn)
    {
        $this->_isbn = (string) $isbn;
        return $this;
    }

    public function getIsbn()
    {
        return $this->_isbn;
    }
    
    public function setAuthor($author)
    {
        $this->_author = (string) $author;
        return $this;
    }

    public function getAuthor()
    {
        return $this->_author;
    }
    
    public function setDescription($description)
    {
        $this->_description = (string) $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->_description;
    }
    
    public function setPublisher($publisher)
    {
        $this->_publisher = (string) $publisher;
        return $this;
    }

    public function getPublisher()
    {
        return $this->_publisher;
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

    
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	
    		
            $model = new Application_Model_Book();
            $model->setId($row->id)
                  	->setTitle($row->title)
                        ->setIsbn($row->isbn)
                        ->setAuthor($row->author)
                        ->setDescription($row->description)
                        ->setPublisher($row->publisher)
                	->setAddedon($row->addedon)
                        ->setUpdatedon($row->updatedon)
                                
                	;

             return $model;
    }
    
    
    
    
    
    public function save()
    {
        $data = array(
            'title'   => $this->getTitle(),
            'isbn'      => $this->getIsbn(),
            'author'      => $this->getAuthor(),
            'description'   => $this->getDescription(),
            'publisher' =>$this->getPublisher()
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

   
}