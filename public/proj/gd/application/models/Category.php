<?php

class Application_Model_Category
{
    protected $_id;
    protected $_name;
    protected $_status;
    protected $_type;
	protected $_urlText;
	protected $_urlLink;
    protected $_description;
    protected $_image;
    protected $_parentId;
    protected $_addedon;
    protected $_updatedon;
	protected $_weight = 0;
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
            $this->setMapper(new Application_Model_CategoryMapper());
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
    
	public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->_status;
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
	
	public function setUrlText($urlText)
    {
        $this->_urlText = (string) $urlText;
        return $this;
    }
    public function getUrlText()
    {
        return $this->_urlText;
    }
	
	public function setUrlLink($urlLink)
    {
        $this->_urlLink = (string) $urlLink;
        return $this;
    }
    public function getUrlLink()
    {
        return $this->_urlLink;
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
    
	public function setImage($image)
    {
        $this->_image = (string) $image;
        return $this;
    }

    public function getImage()
    {
        return $this->_image;
    }
	public function setParentId($parentId)
    {
        $this->_parentId = (int) $parentId;
        return $this;
    }

    public function getParentId()
    {
        return $this->_parentId;
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
	
	public function setWeight($weight)
    {
        $this->_weight = (int) $weight;
        return $this;
    }
    public function getWeight()
    {
        return $this->_weight;
    }
    /*----Data Manupulation functions ----*/
    
    
    private function setModel($row)
    {
    	$model=new Application_Model_Category();
        $model->setId($row->id)
                ->setName($row->name)
				->setStatus($row->status)
				->setParentId($row->parent_id)
				->setType($row->type)
				->setUrlText($row->url_text)
				->setUrlLink($row->url_link)
				->setImage($row->image)
				->setDescription($row->description)
				->setAddedon($row->addedon)
				->setUpdatedon($row->updatedon)
				->setWeight($row->weight)
				;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
            'name'   => $this->getName(),
  	  		'status'	=> $this->getStatus(),
  	  		'parent_id'	=>$this->getParentId(),
  	  		'description'	=>$this->getDescription(),
  	 		'image'=>$this->getImage(), 		
  	  		'type'	=>$this->getType(),
			'url_text'	=>$this->getUrlText(),
			'url_link'	=>$this->getUrlLink(),
			'weight'	=>$this->getWeight(),
        );

        if (null === ($id = $this->getId()))
		{
            unset($data['id']);
             $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
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
	public function getCategory($option=null, $type="other", $status="published")
    {
    	$arrLang=array();
    	if(!is_null($option))
    		$arrLang[''] = $option;
    	
    		if($type=="work-study-volunteer"){
    			
    			$where="type in ('work', 'study', 'volunteer') and status='{$status}'";
    		}else
    		{
				$where="type='{$type}' and status='{$status}'";
    	
    		}
		$Category=$this->fetchAll($where, "name ASC");
		foreach($Category as $row)
		{
			$arrLang[$row->getId()]=$row->getName();
		}   
		return $arrLang;  	
    }    
    
    public function getArticlesCategory($option='--Please Select--')
    {
    	
			$category = (array($option,"Work" => $this->getCategory(null, "work"),
                             "Study"=>$this->getCategory(null, 'study'),
    	                     "Volunteer"=>$this->getCategory(null,'volunteer')
    	    ));
    	       
    	    return $category;
	}    
	
    public function getJournalCategory()
    {
    	$categories=$this->getCategory(null,"blog");	
    	if(count($categories)==0)
    	return false;
    	
		$db=Zend_Registry::get('db');
    	
		$arrCat=array();
    	$i=0;
		foreach($categories as $id=>$name)
		{
			/*$select = $db->select();
       	 	$select->from(array('b' => 'blog'),'COUNT(b.id) AS num');
			$select->join(array('j' => 'journal'),'j.id = b.journal_id');
       	 	//$select->where("b.category_id='{$id}' AND b.status=5 AND b.publish='published'");
			$select->where("b.category_id='{$id}' AND b.publish='published'");
			$select->where("j.status='public' AND j.publish='published'");			
			*/
			$arrCat[$i]['id']				=	$id;
        	$arrCat[$i]['category_name']	=	$name;
        	//$arrCat[$i]['total_blogs']	=	$db->fetchRow($select)->num;
			$arrCat[$i]['total_blogs']	=	$this->countCategoryPosts($id);
        	$i++;
		}
		
		return $arrCat;
    }
    /**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 3-Nov-2010
	 * @Description	: Count number of post for a particular category with permission check
	 * @Input		: int - category id
	 * @Return		: Int - number of post
	 */
	public function countCategoryPosts($category_id)
	{
		//create database object
		$db		 =	Zend_Registry::get('db');
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$total_blogs	 =	0;
		$sql	 =	"SELECT b.id, b.user_id, b.status FROM blog AS b";
		$sql	.=	" JOIN journal AS j ON j.id = b.journal_id";
		//$sql	.=	" WHERE b.status = 5 AND b.publish = 'published'";
		$sql	.=	" WHERE b.publish = 'published'";
		$sql	.=	" AND j.status = 'public' AND j.publish = 'published'";
		$sql	.=	" AND b.category_id=$category_id";
		
		$blogs	 =	$db->fetchAll($sql);
		
		if(count($blogs)>0)
		{
			$userNs 			= new Zend_Session_Namespace('members');
			$loggedin_id		= $userNs->userId;
				
			foreach($blogs AS $blog)
			{
				$view_my_journal 	= false;
				$blogM				= new Application_Model_Blog();
				$view_my_journal	= $blogM->checkBlogPrivacySettings($blog->user_id, $loggedin_id, $blog->status);
				
				if($view_my_journal)
				{
					$total_blogs = $total_blogs+1;
				}
			}
		}
		return $total_blogs;
	}
	
    public function getWorkCategories($option=null)
    {
    	 $obj=new Application_Model_Category();
         $entries=$obj->fetchAll();
         $arrContinent=array();
         if(!is_null($option))
         $arrContinent['']=$option;
         foreach($entries as $entry)
         {         
         	$arrContinent[$entry->getId()]=$entry->getName();	
         }
         return $arrContinent;
    }
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 5-Jan-2011
	 * @Description	: Used to move article/blog information into deleted tables and then delete original article/blog
	 * @Param		: int - Category ID
	 * @Return		: none
	 */
	public function deleteCategoryData($cat_id)
	{
		$db		= Zend_Registry::get("db");
		if(is_numeric($cat_id))
		{
			//move articles into deleted table associated with category
			$adSQL	= "INSERT INTO articles_deleted SELECT * FROM articles WHERE category_id={$cat_id}";
			$db->query($adSQL);
			
			//now delete original Articles from table
			$delArticleSQL	= "DELETE FROM articles WHERE category_id={$cat_id}";
			$db->query($delArticleSQL);
			
			//move blogs into deleted table associated with category
			$dbSQL	= "INSERT INTO blog_deleted SELECT * FROM blog WHERE category_id={$cat_id}";
			$db->query($dbSQL);
			
			//now delete blog from original blog table
			$delBlogSQL	= "DELETE FROM blog WHERE category_id={$cat_id}";
			$db->query($delBlogSQL);
			
			//move advice into deleted table associated with category
			$adviceSQL	= "INSERT INTO advice_deleted SELECT * FROM advice WHERE category_id={$cat_id}";
			$db->query($adviceSQL);
			
			//now delete advice from original advice table
			$delAdviceSQL	= "DELETE FROM advice WHERE category_id={$cat_id}";
			$db->query($delAdviceSQL);
		}
	}//end function
    
	//delete all SEO URLs related to category
	public function updateRelatedSeoUrls($cat_id)
	{
		if($cat_id!="")
		{
			$cateRes = $this->find($cat_id);
			if(false!==$cateRes)
			{
				$category_type = $cateRes->getType();
				
				if($category_type=="advice")
				{
					$categoryType = "/advice/";
				}
				else if($category_type=="wsv")
				{
					$categoryType = "/work-study-volunteer/";
				}
				else
				{
					$categoryType = "/".$category_type."/";
				}
				
				//now delete all SEO URLS for this category
				$db = Zend_Registry::get("db");
				$sSQL = "DELETE FROM seo_url WHERE actual_url LIKE '%{$categoryType}%'";
				$db->query($sSQL);
				return true;
			}//if		
		}
		else
		{
			return false;
		}	
	}//end function
}

