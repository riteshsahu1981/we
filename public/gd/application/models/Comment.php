<?php

class Application_Model_Comment
{
    protected $_id;
    protected $_comment;
    protected $_parentId;
    protected $_itemType;
    protected $_itemId;
    protected $_addedon;
    protected $_updatedon;
    protected $_userId;
    protected $_publish;
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
            throw new Exception('Invalid game property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
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
            $this->setMapper(new Application_Model_CommentMapper());
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
    
    public function setComment($comment)
    {
        $this->_comment = (string) $comment;
        return $this;
    }

    public function getComment()
    {
        return $this->_comment;
		//return htmlentities($this->_comment);//modified by Mahipal Adhikari on 1-Apr-2011
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
    
	public function setPublish($publish)
    {
        $this->_publish= (int) $publish;
        return $this;
    }

    public function getPublish()
    {
        return $this->_publish;
    }

	public function setItemType($itemType)
    {
        $this->_itemType= (string) $itemType;
        return $this;
    }

    public function getItemType()
    {
        return $this->_itemType;
    }

    public function setItemId($itemId)
    {
        $this->_itemId = (int) $itemId;
        return $this;
    }

    public function getItemId()
    {
        return $this->_itemId;
    }	
    
	public function setUserId($userId)
    {
        $this->_userId= $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
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
    	$model=new Application_Model_Comment();
     	$model->setId($row->id)
                  ->setComment($row->comment)
                  ->setParentId($row->parent_id)
                  ->setItemType($row->item_type)
                  ->setItemId($row->item_id)
                  ->setPublish($row->publish)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ->setUserId($row->user_id)
                   ;
             return $model;
    }
    
    public function save()
    {
      	$data = array(
            'comment'   => $this->getComment(),
            'item_type' => $this->getItemType(),
        	'item_id' => $this->getItemId(),
        	'publish' => $this->getPublish(),
        	'user_id' => $this->getUserId(),
  	  		'parent_id' => $this->getParentId(),
        	
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
    
    public function numComments($item_type, $item_id = null)
    {
    	/*$where = " item_type = '$item_type' ";
    	if($item_id)
    	{
    		$where .= " and item_id = '$item_id' ";
    	}
    	$resultSet = $this->fetchAll($where);
    	return count($resultSet);*/


    	$db = Zend_Registry::get('db');
        $where = " item_type = '$item_type' ";
    	if($item_id)
    	{
    		$where .= " AND item_id = '$item_id' ";
    	}
		$where .= " AND publish='1'";//count only published comments
    	$select = $db->select()
             ->from('comment', 'count(id) as cnt')
             ->where($where);

	    $stmt = $db->query($select);
	    return $stmt->fetchColumn();
    }
    
    public function fetchRow($where)
    {
		echo $where;
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
    
    public function getTotalRecords($where){
   		
   		$dbTable=$this->getMapper()->getDbTable();
   		$select = $dbTable->select();
        $select->from('comment','COUNT(*) AS num');
        $select->where($where);
        $res=$dbTable->fetchRow($select);
   		return $res->num;
    }
    /*----Data Manupulation functions ----*/

    
	public function getPicturesCommentsUser($id,$limit=null,$user_id=null, $sort=null)
    {
    	//$id = picture id
    	$arrayPicId=array();
    	$order="id desc";
    	$commentM=new Application_Model_Comment();
        $where="item_id ='{$id}' and item_type='movie_user_image' and parent_id='0'";
        
    	if(!is_null($user_id))
    		$where.=" and user_id='{$user_id}'";
    	
    	if(!is_null($sort))
    	{
    		if( $sort!="recent")
    		{
	    		$comments=$commentM->fetchAll($where, $order );
	    		foreach($comments as $row)
				{
					$arrayPicId[]=$row->getId();
				}
    		}
    		else 
    		{
    			$comments=$commentM->fetchAll($where, $order, $limit );
    		}
			//$strPicId=implode(",",$arrayPicId);
    		
    		$voteM=new Application_Model_Vote();
    		$res=array();
			if($sort=="up")
			{
				$res=$voteM->getTotalVotesGroup($arrayPicId,'movie','user_movie_images_comments', 1, null);
			}
			else if($sort=="down")
			{
				$res=$voteM->getTotalVotesGroup($arrayPicId,'movie','user_movie_images_comments', -1, null);
			}
			else if($sort=="sum")
			{
				$res=$voteM->getTotalVotesSum($arrayPicId,'movie','user_movie_images_comments');
			}
			
			if(count($res)>0 && $sort!="recent")
			{
	    		unset($comments);
	    		$ctr=0;
				foreach($res as $row)
				{
					$ctr++;
					if(!is_null($limit))
					{
						if($limit<$ctr)	
							break;
					}
					$comments[]=$commentM->find($row->item_id);
					$usedIds[]=$row->item_id;
				}
				
				$remain=array_diff($arrayPicId,$usedIds);
				
				foreach($remain as $comment_id)
				{
					$ctr++;
					if(!is_null($limit))
					{
						if($limit<$ctr)	
							break;
					}
					$comments[]=$commentM->find($comment_id);
				}
			}
			
    	}
    	else
    	{
    		
    		$comments=$commentM->fetchAll($where, $order, $limit );
    	}
    	
    	return $comments;
    }
    
    
    
public function getActorCommentsUser($id,$limit=null,$user_id=null, $sort=null)
    {
    	//$id = picture id
    	$arrayPicId=array();
    	$order="id desc";
    	$commentM=new Application_Model_Comment();
        $where="item_id ='{$id}' and item_type='movie_actor' and parent_id='0'";
        
    	if(!is_null($user_id))
    		$where.=" and user_id='{$user_id}'";
    	
    	if(!is_null($sort))
    	{
    		if( $sort!="recent")
    		{
	    		$comments=$commentM->fetchAll($where, $order );
	    		foreach($comments as $row)
				{
					$arrayPicId[]=$row->getId();
				}
    		}
    		else 
    		{
    			$comments=$commentM->fetchAll($where, $order, $limit );
    		}
			//$strPicId=implode(",",$arrayPicId);
    		
    		$voteM=new Application_Model_Vote();
    		$res=array();
			if($sort=="up")
			{
				$res=$voteM->getTotalVotesGroup($arrayPicId,'movie_actor','user_movie_actor_comments', 1, null);
			}
			else if($sort=="down")
			{
				$res=$voteM->getTotalVotesGroup($arrayPicId,'movie_actor','user_movie_actor_comments', -1, null);
			}
			else if($sort=="sum")
			{
				$res=$voteM->getTotalVotesSum($arrayPicId,'movie_actor','user_movie_actor_comments');
			}
			
			if(count($res)>0 && $sort!="recent")
			{
	    		unset($comments);
	    		$ctr=0;
				foreach($res as $row)
				{
					$ctr++;
					if(!is_null($limit))
					{
						if($limit<$ctr)	
							break;
					}
					$comments[]=$commentM->find($row->item_id);
					$usedIds[]=$row->item_id;
				}
				
				$remain=array_diff($arrayPicId,$usedIds);
				
				foreach($remain as $comment_id)
				{
					$ctr++;
					if(!is_null($limit))
					{
						if($limit<$ctr)	
							break;
					}
					$comments[]=$commentM->find($comment_id);
				}
			}
			
    	}
    	else
    	{
    		
    		$comments=$commentM->fetchAll($where, $order, $limit );
    	}
    	
    	return $comments;
    }
    
    
    
public function getVideosCommentsUser($id,$limit=null,$user_id=null, $sort=null)
    {
    	//$id = picture id
    	$arrayVId=array();
    	
    	$order="id desc";
    	$commentM=new Application_Model_Comment();
        $where="item_id ='{$id}' and item_type='movie_user_video' and parent_id='0'";
        
    	if(!is_null($user_id))
    		$where.=" and user_id='{$user_id}'";
    	
    	if(!is_null($sort))
    	{
    		if( $sort!="recent")
    		{
	    		$comments=$commentM->fetchAll($where, $order );
	    		foreach($comments as $row)
				{
					$arrayVId[]=$row->getId();
				}
    		}
    		else 
    		{
    			$comments=$commentM->fetchAll($where, $order, $limit );
    		}
			//$strPicId=implode(",",$arrayPicId);
    		
    		$voteM=new Application_Model_Vote();
    		$res=array();
			if($sort=="up")
			{
				$res=$voteM->getTotalVotesGroup($arrayVId,'movie','user_movie_videos_comments', 1, null);
			}
			else if($sort=="down")
			{ 
				$res=$voteM->getTotalVotesGroup($arrayVId,'movie','user_movie_videos_comments', -1, null);
			}
			else if($sort=="sum")
			{
				$res=$voteM->getTotalVotesSum($arrayVId,'movie','user_movie_videos_comments');
			}
			
			if(count($res)>0 && $sort!="recent")
			{
	    		unset($comments);
	    		$ctr=0;
				foreach($res as $row)
				{
					$ctr++;
					if(!is_null($limit))
					{
						if($limit<$ctr)	
							break;
					}
					$comments[]=$commentM->find($row->item_id);
					$usedIds[]=$row->item_id;
				}
				
				$remain=array_diff($arrayVId,$usedIds);
				
				foreach($remain as $comment_id)
				{
					 $ctr++;
					if(!is_null($limit))
					{
						if($limit<$ctr)	
							break;
					}
					$comments[]=$commentM->find($comment_id);
				}
			}
			
    	}
    	else
    	{
    		
    		$comments=$commentM->fetchAll($where, $order, $limit );
    	}
    	
    	return $comments;
    }
    
    
    public function getCommentDate($format="H:i M dS Y")
    {
    	$Date=new Base_Date();
    	$Date->setSysDateFormat($format);
    	return $Date->getSysDate($this->getAddedon());	
    }
    
    
}

