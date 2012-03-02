<?php
class Application_Model_Tags
{
    protected $_id;
    protected $_tag;
    
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
            throw new Exception('Invalid City property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Tag property');
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
            $this->setMapper(new Application_Model_TagsMapper());
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
    
    public function setTag($tag)
    {
        $this->_tag = (string) $tag;
        return $this;
    }

    public function getTag()
    {
        return $this->_tag;
    }
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model=new Application_Model_Tags();
        $model->setId($row->id)
                  ->setTag($row->tag)
                  
                  ;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
            'tag'   => $this->getTag()  	  		
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
             
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
        	
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
    
    public function getCity($option=null, $countryId=null)
    {
    	$arrLang=array();
    	if(!is_null($option))
    		$arrLang['']=$option;
    		
		$where="country_id='{$countryId}'";
    	if(is_null($countryId)){
    		$where="1=1";
    	}
    	
		$City=$this->fetchAll($where);
		foreach($City as $row)
		{
			$arrLang[$row->getId()]=$row->getName();
		}   
		return $arrLang;  	
    }
    
    /*----Data Manupulation functions ----*/

	public function getTagArray($countryId=null)
    {
    	$arrCity=Array();
    	$where="country_id='{$countryId}'";
    	if(is_null($countryId)){
    		$where="1=1";
    	}
		$City=$this->fetchAll($where);
		foreach($City as $row)
		{
      		$arrCity[$row->getId()]=$row->getName();
		}
		return $arrCity;
    }
    
    public function getBlogTags($blog_id=null,$raw=false, $permission_flag=true)
    {
    	if(!is_null($blog_id))
		{
    		$where =" AND c.id='{$blog_id}'";
    	}
   	 	$db=Zend_Registry::get('db');
		//$sql="select a.id, a.tag from tags as a, blog_tag as b , blog  as c where b.blog_id=c.id and b.tag_id=a.id {$where} ";

		$sql = "SELECT DISTINCT(a.id), a.tag FROM tags AS a, blog_tag AS b, blog AS c";
		$sql .= " WHERE b.blog_id=c.id AND b.tag_id=a.id";
		if($permission_flag===true)
		{
			//$sql .= " AND c.publish='published' AND c.status=5";
			$sql .= " AND c.publish='published'";
		}	
		else
		{
			$sql .= " AND c.publish='published' ";
		}	
		$sql .= $where;
		
		$tags=$db->fetchAll($sql);
		$tagStr="";
		if(count($tags)>0)
		{
			foreach($tags as $_tag)
			{
				if(false===$raw)
				{
					if($_tag->tag != "")
					{
						//$tagStr.='<a href="/journal/index/search-cloud/'.$_tag->tag.'">'.$_tag->tag."</a>, ";
						
						//above line commented by Mahipal on 25-mar-2011, to create seo url for tags
						$objSEO = new Base_View_Helper_SeoUrl();
						$tag_seo_url = $objSEO->seoUrl("/journal/index/search-cloud/{$_tag->id}");
						$tagStr.='<a href="'.$tag_seo_url.'">'.$_tag->tag.'</a>, ';
					}	
				}
				else
				{
					$tagStr.=$_tag->tag.", ";
				}
			}//end foreach
			$tagStr=substr($tagStr,0,strlen($tagStr)-2);
		}//end if
		return $tagStr;
    }
    
    
    public function getTagCloud($limit=null)
	{
    	if(!is_null($limit))
		{
    		$limit="  limit {$limit}";
    	}
		/**
		 * Following query has been modified by Mahipal Adhikari on 22-Nov-2010 to status & published condition check on Blog/Journals.
		 */
   	 	$db	= Zend_Registry::get('db');
		$sql = "SELECT DISTINCT(a.id), a.tag FROM tags AS a, blog_tag AS b, blog AS c";
		$sql .= " LEFT JOIN journal AS j ON j.id=c.journal_id";
		$sql .= " WHERE b.blog_id=c.id AND b.tag_id=a.id";
		$sql .= " AND a.tag IS NOT NULL";
		//$sql .= " AND c.publish='published' AND c.status=5";
		$sql .= " AND c.publish='published'"; //get only published blog tags
		$sql .= " AND j.status='public' AND j.publish='published'";
		$sql .= " ORDER BY a.tag";
		$sql .= " {$limit}";
		$tags = $db->fetchAll($sql);
		
		$tagStr = "";
		if(count($tags)>0)
		{
			foreach($tags as $_tag)
			{
				if($_tag->tag != "")
				{
					//$tagStr.='<a href="/journal/index/search-cloud/'.$_tag->tag.'">'.$_tag->tag."</a>, ";
					
					//above line commented by Mahipal on 25-mar-2011, to create seo url for tags
					$objSEO = new Base_View_Helper_SeoUrl();
					$tag_seo_url = $objSEO->seoUrl("/journal/index/search-cloud/{$_tag->id}");
					$tagStr.='<a href="'.$tag_seo_url.'">'.$_tag->tag.'</a>, ';
				}
			}
			$tagStr = substr($tagStr,0,strlen($tagStr)-2);
		}
		return $tagStr;
    }
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 22-Feb-2011
	 * @Description: get blog tags for edit blogs
	 */
	public function getTagsForEdit($blog_id=null)
    {
    	$tagStr	=	"";
		if(!is_null($blog_id))
		{
    		$db	=	Zend_Registry::get('db');
			
			$sql  = "SELECT DISTINCT(t.id), t.tag FROM tags AS t";
			$sql .= " INNER JOIN blog_tag AS bt ON bt.tag_id=t.id";
			$sql .= " WHERE t.id IS NOT NULL";
			$sql .= " AND bt.blog_id={$blog_id}";
		
			$tags	=	$db->fetchAll($sql);
			
			if(count($tags)>0)
			{
				foreach($tags as $_tag)
				{
					$tagStr .= $_tag->tag.", ";
				}//end foreach
				
				$tagStr	=	substr($tagStr,0,strlen($tagStr)-2);
			}//end if
		}//end if
		return $tagStr;
		
    }//end function
}
