<?php
class Album_Model_AlbumPhoto {
    protected $_id;
    protected $_albumId;
    protected $_userId;
    protected $_name;
    protected $_caption;
    protected $_location;
    protected $_longitude;
    protected $_latitude;
	protected $_permission;
	protected $_image;
	protected $_type;
	protected $_size;    
    protected $_status;
    protected $_addedon;    
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
            $this->setMapper(new Album_Model_AlbumPhotoMapper());
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
    
	public function setAlbumId($albumId)
    {
        $this->_albumId = (int) $albumId;
        return $this;
    }

    public function getAlbumId()
    {
        return $this->_albumId;
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

    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

   	public function setCaption($caption)
    {
        $this->_caption = (string) $caption;
        return $this;
    }

    public function getCaption()
    {
        return $this->_caption;
    }
    
	public function setLocation($location)
    {
        $this->_location = (string) $location;
        return $this;
    }
    
	public function getLocation()
    {
        return $this->_location;
    }
    
	public function setLongitude($longitude)
    {
        $this->_longitude = (string) $longitude;
        return $this;
    }
    
	public function getLongitude()
    {
        return $this->_longitude;
    }
    
	public function setLatitude($latitude)
    {
        $this->_latitude = (string) $latitude;
        return $this;
    }
    
	public function getLatitude()
    {
        return $this->_latitude;
    }
    
	public function setPermission($permission)
    {
        $this->_permission = (string) $permission;
        return $this;
    }
    
	public function getPermission()
    {
        return $this->_permission;
    }
    
	public function setImage($image)
    {
        $this->_image = (string) $image;
        return $this;
    }
    
	public function getImage()
    {
        return $this->_image;
    }
    
	public function setType($type)
    {
        $this->_type = (string) $type;
        return $this;
    }
    
	public function getType()
    {
        return $this->_type;
    }
    
	public function setSize($size)
    {
        $this->_size = (int) $size;
        return $this;
    }
    
	public function getSize()
    {
        return $this->_size;
    }

    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }

 	public function getStatus()
    {
        return $this->_status;
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
    
	/*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
			$model = new Album_Model_AlbumPhoto();
            $model		->setId($row->id)
            			->setAlbumId($row->album_id)
            			->setUserId($row->user_id)
				->setName($row->name)
	                  	->setCaption($row->caption)
	                  	->setLocation($row->location)
	                  	->setLongitude($row->longitude)
	                  	->setLatitude($row->latitude)
	                  	->setPermission($row->permission)
	                  	->setImage($row->image)
	                  	->setType($row->type)
	                  	->setSize($row->size)
	                  	->setStatus($row->status)
	                  	->setAddedon($row->addedon);
    	
             return $model;
    }
    
    public function save()
    {
     	$data = array(
     		'user_id'			=> $this->getUserId(),
     		'album_id'			=> $this->getAlbumId(),
                'name'   			=> $this->getName(),
     		'caption'  			=> $this->getCaption(),
     		'location'			=> $this->getLocation(),
     		'longitude'			=> $this->getLongitude(),
     		'latitude'			=> $this->getLatitude(),
     		'permission'		=> $this->getPermission(),
     		'image'				=> $this->getImage(),
     		'type'   			=> $this->getType(),
     		'size'   			=> $this->getSize(),     	
        	'status'  			=> $this->getStatus(),
     	);

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
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
    
    /*----Data Manupulation functions ----*/
    
    public function numberAlbumPhoto($albumId, $permission=null)
    {
    	$where	=	"album_id='{$albumId}' AND status='1'";
    	if($permission != null)
    	{
    		$where	.=	" AND permission='{$permission}'";
    	}
    	
    	$arrPhoto	=	$this->fetchAll($where);
    	return count($arrPhoto);
    }

    public function getAlbumPhotoTags($photoId)
    {
            $objModelAlbumTag	=	new Album_Model_AlbumPhotoTag();
            $objModelTag		=	new Application_Model_Tags();

            $whereAlbumPhotoTag	=	"photo_id='{$photoId}'";
            $arrTagId		=	$objModelAlbumTag->fetchAll($whereAlbumPhotoTag);

            $strTag	=	"";
            if(!empty($arrTagId))
            {
                    foreach($arrTagId as $tagId)
                    {
                            $tId	=	$tagId->tagId;
                            $whereTag	=	"id='{$tId}'";
                            $arrTag	=	$objModelTag->fetchRow($whereTag);

                            $strTag	=	$strTag.','.$arrTag->tag;
                    }
                    $strTag	=	substr($strTag, 1, strlen($strTag));
            }
            return $strTag;
    }

   
   
}