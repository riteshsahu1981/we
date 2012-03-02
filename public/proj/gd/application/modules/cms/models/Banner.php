<?php


class Cms_Model_Banner {
	
    protected $_id;
    
    protected $_title;
    
    protected $_position;
    
    protected $_image;

    protected $_url;

    protected $_description;

    protected $_published;
    
    protected $_created;
    
    protected $_userId;
    
    protected $_mapper;
 
    protected $_bannerType;
    
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

  	public function setPosition($position)
    {
        $this->_position = (string) $position;
        return $this;
    }

    public function getPosition()
    {
        return $this->_position;
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

    public function setUrl($url)
    {
        $this->_url = (string) $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->_url;
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
    
    public function setPublished($published)
    {
        $this->_published= (string) $published;
        return $this;
    }

    public function getPublished()
    {
        return $this->_published;
    }

    public function setCreated($created)
    {
        $this->_created= (int) $created;
        return $this;
    }

    public function getCreated()
    {
        return $this->_created;
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
         
    
  	public function setBannerType($bannerType)
    {
        $this->_bannerType= (string) $bannerType;
        return $this;
    }

    public function getBannerType()
    {
        return $this->_bannerType;
    }
    
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Cms_Model_BannerMapper());
        }
        return $this->_mapper;
    }

        
    private function setModel($row)
    {
    	$model=new Cms_Model_Banner();
    	$model->setId($row->Id)
             ->setTitle($row->Title)
             ->setPosition($row->Position)
             ->setImage($row->Image)
             ->setUrl($row->Url)
             ->setDescription($row->Description)
             ->setPublished($row->Published)
             ->setCreated($row->Created)
             ->setBannerType($row->BannerType)
             ->setUserId($row->UserId);
             
             return $model;
    }
    
    /**
     * Save the current entry
     * 
     * @return void
     */
    public function save()
    {
    
        $data = array(
            'Title'   => $this->getTitle(),
            'Position'   => $this->getPosition(),
            'Image'   => $this->getImage(),
            'Url'   => $this->getUrl(),
            'Description' => $this->getDescription(),
        	'BannerType' => $this->getBannerType(),
            'Published'   => $this->getPublished(),
        );
	$usersNs = new Zend_Session_Namespace("members");
        
        if (null === ($id = $this->getId())) {
            unset($data['Id']);
            $data['Created']=time();
            $data['UserId']=$usersNs->userId;
            return $this->getMapper()->getDbTable()->insert($data);
        } 
        else 
        {
        	$data['UserId']=$usersNs->userId;
            return $this->getMapper()->getDbTable()->update($data, array('Id = ?' => $id));
        }
        
    }

    /**
     * Find an entry
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return User_Model_User
     */
    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        
        $row = $result->current();
        $res=$this->setModel($row);
        return $res;
    }
	
    
    /**
     * Fetch all entries
     * 
     * @return array
     */
    public function fetchAll($where="1")
    {
        $resultSet = $this->getMapper()->getDbTable()->fetchAll($where);
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
    
    public function getUsers()
    {
    	 $entries=$this->fetchAll();    	 
         $array=array();
         $array['']='--- Select Author ---';
         foreach($entries as $entry)
         {        
         	$array[$entry->getId()]=$entry->getFirstName()." ".$entry->getLastName();	
         }
         return $array;
    }
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }

    
    public function getBanner($position, $bannerId=null)
    {
    	$where="Published='1' AND Position='{$position}'  ";
    	if(!is_null($bannerId))
    		$where.=" and Id='{$bannerId}'";
    		
  		$banner = new Cms_Model_Banner();
        $banners = $banner->fetchAll($where);
        return $banners ;
    }


    public function showBanner($position, $width, $height, $bannerId=null)
    {
        $banners=$this->getBanner($position, $bannerId);

                if(count($banners)>0){
                foreach($banners as $_banner){
                        ?>
                        <div class="<?php echo $_banner->getPosition()?>-adds">
                        <?php

                                if($_banner->getBannerType()=="text")
                                {
                                ?>
                                        <?php echo $_banner->getDescription()?>
                                <?php
                                }else{

                                ?>
                            <a target="_blank" href="<?php echo $_banner->getUrl();?>">
                                <img height="<?php echo $height?>" width="<?php echo $width?>" src="/media/banner/<?php echo $_banner->getImage();?>" alt="<?php echo $_banner->getTitle();?>" />
                            </a>
                                <?php
                                }
                        ?>
                        </div>
                        <?php
                }//end of foreach loop
        }else{
                print "&nbsp;";
        }
    }
    
}

?>