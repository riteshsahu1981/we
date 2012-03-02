<?php

class Base_Paginator extends Zend_Paginator 
{

	private $_total_count;
	
	public function __construct() {
		
	}
	public function fetchPageData($model,$page,$countPerPage=10,$where=null,$order=null)
    {
    	$zend=new Zend_Db_Table();
	    $result =  $model->getMapper()->getDbTable()->fetchAll($where, $order);
	    $this->setTotalCount(count($result));	    
	    $paginator = Base_Paginator::factory($result);
	    $paginator->setItemCountPerPage($countPerPage);
	    $paginator->setCurrentPageNumber($page);
	    return $paginator;	
    }
    
    public function fetchPageDataRaw($sql,$page,$countPerPage=10)
    {
    	$db=Zend_Registry::get('db');
    	$result =  $db->fetchAll($sql);
	    $this->setTotalCount(count($result));	    
	    $paginator = Base_Paginator::factory($result);
	    $paginator->setItemCountPerPage($countPerPage);
	    $paginator->setCurrentPageNumber($page);
	    return $paginator;
    }
    
    public function fetchPageDataResult($result,$page,$countPerPage=10)
    {
	    $this->setTotalCount(count($result));	    
	    $paginator = Base_Paginator::factory($result);
	    $paginator->setItemCountPerPage($countPerPage);
	    $paginator->setCurrentPageNumber($page);
	    
	    return $paginator;
    }
    
    public function getTotalCount()
    {
    	return $this->_total_count;
    }
    public function setTotalCount($total_count)
    {
    	$this->_total_count=$total_count;
    }
	
	
}
