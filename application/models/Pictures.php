<?php
class Application_Model_Pictures{

    protected $_id;
    protected $_image;
    protected $_albumId;
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
            $this->setMapper(new Application_Model_PicturesMapper());
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

   public function setImage($image)
    {
        $this->_image = (string) $image;
        return $this;
    }

    public function getImage()
    {
        return $this->_image;
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
    public function getAddedon()
    {
        return $this->_addedon;
    }

    public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }


	/*----Data Manupulation functions ----*/
    public function setModel($row)
    {
    	
    		
            $model = new Application_Model_Pictures();
            $model->setId($row->id)
            ->setImage($row->image)
            ->setAlbumId($row->album_id)
            ->setAddedon($row->addedon)
                	;
             return $model;
    }
    
    public function save()
    {
        $data = array(
            'image'   => $this->getImage(),
            'album_id'   => $this->getAlbumId()
            );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
           return $this->getMapper()->getDbTable()->insert($data);
        } else {
           // $data['updatedon']=time();
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
    
    public function uploadPicture($options)
    {
        $upload = new Zend_File_Transfer_Adapter_Http();
        $albumId=$options['album_id'];
        $targetFolder=PUBLIC_PATH."/media/picture/album/{$albumId}";
        if(!is_dir($targetFolder))
            mkdir(str_replace('//','/',$targetFolder), 0755, true);
             
        if($upload->isValid('Filedata'))
        {
            $upload->setDestination($targetFolder);
            try
            {
                  $upload->receive('Filedata');
             }
             catch (Zend_File_Transfer_Exception $e)
             {
                    $msg= $e->getMessage();
             }

             $upload->setOptions(array('useByteString' => false));

             $file_name = $upload->getFileName('Filedata');
             
             $model=new Application_Model_Pictures();
             $model->setAlbumId($albumId);
             $model->setImage($file_name);
             $id=$model->save();
             
             $cardImageTypeArr = explode(".", $file_name);
             $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
             $target_file_name = "album_picture_".$id.".{$ext}";
             $targetPath = $targetFolder.'/'.$target_file_name;
             $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
             $filterFileRename -> filter($file_name);
           
             /*--- Generate Profile Picture ---*/
            $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
            $thumb->resize(600,600);
            $thumb->save($targetFolder.'/small_'.$target_file_name);
            
            $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
            $thumb->resize(150,150);
            $thumb->save($targetFolder.'/thumb_'.$target_file_name);
            
            
            $model=new Application_Model_Pictures();
            $model=$model->find($id);
            $model->setImage($target_file_name);
             $model->save();

            $str="<div class='album_pic_thumb_box' id='pic_container_".$model->getId()."'>";
            $str.='<a class="album_pic_slide"  href="'.$model->getPictureSmallUrl().'"><img class="album_pic_thumb" src="'. $model->getPictureThumbUrl().'"/></a>';
            
           
            $str.='<br class="clear">';
            $str.="<a href=\"javascript: deletePic('".$model->getId()."');\">";
            $str.="<img src=\"/images/icons/cross_circle.png\" alt=\"Click here to delete!\">";
            $str.="</a>" ;
            $str.="</div>" ;
            return  $str;
        }
    }
    
    
    public function getPictureThumbUrl()
    {
        $cdnuri=new Base_View_Helper_CdnUri();
        return $cdnuri->cdnUri()."/media/picture/album/{$this->getAlbumId()}/thumb_".$this->getImage();
    }
    
    public function getPictureSmallUrl()
    {
        $cdnuri=new Base_View_Helper_CdnUri();
        return $cdnuri->cdnUri()."/media/picture/album/{$this->getAlbumId()}/small_".$this->getImage();
    }
    public function getPictureLargeUrl()
    {
        $cdnuri=new Base_View_Helper_CdnUri();
        return $cdnuri->cdnUri()."/media/picture/album/{$this->getAlbumId()}/".$this->getImage();
    }
}