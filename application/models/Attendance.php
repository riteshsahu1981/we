<?php
class Application_Model_Attendance {

    protected $_id;
    protected $_empCode;
    protected $_userId;
    protected $_attendance; // 1=present,0=absent,0.5=half
    protected $_attendanceDate;
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
            $this->setMapper(new Application_Model_AttendanceMapper());
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

   public function setEmpCode($empCode)
    {
        $this->_empCode = (string) $empCode;
        return $this;
    }

    public function getEmpCode()
    {
        return $this->_empCode;
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
    
    public function setAttendance($attendance)
    {
        $this->_attendance = (string) $attendance;
        return $this;
    }

    public function getAttendance()
    {
        return $this->_attendance;
    }
    
    public function setAttendanceDate($attendanceDate)
    {
        $this->_attendanceDate = (string) $attendanceDate;
        return $this;
    }

    public function getAttendanceDate()
    {
        return $this->_attendanceDate;
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
    	
    		
            $model = new Application_Model_Attendance();
            $model->setId($row->id)
                    ->setEmpCode($row->emp_code)
                    ->setUserId($row->user_id)
                    ->setAttendance($row->attendance)
                    ->setAttendanceDate($row->attendance_date)
                    ->setAddedon($row->addedon)
                    ->setUpdatedon($row->updatedon)
                	;
             return $model;
    }
    
    public function save()
    {
        $data = array(
            'emp_code'   => $this->getEmpCode(),
            'user_id'   => $this->getUserId(),
            'attendance' => $this->getAttendance(),
            'attendance_date'=>$this->getAttendanceDate()
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
    
    
    
    public function uploadAttendanceSheet()
    {
        $targetPath=false;
        $upload = new Zend_File_Transfer_Adapter_Http();
        if($upload->isValid('attendanceSheet'))
        {
            $upload->setDestination("media/attendance/");
            try
            {
                  $upload->receive('attendanceSheet');
             }
             catch (Zend_File_Transfer_Exception $e)
             {
                    $msg= $e->getMessage();
             }

             $upload->setOptions(array('useByteString' => false));

             $file_name = $upload->getFileName('attendanceSheet');
             $cardImageTypeArr = explode(".", $file_name);
             $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
             $target_file_name = "attendance_".date("Y_m_d_H_i_s").".{$ext}";
             $targetPath = 'media/attendance/'.$target_file_name;
             $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
             $filterFileRename -> filter($file_name);
             
             
        }
        return $targetPath;
    }
    
    public function importAttendance($options, $targetPath)
    {
       include_once LIBRARY_PATH."/Base/Excel/PHPExcel.php";
       $objPHPExcel = new PHPExcel();
       $objPHPExcel = PHPExcel_IOFactory::load($targetPath);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
        {
            if($worksheet->getTitle()=="Sheet1")
            {
                $rowctr=0;
                foreach ($worksheet->getRowIterator() as $row) 
                {
                        if($row->getRowIndex()==1)
                        {
                            $cellIterator = $row->getCellIterator();
                            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                            foreach ($cellIterator as $cell) 
                            {
                                if (!is_null($cell)) 
                                {
                                        if($cell->getCoordinate()=="A1")
                                            $columns[]= $cell->getCalculatedValue();
                                        else
                                            $columns[]= $options['year']."-".$options['month']."-".$cell->getCalculatedValue();
                                }
                            }
                        }
                        else
                        {
                           $cellIterator = $row->getCellIterator();
                            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                            $cellctr=0;
                            foreach ($cellIterator as $cell) 
                            {
                                if (!is_null($cell)) 
                                {
                                    if($cellctr==0)
                                    {
                                        $empCode=$cell->getCalculatedValue();
                                    }
                                    else
                                    {
                                        $user=new Application_Model_User();
                                        $user=$user->fetchRow("employee_code='{$empCode}'");
                                        if(false!==$user)
                                        {
                                            $attendance=new Application_Model_Attendance();
                                            $attendance=$attendance->fetchRow("user_id='".$user->getId()."' and attendance_date='".$columns[$cellctr]."'");
                                            if(false===$attendance)
                                            {
                                               //do insert
                                                if(trim($cell->getCalculatedValue())!="")
                                                {
                                                    $attendance=new Application_Model_Attendance();
                                                    $attendance->setEmpCode($empCode);
                                                    $attendance->setAttendance($cell->getCalculatedValue());
                                                    $attendance->setAttendanceDate($columns[$cellctr]);
                                                    $attendance->setUserId($user->getId());
                                                    $attendance->save();
                                                }
                                            }
                                            else
                                            {
                                                //do update
                                                if(trim($cell->getCalculatedValue())!="")
                                                {
                                                    $attendance->setEmpCode($empCode);
                                                    $attendance->setAttendance($cell->getCalculatedValue());
                                                    $attendance->setAttendanceDate($columns[$cellctr]);
                                                    $attendance->setUserId($user->getId());
                                                    $attendance->save();
                                                }
                                            }
                                        }
                                    }

                                }
                                  $cellctr++;  
                            }// end of cellIterator foreach
                            $rowctr++;
                        }
                }//end of row iterator foreach
            }// If worksheet = Sheet1 
        }// end of worksheet iterator foreach
        return $rowctr;
    }// end of function
    
    
    
    
    
    public function getMonthlyAttendance($m,$y,$userId)
    {
       $attendanceArr=Array();
       $date=date('Y-m',mktime(0,0,0,$m,1,$y));
       $attendance=$this->fetchAll("user_id='$userId' and DATE_FORMAT(attendance_date, '%Y-%m')='$date'");
       foreach($attendance as $_attendance)
       {
            if($_attendance->getAttendance()=="1")
                $status="Present";
            elseif($_attendance->getAttendance()=="0")
                $status="Absent";
            elseif($_attendance->getAttendance()=="0.5")
                $status="Half Day";   
            
            $attendanceArr[$_attendance->getAttendanceDate()]=$status;
               
       }
       return $attendanceArr;
       
    }
    
}