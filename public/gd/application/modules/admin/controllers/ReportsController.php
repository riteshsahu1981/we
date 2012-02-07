<?php
class Admin_ReportsController extends Base_Controller_Action
{
	
	public function abuseReportAction()
	{
		$sSQL  = "SELECT ra.id, ra.item_id, ra.item_type, ra.addedon";
		$sSQL .= " ,u.email, u.username, u.first_name, u.last_name, u.sex";
		$sSQL .= " FROM report_abuse AS ra";
		$sSQL .= " JOIN user AS u ON u.id = ra.user_id";
		$sSQL .= " WHERE u.status!='deleted' AND ra.status=1";
		$sSQL .= " ORDER BY ra.addedon DESC";
		
		//$settings	=	new Admin_Model_GlobalSettings();		
		//$page_size	=	$settings->settingValue('pagination_size');
		$page_size	= $this->_getParam('page_size',25);
		$page		=	$this->_getParam('page',1);
		
		$pageObj	=	new Base_Paginator();
		
		$paginator	=	$pageObj->fetchPageDataRaw($sSQL, $page, $page_size);
		
		//set view variables
		$this->view->total		=	$pageObj->getTotalCount();
		$this->view->paginator	=	$paginator;
	}	
}

