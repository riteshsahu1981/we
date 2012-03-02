<?php

class Application_Model_Vote
{
    protected $_id;
    protected $_vote;
    protected $_itemType;
    protected $_itemId;
    protected $_addedon;
    protected $_updatedon;
    protected $_userId;
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
            $this->setMapper(new Application_Model_VoteMapper());
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
    
    public function setVote($vote)
    {
        $this->_vote = (int) $vote;
        return $this;
    }

    public function getVote()
    {
        return $this->_vote;
    }

	public function setVoteType($voteType)
    {
        $this->_voteType= (string) $voteType;
        return $this;
    }

    public function getVoteType()
    {
        return $this->_voteType;
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
    	$model=new Application_Model_Vote();
     	$model->setId($row->id)
                  ->setVote($row->vote)
                  ->setItemType($row->item_type)
                  ->setItemId($row->item_id)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ->setUserId($row->user_id)
                   ;
             return $model;
    }
    
    public function save()
    {
    
        $data = array(
        'vote'   => $this->getVote(),
        'item_type' => $this->getItemType(),
        'item_id' => $this->getItemId(),
        'user_id' => $this->getUserId(),
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
            return;
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
    
    public function numVotes($item_type, $item_id = null)
    {
    	$where = " item_type = '$item_type' AND vote=1";
    	if($item_id)
    	{
    		$where .= " AND item_id = '$item_id' ";
    	}
    	$resultSet = $this->fetchAll($where);
    	return count($resultSet);
    	//$resultSet = $this->getMapper()->getDbTable()->($where);    	
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

    public function getTotalVotes($item_id,$item_type, $vote=null, $user_id=null)
    {
    	
    	$where = "item_type='$item_type' and  item_id='$item_id'";
     	if(!is_null($user_id))
    	$where.=" and user_id='{$user_id}'";
    	
    	if(!is_null($vote))
    	$where.=" and vote='{$vote}'";
    	
        $dbTable=$this->getMapper()->getDbTable();
        $select = $dbTable->select();
        $select->from('vote','COUNT(*) AS num');
        	$select->where($where);
         $numrow= $dbTable->fetchRow($select)->num;
        return $numrow;
    }

    public function getUserVotes($item_id,$item_type, $vote=null)
    {

    	$where = "item_type='$item_type' and  item_id='$item_id'";

    	if(!is_null($vote))
    	$where.=" and vote='{$vote}'";

        $dbTable=$this->getMapper()->getDbTable();
        $select = $dbTable->select();
        $select->from('vote','COUNT(*) AS num');
        	$select->where($where);
         $numrow= $dbTable->fetchRow($select)->num;
        return $numrow;
    }

    public function getTotalUp($user_id)
    {
        $where="user_id='{$user_id}' and vote='1' ";
        $dbTable=$this->getMapper()->getDbTable();
        $select = $dbTable->select();
        $select->from('vote','COUNT(*) AS num');
        $select->where($where);
      	$res=$dbTable->fetchRow($select);
   		return $res->num;
    }
    
    public function getTotalDown($user_id)
    {
        $where="user_id='{$user_id}' and vote='-1'  ";
        $dbTable=$this->getMapper()->getDbTable();
        $select = $dbTable->select();
        $select->from('vote','COUNT(*) AS num');
        $select->where($where);
      	$res=$dbTable->fetchRow($select);
        return $res->num;
    }
    

    public function getTotalVotesGroup($item_id,$item_type, $vote=null, $user_id=null)
    {
		
    	$where="item_type='{$item_type}'";
    	if(is_array($item_id))
    	{
    		 $itemIds=implode(",",$item_id);
    		  $where.=" and item_id in ({$itemIds}) ";
    	}
    	else
    	{
    		$where.=" and item_id = '{$item_id}' ";
    	}
    	
    	if(!is_null($user_id))
    		$where.=" and user_id='{$user_id}'";
    	
    	if(!is_null($vote))
    		$where.=" and vote='{$vote}'";
    	
         $dbTable=$this->getMapper()->getDbTable();
        $select = $dbTable->select();
        $select->from('vote',array('COUNT(*) AS num', 'item_id'));
      	$select->where($where);
       	$select->group('item_id');
        $select->order('num desc');
       	
    	
        return $dbTable->fetchAll($select);
    }
    
    
    public function getTotalVotesSum($item_id,$item_type)
    {
    	$where="item_type='{$item_type}' ";
    	if(is_array($item_id))
    	{
    		$itemIds=implode(",",$item_id);
    		$where.=" and item_id in ({$itemIds}) ";
    	}
    	else
    	{
    		$where.=" and item_id = '{$item_id}' ";
    	}
    	
        $dbTable=$this->getMapper()->getDbTable();
        $select = $dbTable->select();
        $select->from('vote',array('sum(vote) AS num', 'item_id'));
       	$select->where($where);
       	$select->group('item_id');
       	$select->order('num desc');
    	
        return $dbTable->fetchAll($select);
    }
}

