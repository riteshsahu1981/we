<?php

class Application_Model_Blog
{
    protected $_id;
    protected $_title;
    protected $_status;
	protected $_weight;
    protected $_categoryId;
    protected $_location;
    protected $_tags;
    protected $_content;
    protected $_comment;
    protected $_publish;
    protected $_journalId;
    protected $_userId;
    protected $_featured;
    protected $_userObj;
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
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Blog property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Blog property');
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
            $this->setMapper(new Application_Model_BlogMapper());
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
    
	public function setStatus($status)
    {
        //$this->_status = (string) $status;
		$this->_status = (int) $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->_status;
    }
	
	public function setWeight($weight)
    {
        $this->_weight = (string) $weight;
        return $this;
    }

    public function getWeight()
    {
        return $this->_weight;
    }
    
	public function setCategoryId($categoryId)
    {
        $this->_categoryId = (int) $categoryId;
        return $this;
    }

    public function getCategoryId()
    {
        return $this->_categoryId;
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
    
	public function setTags($tags)
    {
        $this->_tags = (string) $tags;
        return $this;
    }

    public function getTags()
    {
        return $this->_tags;
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
    
    
    public function setComment($comment)
    {
    	$this->_comment=(string)$comment;
    	return $this;
    }
    
    public function getComment()
    {
    	return $this->_comment;
    }
	public function setPublish($publish)
    {
        $this->_publish = (string) $publish;
        return $this;
    }

    public function getPublish()
    {
        return $this->_publish;
    }
    
	public function setJournalId($journalId)
    {
        $this->_journalId = (int) $journalId;
        return $this;
    }

    public function getJournalId()
    {
        return $this->_journalId;
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
    

    public function setFeatured($featured)
    {
        $this->_featured = (int) $featured;
        return $this;
    }


    public function getFeatured()
    {
        return $this->_featured;
    }

    public function getUserObj()
    {
        return $this->_userObj;
    }
    
	public function setUserObj($userObj)
    {
        $this->_userObj = $userObj;
        return $this;
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
    	$user=$row->findParentRow('Application_Model_DbTable_User','User');
    	$model=new Application_Model_Blog();
        $model->setId($row->id)
                  ->setTitle($row->title)
                  ->setStatus($row->status)
				  ->setWeight($row->weight)
                  ->setCategoryId($row->category_id)
                  ->setLocation($row->location)
                  ->setTags($row->tags)
                  ->setContent($row->content)
                  ->setComment($row->comment)
                  ->setPublish($row->publish)
                  ->setJournalId($row->journal_id)
                  ->setFeatured($row->featured)
                  ->setUserId($row->user_id)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ->setUserObj($user)
                  ;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
            'title'   => $this->getTitle(),
  	  		'status'	=> $this->getStatus(),
			'weight'	=> $this->getWeight(),
  	  		'category_id'	=>$this->getCategoryId(),
  	  		'location'	=>$this->getLocation(),
  	  		'tags'=>$this->getTags(),
  	  		'content'=>$this->getContent(),
  	  		'comment'=>$this->getComment(),
  	  		'publish'=>$this->getPublish(),
  	  		'journal_id'=>$this->getJournalId(),
                        'featured'=>$this->getFeatured(),
  	  		'user_id'=>$this->getUserId()
  	  		
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
    
  
    /*----Data Manupulation functions ----*/
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 3-Nov-2010
	 * @Description	: Get recent blogs
	 * @Param		: int - number of logs
	 * @Return		: array
	 */
	public function getRecentBlogs($limit)
	{
		//create database object
		$db		 =	Zend_Registry::get('db');
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$blogs	 =	array();
		$sql	 =	" SELECT B.id, B.title, B.status, B.journal_id, B.user_id, B.addedon FROM blog AS B";
		$sql	.=	" JOIN journal AS J ON J.id = B.journal_id";
		//$sql	.=	" WHERE B.status = 5 AND B.publish = 'published'";
		$sql	.=	" WHERE B.publish = 'published'";
		$sql	.=	" AND J.status = 'public' AND J.publish = 'published'";
		//$sql	.=	" ORDER BY B.addedon DESC LIMIT 0, $limit";
		$sql	.=	" ORDER BY B.addedon DESC";
		//$blogs	 =	$db->fetchAll($sql);
		
		//get filtered Journals, i.e. Journals based on their Author permissions
		$page		= 1;
		$page_size	= $limit;
		$pageObj	= new Base_Paginator();
		$blogs		= $pageObj->fetchBlogData($sql, $page, $page_size);
		//$blogs		= $pageObj->fetchPageDataRaw($sql, $page, $page_size);
		
		return $blogs;
	}//end of function
	
	
	public function getRecentBlogsByUserId($userId, $limit)
	{
		//create database object
		$db		 =	Zend_Registry::get('db');
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$blogs	 =	array();
		$sql	 =	" SELECT B.id, B.title, B.status, B.journal_id, B.user_id, B.addedon FROM blog AS B";
		$sql	.=	" JOIN journal AS J ON J.id = B.journal_id";
		$sql	.=	" WHERE B.status = 5 AND B.publish = 'published'";
		$sql	.=	" AND J.status = 'public' AND J.publish = 'published'";
		$sql	.=	" AND J.user_id = '$userId' AND B.user_id= '$userId'";
		//$sql	.=	" ORDER BY B.addedon DESC LIMIT 0, $limit";
		$sql	.=	" ORDER BY B.addedon DESC";
		//$blogs	 =	$db->fetchAll($sql);
		
		//get filtered Journals, i.e. Journals based on their Author permissions
		$page		= 1;
		$page_size	= $limit;
		$pageObj	= new Base_Paginator();
		$blogs		= $pageObj->fetchPageDataRaw($sql, $page, $page_size);
		
		return $blogs;
	}//end of function
	
	
	
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 30-Dec-2010
	 * @Description	: Get blog category from blog ID
	 * @Param		: int - blogID
	 * @Return		: array if found category else return false
	 */
	public function getBlogCategory($blogID)
	{
		$blogCategory = "";
		if(!is_null($blogID) && is_numeric($blogID))
		{
			$blogRes = $this->find($blogID);
			if(false!==$blogRes)
			{
				$category_id = $blogRes->getCategoryId();
				$categoryM = new Application_Model_Category();
				$whereCond = "id={$category_id} AND type='blog'";
				$categoryRes = $categoryM->fetchRow($whereCond);
				if(false!==$categoryRes)
				{
					$blogCategory = array("category_id"=>$categoryRes->getId(), "category_name"=> $categoryRes->getName());
					//print_r($blogCategory);
				}
			}
		}
		else
		{
			$blogCategory = false;
		}
		return	$blogCategory;
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 5-Jan-2011
	 * @Description	: Used to move blog information into deleted table and then delete original blog
	 * @Param		: int - blog ID
	 * @Return		: none
	 */
	public function deleteBlog($blog_id)
	{
		$db		= Zend_Registry::get("db");
		if(is_numeric($blog_id))
		{
			//move original blog into deleted table
			$sSQL	= "INSERT INTO blog_deleted SELECT * FROM blog WHERE id={$blog_id}";
			$db->query($sSQL);
			
			//delete original blog from blog table
			$this->delete("id={$blog_id}");
		}	
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 28-Mar-2011
	 * @Description	: Used to create journal blog status check
	 * @Param		: int - $userId, int-$loggedinUserId
	 * @Return		: string
	 */
	public function getUserSharedBlogs($userId, $loggedinUserId)
	{
		$strPermission = "(";
		$strPermission .= "5"; //select default public
		
		//if user is Logged In then GD community permission will applicable automatically
		if($loggedinUserId!="")
		{
			$strPermission .= ",1";
		}
		//get user connection
		$objModelUser = new Application_Model_User();
		$relation = $objModelUser->getUserConnection($userId, $loggedinUserId);
		if(false!==$relation)
		{
			switch ($relation)
			{
				case 'own':
					//$strPermission .= " OR status=2 OR status=1 OR status=3 OR status=4";
					$strPermission .= ",2,4,6";
				break;
				case 'friend':
					$strPermission .= ",2,6";
				break;
				case 'family':
					$strPermission .= ",6";
				break;
			}
		}	
		$strPermission .= ")";
		return $strPermission;
	}//end function
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 28-Mar-2011
	 * @Description	: Used to check individual blog permission check
	 * @Param		: int - $userId, int-$loggedinUserId, int-$blogPermission
	 * @Return		: boolean
	 */
	public function checkBlogPrivacySettings($userId, $loggedinUserId, $blogPermission=0)
	{
		$strPermissionArr = array(5); //select default public
		$view = false;
		
		//if user is Logged In & Permission is 1 (GD community)
		if($loggedinUserId!="" && $blogPermission==1)
		{
			$strPermissionArr = array(1,5);
		}
		
		$objModelUser = new Application_Model_User();
		$relation = $objModelUser->getUserConnection($userId, $loggedinUserId);
		if(false!==$relation)
		{
			switch ($relation)
			{
				case 'own':
					$strPermissionArr = array(1,2,4,5,6);
				break;
				case 'friend':
					$strPermissionArr = array(1,2,5,6);
				break;
				case 'family':
					$strPermissionArr = array(1,5,6);
				break;
			}
		}
		if(in_array($blogPermission, $strPermissionArr))
		{
			$view = true;
		}
		return $view;
	}//end function
}

