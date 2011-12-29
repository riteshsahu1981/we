<?php
class LibraryController extends Base_Controller_Action{
   public function manageBooksAction()
   {
       /*--search options---*/
        $search = trim($this->_getParam('search'));
        $status = trim($this->_getParam('status'));
        
        $where='1=1';
        $linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(b.title like '%{$search}%' or b.isbn like '%{$search}%' or b.author like '%{$search}%' or b.description like '%{$search}%' or b.publisher like '%{$search}%')";
            $linkArray['search']=$search;
            $this->view->search=$search;
        }
        if($status<>"")
        {
            $linkArray['status']=$status;
            $this->view->status=$status;
            
            if($status=="available")
                $status="bu.issue_date is null";
            else
                $status="bu.issue_date is not null";

            if(is_null($where))
                $where.=" $status";
            else
                $where.=" and $status";
            
        }
        /*----search options----*/
        
        $this->view->linkArray=$linkArray;
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Book();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("b"=>'book'))
                ->joinLeft(array('bu'=>'book_user'),' b.id = bu.book_id and bu.return_date is null',array("issue_date"=>"issue_date","return_date"=>"return_date","estimated_return_date"=>"estimated_return_date", "user_id"=>"user_id"))
                ->order('addedon desc')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        
        
   }
   
   public function editBookAction()
   {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_Book();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));  
        }
        $options['title'] = $model->getTitle();
        $options['isbn'] = $model->getIsbn();
        $options['author'] = $model->getAuthor();
        $options['description'] = $model->getDescription();
        $options['publisher'] = $model->getPublisher();
        $request = $this->getRequest();
        $form    = new Application_Form_Book();
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 

            if($options['title']==$model->getTitle())
            {
               $form->getElement('title')->removeValidator("Db_NoRecordExists");
            }
            if($options['isbn']==$model->getIsbn())
            {
               $form->getElement('isbn')->removeValidator("Db_NoRecordExists");
            }
            
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();

                $this->_flashMessenger->addMessage(array('success'=>'Book has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/edit-book/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }

        $this->view->form		=	$form;
   }
   
   
   public function searchBooksAction()
   {
       $this->manageBooksAction();
       echo $this->view->render("library/manage-books.phtml");
   }
   
   public function addBookAction()
   {
        $request = $this->getRequest();
        $form    = new Application_Form_Book();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            $form->getElement('title')->addValidators(array(
            array('Db_NoRecordExists', false, array(
            'table' => 'book',
            'field' => 'title',
            'messages'=>'Book with the same title is already exists, Please choose another title.'
                    ))
            ));
            if ($form->isValid($options))
            { 
                $model=new Application_Model_Book($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Book added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add book!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));
                }
               $form->reset();
            }
            else
            {
                $form->reset();
                $form->populate($options);
           }
        }
        $this->view->form =  $form;
   }
   
   public function bookDetailAction()
   {
        $this->view->layout()->disableLayout();
        $bookId=$this->_getParam("id");
        $model=new Application_Model_Book();
        $book=$model->find($bookId);
        if(false===$book)
        {
            exit("Operation failed!");
        }
       
        $this->view->book=$book;
        
        $model=new Application_Model_BookUser();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("bu"=>'book_user'))
                ->join(array('u'=>'user'),' bu.user_id = u.id and bu.return_date is null',array("first_name"=>"first_name","last_name"=>"last_name","employee_code"=>"employee_code", "email"=>"email","profile_picture"=>"profile_picture"))
                ->where("book_id='{$bookId}'");
        $this->view->bookUser=$bookUser=$table->fetchRow($select);
        
        
        
        
   }
   
   public function issueBookAction()
   {
        $bookId=$this->_getParam("id");
        $model=new Application_Model_Book();
        $book=$model->find($bookId);
        if(false===$book)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid Request!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));
        }
       
        $this->view->book=$book;
        
        $request = $this->getRequest();
        $form    = new Application_Form_BookUser();
        $form->removeElement("returnDate");
        if ($request->isPost())
        {
            $options=$request->getPost();
            if($options['issueDate'] > $options['estimatedReturnDate'])
            {
               
                $options['estimatedReturnDate'] = "";
                // end date must be greater than start date
                $form->getElement('estimatedReturnDate')->setRequired(true);
                $form->getElement('estimatedReturnDate')->addValidators(array(
                    array('NotEmpty', false, array('messages' => array('isEmpty' => 'Estimated return date must be greater than issue date')))
                ));
            }
            
            if ($form->isValid($options))
            { 
                $options['bookId']=$book->getId();
                $usersNs = new Zend_Session_Namespace("members");
                $options['issuedByUserId']=$usersNs->userId;
                $model=new Application_Model_BookUser($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Book issued successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to issue book!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));
                }
               $form->reset();
            }
            else
            {
                $form->reset();
                $form->populate($options);
           }
        }
        $this->view->form =  $form;
   }
   
   public function returnBookAction()
   {
        $bookId=$this->_getParam("id");
        $model=new Application_Model_Book();
        $book=$model->find($bookId);
        if(false===$book)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid Request!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));
        }
       
        $this->view->book=$book;
        
        
        $model=new Application_Model_BookUser();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("bu"=>'book_user'))
                ->join(array('u'=>'user'),' bu.user_id = u.id and bu.return_date is null',array("first_name"=>"first_name","last_name"=>"last_name","employee_code"=>"employee_code", "email"=>"email","profile_picture"=>"profile_picture"))
                ->where("book_id='{$bookId}'");
                //echo $sql = $select->__toString();
        $this->view->bookUser=$bookUser=$table->fetchRow($select);
     
        
        $request = $this->getRequest();
        $form    = new Application_Form_BookUser();
        $form->removeElement("userId");
        $form->removeElement("issueDate");
        $form->removeElement("estimatedReturnDate");
       
        if ($request->isPost())
        {
            $options=$request->getPost();
            $arrRD=explode(" ", $bookUser->issue_date);
            
            
            if(($arrRD[0] > $options['returnDate']) && $options['returnDate']!="")
            {
                $options['returnDate'] = "";
                // end date must be greater than start date
                $form->getElement('returnDate')->setRequired(true);
                $form->getElement('returnDate')->addValidators(array(
                    array('NotEmpty', false, array('messages' => array('isEmpty' => 'Return date must be greater than issue date')))
                ));
            }
            
            if ($form->isValid($options))
            { 
          
                $model=new Application_Model_BookUser();
                $bookUser=$model->find($bookUser->id);
                $bookUser->setReturnDate($options['returnDate']);
                $id=$bookUser->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Book return successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to return book!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/library/manage-books'));
                }
               $form->reset();
            }
            else
            {
                $form->reset();
                $form->populate($options);
           }
        }
        $this->view->form =  $form;
   }
   
   public function historyAction()
   {
        $bookId=$this->_getParam("id");
        $model=new Application_Model_Book();
        $book=$model->find($bookId);
        if(false===$book)
        {
            exit("Operation failed!");
        }
       
        $this->view->book=$book;
        
        $model=new Application_Model_BookUser();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("bu"=>'book_user'))
                ->join(array('u'=>'user'),' bu.user_id = u.id ',array("first_name"=>"first_name","last_name"=>"last_name","employee_code"=>"employee_code", "email"=>"email","profile_picture"=>"profile_picture"))
                ->order("issue_date asc")
                ->where("book_id='{$bookId}'");
        //$this->view->bookUser=$bookUser=$table->fetchAll($select);
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
   }
}
