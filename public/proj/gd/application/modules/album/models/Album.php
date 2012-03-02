<?php
class Album_Model_Album {
    protected $_id;
    protected $_userId;
    protected $_name;
    protected $_description; 
    protected $_location;
    protected $_permission;
    protected $_cover;
    protected $_longitude;
    protected $_latitude;
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
            $this->setMapper(new Album_Model_AlbumMapper());
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
    
	public function setDescription($description)
    {
        $this->_description= (string) $description;
        return $this;
    }
    
	public function getDescription()
    {
        return $this->_description;
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
    
    public function setPermission($permission)
    {
        $this->_permission = (string) $permission;
        return $this;
    }
    
    public function getPermission()
    {
        return $this->_permission;
    }
    
	public function setCover($cover)
    {
        $this->_cover = (int) $cover;
        return $this;
    }
    
    public function getCover()
    {
        return $this->_cover;
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
    
    public function setStatus($status)
    {
        $this->_status = (int) $status;
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
			$model = new Album_Model_Album();
            $model->setId($row->id)
						->setName($row->name)
						->setUserId($row->user_id)
						->setDescription($row->description)
						->setLocation($row->location)
						->setPermission($row->permission)
						->setCover($row->cover)
						->setLongitude($row->longitude)
						->setLatitude($row->latitude)
						->setStatus($row->status)
						->setAddedon($row->addedon);
    	
             return $model;
    }
    
    public function save()
    {
     	$data = array(
            'name'   		=> $this->getName(),
     		'user_id'		=> $this->getUserId(),
     		'description'	=> $this->getDescription(),
     		'location' 		=> $this->getLocation(),
     		'permission' 	=> $this->getPermission(),
     		'cover' 		=> $this->getCover(),
     		'longitude'		=> $this->getLongitude(),
     		'latitude'		=> $this->getLatitude(),
     		'status'  		=> $this->getStatus(),
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
       	}else{
       		return false;
       	}
    }   
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }
    /*----Data Manupulation functions ----*/
	
	
	public function albumCapacity($userId)
	{
		$usedSize = $this->calculateUsedSize($userId);
                //echo $usedSize['usedSize'];
		$imageName = $this->getUsedSizeImage($usedSize['usedPercent']);
		$imagePath = "/images/progress/".$imageName;
		$arrAlbumCapacity[] = $imagePath;
		$arrAlbumCapacity[] = $usedSize['usedPercent'];
                $arrAlbumCapacity[] = $usedSize['usedSize'];
		return $arrAlbumCapacity;
	}
	
	public function calculateUsedSize($userId)
	{
		$maximumCapacity = 5368709120;	// 5 GB
        //$maximumCapacity = 47185920;	// 45 MB
		//$maximumCapacity = 5242880;	// 5 MB
		$usedSize = 0;
		
		$db = Zend_Registry::get('db');
		
		$where = "user_id='{$userId}'";
		
		$query = $db->select()
                ->from(array("ap" => "album_photo"),array("size"))
                ->where($where);
				
		$recordSet = $db->query($query);
                $arrSize = $recordSet->fetchAll();
		foreach($arrSize as $size)
		{
			$usedSize = $usedSize+$size->size;
		}
		//echo $usedSize;
		$usedPercent	=	round(($usedSize*100)/$maximumCapacity, 2);
                if($usedPercent > 100)
                {
                    $usedPercent = 100;
                }
		$arrImageCapacity['usedSize'] = $usedSize;
                $arrImageCapacity['usedPercent'] = $usedPercent;
		return $arrImageCapacity;		
	}
	
	public function getUsedSizeImage($usedPercent)
	{
		if($usedPercent < 1)
		{
			$imgName	=	"no.jpg";
		}else if($usedPercent >= 1 && $usedPercent <= 10){
			$imgName	=	"1.jpg";
		}else if($usedPercent > 10 && $usedPercent <= 20){
			$imgName	=	"2.jpg";
		}else if($usedPercent > 20 && $usedPercent <= 30){
			$imgName	=	"3.jpg";
		}else if($usedPercent > 30 && $usedPercent <= 40){
			$imgName	=	"4.jpg";
		}else if($usedPercent > 40 && $usedPercent <= 50){
			$imgName	=	"5.jpg";
		}else if($usedPercent > 50 && $usedPercent <= 60){
			$imgName	=	"6.jpg";
		}else if($usedPercent > 60 && $usedPercent <= 70){
			$imgName	=	"7.jpg";
		}else if($usedPercent > 70 && $usedPercent <= 80){
			$imgName	=	"8.jpg";
		}else if($usedPercent > 80 && $usedPercent <= 90){
			$imgName	=	"9.jpg";
		}else if($usedPercent > 90 && $usedPercent <= 100){
			$imgName	=	"10.jpg";
		}else{
			$imgName	=	"10.jpg";
		}
		return $imgName;
	}

    
   
}
