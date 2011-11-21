<?php
class Application_Model_Project {

    protected $_id;
    protected $_title;
    protected $_description;
    protected $_clientInfo;
    protected $_startDate;
    protected $_endDate;
    protected $_status;
    protected $_projectUsers;
    protected $_projectManagerId;
    protected $_teamLeaderId;
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
            $this->setMapper(new Application_Model_ProjectMapper());
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
    
    public function setDescription($description)
    {
        $this->_description = (string) $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->_description;
    }
    public function setClientInfo($clientInfo)
    {
        $this->_clientInfo = (string) $clientInfo;
        return $this;
    }

    public function getClientInfo()
    {
        return $this->_clientInfo;
    }
    
    public function setStartDate($startDate)
    {
        $this->_startDate = (string) $startDate;
        return $this;
    }

    public function getStartDate()
    {
        return $this->_startDate;
    }
    
    public function setEndDate($endDate)
    {
        $this->_endDate = (string) $endDate;
        return $this;
    }

    public function getEndDate()
    {
        return $this->_endDate;
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
    
    public function setProjectManagerId($projectManagerId)
    {
        $this->_projectManagerId = (int) $projectManagerId;
        return $this;
    }

    public function getProjectManagerId()
    {
        return $this->_projectManagerId;
    }

    public function setTeamLeaderId($teamLeaderId)
    {
        $this->_teamLeaderId = (int) $teamLeaderId;
        return $this;
    }

    public function getTeamLeaderId()
    {
        return $this->_teamLeaderId;
    }
    
    public function setProjectUsers($projectUsers)
    {
        $this->_projectUsers = $projectUsers;
        return $this;
    }

    public function getProjectUsers()
    {
        return $this->_projectUsers;
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

	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
            $model = new Application_Model_Project();
            $model->setId($row->id)
            ->setTitle($row->title)
            ->setDescription($row->description)
            ->setClientInfo($row->client_info)
            ->setStartDate($row->start_date)
            ->setEndDate($row->end_date)
            ->setStatus($row->status)
            ->setProjectManagerId($row->project_manager_id)
            ->setTeamLeaderId($row->team_leader_id)
            ->setAddedon($row->addedon)
            ->setUpdatedon($row->updatedon)
                	;
            
            /*find project resource*/
            
//            $projectUser=$row->findManyToManyRowset('Application_Model_DbTable_User','Application_Model_DbTable_ProjectUser');
//            $user=new Application_Model_User();
//            $arrUser=array();
//            foreach($projectUser as $_user)
//            {
//                $arrUser[]=$user->setModel($_user);
//                
//            }
//            $model->setUsers($arrUser);
            
            $projectUser=new Application_Model_ProjectUser();
            $table=$projectUser->getMapper()->getDbTable();
            $select = $table->select()->setIntegrityCheck(false)->from(array("pu"=>'project_user'),array('pustatus'=> 'status', 'user_id'))
                    ->join(array("u"=>'user'),'u.id=pu.user_id',array('first_name','last_name','middle_name','employee_code'))
                    ->join(array("p"=>'project'),'p.id=pu.project_id')
                    ->where("pu.project_id='{$row->id}'");
                    $model->setProjectUsers($table->fetchAll($select));
            /*------------------------*/
            
             return $model;
    }
    
    public function save()
    {
        $data = array(
            'title'   => $this->getTitle(),
            'description' => $this->getDescription(),
            'client_info' => $this->getClientInfo(),
            'start_date' => $this->getStartDate(),
            'end_date'  => $this->getEndDate(),
            'status'    => $this->getStatus(),
            'project_manager_id' =>$this->getProjectManagerId(),
            'team_leader_id' => $this->getTeamLeaderId()
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
        
    
 /*------Data utility functions------*/
    public function getProject()
    {
        $obj=new Application_Model_Project();
        $entries=$obj->fetchAll();
        $arrUserLevel=array();
        foreach($entries as $entry)
        { 	
            $arrUserLevel[$entry->getId()]=$entry->getTitle();
        }
        return $arrUserLevel;	
    }
    /*------Data utility functions------*/
    
    
    
}