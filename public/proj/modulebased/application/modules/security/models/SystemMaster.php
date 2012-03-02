<?php
class Security_Model_SystemMaster {
    
    protected $_id;
    protected $_masterCode;
    protected $_masterId;
    protected $_masterValue;
    protected $_status = 1;
    protected $_intval1 = 0;
    protected $_intval2 = 0;
    protected $_strval1 = "";
    protected $_strval2 = "";
    protected $_blnval1 = 0;    
    protected $_blnval2= 0;
    protected $_dblval1 = 0.00;
    protected $_dblval2 = 0.00;
    protected $_createdOn;
    protected $_createdBy;
    protected $_updatedOn;
    protected $_updatedBy;
    protected $_rowGuid;
    protected $_mapper;
    protected $_rowVersion;
    protected $_rowMaxId;

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
            throw new Exception('Invalid property specified '. $method);
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified ' . $method);
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
            $this->setMapper(new Security_Model_SystemMasterMapper());
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

    public function setMasterCode($masterCode)
    {
        $this->_masterCode = (string) $masterCode;
        return $this;
    }

    public function getMasterCode()
    {
        return $this->_masterCode;
    }
    
    public function setMasterId($masterId)
    {
        $this->_masterId = (int) $masterId;
        return $this;
    }

    public function getMasterId()
    {
        return $this->_masterId;
    }

    public function setMasterValue($masterValue)
    {
        $this->_masterValue = (string) $masterValue;
        return $this;
    }

    public function getMasterValue()
    {
        return $this->_masterValue;
    }
    
       

    public function getStatus()
    {
        return $this->_status;
    }
 
    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }
    
    public function setIntval1($intval1)
    {
        $this->_intval1 = (int) $intval1;
        return $this;
    }

    public function getIntval1()
    {
        return $this->_intval1;
    } 
    
    public function setIntval2($intval2)
    {
        $this->_intval2 = (int) $intval2;
        return $this;
    }

    public function getIntval2()
    {
        return $this->_intval2;
    } 
    
    public function setStrval1($strval1)
    {
        $this->_strval1 = (string) $strval1;
        return $this;
    }

    public function getStrval1()
    {
        return $this->_strval1;
    } 
    
    public function setStrval2($strval2)
    {
        $this->_strval2 = (string) $strval2;
        return $this;
    }

    public function getStrval2()
    {
        return $this->_strval2;
    } 
    
    public function setBlnval1($blnval1)
    {
        $this->_blnval1 = (boolean) $blnval1;
        return $this;
    }

    public function getBlnval1()
    {
        return $this->_blnval1;
    }
    
    public function setBlnval2($blnval2)
    {
        $this->_blnval2 = (boolean) $blnval2;
        return $this;
    }

    public function getBlnval2()
    {
        return $this->_blnval2;
    }
    
    public function setDblval1($dblval1)
    {
        $this->_dblval1 = (double) $dblval1;
        return $this;
    }

    public function getDblval1()
    {
        return $this->_dblval1;
    }
    
    public function setDblval2($dblval2)
    {
        $this->_dblval2 = (double) $dblval2;
        return $this;
    }

    public function getDblval2()
    {
        return $this->_dblval2;
    }
    
    public function setCreatedOn($createdOn)
    {
        $this->_createdOn = (int) $createdOn;
        return $this;
    }  
    public function getCreatedOn()
    {
        return $this->_createdOn;
    }
    
    public function setCreatedBy($createdBy)
    {
        $this->_createdBy = (int) $createdBy;
        return $this;
    }  
    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    public function setUpdatedOn($updatedOn)
    {
        $this->_updatedOn = (int) $updatedOn;
        return $this;
    }
    
    public function getUpdatedOn()
    {
        return $this->_updatedOn;
    }
    
    public function setUpdatedBy($updatedBy)
    {
        $this->_updatedBy = (int) $updatedBy;
        return $this;
    }
    
    public function getUpdatedBy()
    {
        return $this->_updatedBy;
    }

    public function setRowGuid($rowGuid)
    {
        $this->_rowGuid = (string) $rowGuid;
        return $this;
    }
    
    public function getRowGuid()
    {
        return $this->_rowGuid;
    }

    public function getRowMaxId()
    {
        return $this->_rowMaxId;
    }

    public function setRowMaxId($rowMaxId)
    {
        $this->_rowMaxId= (int) $rowMaxId;
        return $this;
    }
    public function getRowVersion()
    {
        return $this->_rowVersion;
    }

    public function setRowVersion($rowVersion)
    {
        $this->_rowVersion= (int) $rowVersion;
        return $this;
    }

  /*----Data Manupulation functions ----*/
    
    public function setModel($row)
    {
      $model = new Security_Model_SystemMaster();
      $model  ->setMasterCode($row->master_code)
              ->setMasterId($row->master_id)
              ->setMasterValue($row->master_value)
              ->setStatus($row->status)
              ->setIntval1($row->intval1)
              ->setIntval2($row->intval2)
              ->setStrval1($row->strval1)
              ->setStrval2($row->strval2)
              ->setBlnval1($row->blnval1)
              ->setBlnval2($row->blnval2)
              ->setDblval1($row->dblval1)
              ->setDblval2($row->dblval2)
              ->setCreatedOn($row->created_on)
              ->setCreatedBy($row->created_by)
              ->setUpdatedOn($row->updated_on)
              ->setUpdatedBy($row->updated_by)
              ->setRowGuid($row->row_guid)
              ->setRowVersion($row->row_version)
              
              ;
             return $model;
    }
    
    public function save()
    {
        $usersNs = new Zend_Session_Namespace("members");  
        
     	$data = array(
                'master_code'  		=> $this->getMasterCode(),
                'master_value' 		=> $this->getMasterValue(),
        	'status'		=> $this->getStatus(),
                'intval1'               => $this->getIntval1(),
                'intval2'               => $this->getIntval2(),
                'strval1'               => $this->getStrval1(),
                'strval2'               => $this->getStrval2(),
                'blnval1'               => $this->getBlnval1(),
                'blnval2'               => $this->getBlnval2(),
                'dblval1'               => $this->getDblval1(),
                'dblval2'               => $this->getDblval2()                
                );

        if (null === ($master_id = $this->getMasterId())) 
        {
            $Db=new Base_Db();
            $master_id=$Db->genSystemMasterId($this->getMasterCode());
            if(false!==$master_id)
            {
                $data['master_id']=$master_id;
                $data['created_by']=$usersNs->userId;
                $data['row_guid']=Base_Uuid::guid();
                $data['created_on']=time();
                $data['row_version']=0;
                if($this->getMapper()->getDbTable()->insert($data))
                {
                   return $master_id; 
                }
            }
            else
            {
                return false;
            }
        } 
        else 
        {
           
            $data['updated_by']=$usersNs->userId;
            $data['updated_on']=time();
            $data['row_version']=$this->getRowVersion() + 1;
             
            $res=$this->getMapper()->getDbTable()->update($data, array("master_code='{$this->getMasterCode()}' and master_id = '{$master_id}' and row_version = '{$this->getRowVersion()}'" ));
            
            if(1==$res)
                return true;
            else
                return false;
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
    
    public function isExist($where)
    {
    	$res=$this->fetchRow($where);

    	if($res===false)
       	{
            return false;
       	}
       	else 
       	{
            return true;
       	}
    }
    
   
    /*----Data Manupulation functions ----*/

    
  
}
