<?php

/**
 * IndexController
 * 
 * @author
 * @version 
 */


class Block_IndexController extends Base_Controller_Action {
	/**
	 * The default action - show the home page
	 */

    public function indexAction()
	{
	}

	public function viewAction()
	{
            $this->view->title = "Article";
            $this->view->headTitle("Miss High Street - Fashion Articles");

            $id=$this->_getParam('id');
            $model=new Cms_Model_Cms();
            $row=$model->find($id);
            $this->view->title=$row->getTitle();
            $this->view->content=$row->getContent();
	}

        public function bannerAction()
        {
            $id=null;
            $position="";
            
            $id=$this->_getParam('id',null);
           	$position=$this->_getParam('position','');
            $this->view->width=$width=$this->_getParam('width',500);
            $this->view->height=$height=$this->_getParam('height',200);
            $model=new Cms_Model_Banner();
            $this->view->banners=$banners=$model->getBanner($position,$id);
            //$banner = $model->find($id);
            //$this->_redirect($banner->getUrl());
            //print_r($banner);exit;
        }
	
	public function aboutUsAction()
        {
            $id = "1"; //About Us Id
            $model=new Cms_Model_Cms();
            $row=$model->find($id);
            $this->view->title=$row->getTitle();
            $this->view->content=$row->getContent();
        }
        public function faqAction()
        {
            $id = "2"; //FAQ Id
            $model=new Cms_Model_Cms();
            $row=$model->find($id);
            $this->view->title=$row->getTitle();
            $this->view->content=$row->getContent();
        }

        public function termsConditionAction()
        {
            $id = "3"; //termsCondition Id
            $model=new Cms_Model_Cms();
            $row=$model->find($id);
            $this->view->title=$row->getTitle();
            $this->view->content=$row->getContent();
        }

        public function privacyPolicyAction()
        {
            $id = "4"; //privacyPolicy Id
            $model=new Cms_Model_Cms();
            $row=$model->find($id);
            $this->view->title=$row->getTitle();
            $this->view->content=$row->getContent();
        }
}
