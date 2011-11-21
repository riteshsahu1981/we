<?php
class ImageController extends Base_Controller_Action
{
    public function luceneIndexAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $path=PUBLIC_PATH.'/tmp/lucene';
        try {
            $index = Zend_Search_Lucene::open($path);
        } catch (Zend_Search_Lucene_Exception $e) {
            try {
                $index = Zend_Search_Lucene::create($path);
            } catch (Zend_Search_Lucene_Exception $e) {
                echo "Unable to open or create index : {$e->getMessage()}";
            }
        }
        
        for ($i = 0; $i < $index->maxDoc(); $i++) {
            $index->delete($i);
        }
       
        $users=new Application_Model_User();
        $users=$users->fetchAll();
        foreach($users as $_user)
        {
            Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum_CaseInsensitive());
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Text('title', $_user->getFirstName()));
            $doc->addField(Zend_Search_Lucene_Field::keyword('empcode',$_user->getEmployeeCode()));
            $index->addDocument($doc);
            $index->commit();
            $index->optimize();
        }
         
        
    }
    
    public function luceneSearchAction()
    {
        
         $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $path=PUBLIC_PATH.'/tmp/lucene';
        $index = Zend_Search_Lucene::open($path);
        
//        $term  = new Zend_Search_Lucene_Index_Term('ritesh','title');
//        $subquery1 = new Zend_Search_Lucene_Search_Query_Term($term);
//
//        $from = new Zend_Search_Lucene_Index_Term('0', 'empcode');
//        $to   = new Zend_Search_Lucene_Index_Term('53', 'empcode');
//        $subquery2 = new Zend_Search_Lucene_Search_Query_Range($from, $to, true);
//
//        $query = new Zend_Search_Lucene_Search_Query_Boolean();
//        $query->addSubquery($subquery1, true  );
//        $query->addSubquery($subquery2, null );
//        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum_CaseInsensitive());
//        $hits  = $index->find($query);
        
        
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum_CaseInsensitive());
        Zend_Search_Lucene_Search_Query_Wildcard::setMinPrefixLength(1);
        $hits  = $index->find("empcode:[000 TO 200]");
        
         
       foreach($hits as $h)
       {
           echo "Title:".$h->title;
           echo "-------EmpCode:".$h->empcode;
           echo "<br>";
       }
    }
    
    public function thumbAction()
    {
    	$path=base64_decode($this->_getParam('path'));
        $size=$this->_getParam('size','small');
        if($size=="small")
        {   
            $width=80; 
            $height=80;
        }
        elseif($size=="medium")
        {
            $width=100; 
            $height=100;
        }
        elseif($size=="large")
        {
            $width=150; 
            $height=150;
        }
        else
        {
            $width=200; 
            $height=200; 
        }
        
    	$thumb = Base_Image_PhpThumbFactory ::create($path);
		$thumb->resize($width,$height);
		$thumb->show();
    	exit;	
    }
   
   public function uploadPicturesAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $options=$this->_getAllParams();
        $model=new Application_Model_Pictures();
        echo $model->uploadPicture($options);
    }
    
    
    
}//end of class
