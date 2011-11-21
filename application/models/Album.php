<?php
class Application_Model_Album {

    protected $_id;
    protected $_title;
    protected $_userId;
    protected $_coverImage;
    protected $_description;
    protected $_status;
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
            $this->setMapper(new Application_Model_AlbumMapper());
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

    public function setUserId($userId)
    {
        $this->_userId = (int) $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setCoverImage($coverImage)
    {
        $this->_coverImage = (string) $coverImage;
        return $this;
    }

    public function getCoverImage()
    {
        return $this->_coverImage;
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
    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->_status;
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

    public function getAlbumPictures($album_id=null)
    {
        if(is_null($album_id))
            $album_id=$this->getId();
        $pictures=new Application_Model_Pictures();
        return $pictures->fetchAll("album_id='{$album_id}'", "addedon desc");
    }
    
    public function getCoverImageThumb()
    {
        $profile_image=$this->getCoverImage();
        
        $cdnuri=new Base_View_Helper_CdnUri();
		
        //Set default profile image according to user Gender
        $thumb = $cdnuri->cdnUri()."/images/folder.png";
        
        if(is_file("media/picture/album/thumb_".$profile_image))
        {
            $thumb = $cdnuri->cdnUri()."/media/picture/album/thumb_$profile_image";
        }
        return $thumb;
    }
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	
    		
            $model = new Application_Model_Album();
            $model->setId($row->id)
                  	->setTitle($row->title)
                        ->setUserId($row->user_id)
                        ->setCoverImage($row->cover_image)
                        ->setDescription($row->description)
                        ->setStatus($row->status)
                	->setAddedon($row->addedon)
                        ->setUpdatedon($row->updatedon)
                	;

             return $model;
    }
    
    
    
    
    
    public function save()
    {
        $data = array(
            'title'   => $this->getTitle(),
            'user_id'      => $this->getUserId(),
            'cover_image'      => $this->getCoverImage(),
            'description'   => $this->getDescription(),
            'status'=>$this->getStatus()
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

    public function uploadCoverImage($id,$options)
    {
        $model=new Application_Model_Album();
        $model=$model->find($id);
        $upload = new Zend_File_Transfer_Adapter_Http();
        if($upload->isValid('coverImage'))
        {
            $upload->setDestination("media/picture/album/");
            try
            {
                  $upload->receive('coverImage');
             }
             catch (Zend_File_Transfer_Exception $e)
             {
                    $msg= $e->getMessage();
             }

             $upload->setOptions(array('useByteString' => false));

             $file_name = $upload->getFileName('coverImage');
             $cardImageTypeArr = explode(".", $file_name);
             $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
             $target_file_name = "album_cover_".$id.".{$ext}";
             $targetPath = 'media/picture/album/'.$target_file_name;
             $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
             $filterFileRename -> filter($file_name);
             $options['coverImage'] = $target_file_name;


           
             /*--- Generate Profile Picture ---*/
            $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
            $thumb->resize(150,150);
            $thumb->save('media/picture/album/thumb_'.$target_file_name);
            
            $model->setCoverImage($options['coverImage']);
            return $model->save();
        }
    }
   
    public function rrmdir($dir) {
       if (is_dir($dir)) {
         $objects = scandir($dir);
         foreach ($objects as $object) {
           if ($object != "." && $object != "..") {
             if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
           }
         }
         reset($objects);
         rmdir($dir);
       }
     }
}