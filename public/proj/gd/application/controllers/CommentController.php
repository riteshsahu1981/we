<?php
class CommentController extends Base_Controller_Action
{

    public function preDispatch()
	{
            parent::preDispatch();
            $this->_helper->layout->setLayout('2column');
    }	

    public function saveCommentAction()
    {   
        $this->_helper->layout->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);
        $userNs = new Zend_Session_Namespace('members');
        $this->view->userId = $userNs->userId;
		
		if(is_null($userNs->userId) && !numeric($userNs->userId))
		{
			echo "<span style='color:#ff0000;'>Please login to submit your comment on this wall.</span>";
			exit;
		}
		if($this->_getParam('comment')=="" || $this->_getParam('comment')=="Comment...")
		{
			echo "<span style='color:#ff0000;'>Please enter your comment.</span>";
			exit;
		}		
		
		$commentM = new Application_Model_Comment();
        $commentM->setComment($this->_getParam('comment'));
        $commentM->setItemId($this->_getParam('item_id'));
        $commentM->setItemType($this->_getParam('item_type'));
        $commentM->setParentId(0);
        $commentM->setPublish(1);
        $commentM->setUserId($userNs->userId);
        $id=$commentM->save();

        $this->view->item_id=$this->_getParam('item_id');
        //get user details who submit comment
        $userM = new Application_Model_User();
        $user = $userM->find($userNs->userId);
        $strCommentedByName 		   = $user->getFirstName()." ".$user->getLastName();
		
		//get user details to who wrote the blog (blog owner details)
		$commentedUserId  = $this->_getParam('user_id'); 
		$objCommentedUser = $userM->find($commentedUserId);
		
		$params['CommentedPersonName'] 	= $objCommentedUser->getFirstName()." ".$objCommentedUser->getLastName();
        $params['Comment']				= $this->_getParam('comment');
		$params['wall_id']				= $this->_getParam('item_id');
		$params['CommentedByName']     	= $strCommentedByName;
        $params['email']               	= $objCommentedUser->getEmail();
        
		//now send notification email to blog owner user
		if($id>0)
		{
			//send email to user if not commenting own profile
			if($commentedUserId != $userNs->userId)
			{
				$mail=new Base_Mail(); 
				$mail->sendNotificationMail("comment", $params);
			}
			//display comment
			$commentM=new Application_Model_Comment();
			$this->view->comment=$commentM->find($id);
        }
        else
		{
            exit("error");
        }
    }//end of function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 10-Dec-2010
	 * @Description: Save comment for journal section (from Journals, View Post page)
	 */
	public function saveJournalCommentAction()
    {   
        $this->_helper->layout->disableLayout();
        
        $userNs = new Zend_Session_Namespace('members');
        $this->view->userId = $userNs->userId;
		
		if(is_null($userNs->userId) && !numeric($userNs->userId))
		{
			echo "<span style='color:#ff0000;'>Please login to submit your comment on this blog.</span>";
			exit;
		}
		if($this->_getParam('comment')=="" || $this->_getParam('comment')=="Comment...")
		{
			echo "<span style='color:#ff0000;'>Please enter your comment.</span>";
			exit;
		}		
		
		$commentM = new Application_Model_Comment();
        $commentM->setComment($this->_getParam('comment'));
        $commentM->setItemId($this->_getParam('item_id'));
        $commentM->setItemType($this->_getParam('item_type'));
        $commentM->setParentId(0);
        $commentM->setPublish(1);
        $commentM->setUserId($userNs->userId);
        $id=$commentM->save();

        $this->view->item_id=$this->_getParam('item_id');
		
        //get user details who submit comment
        $userM = new Application_Model_User();
        $user = $userM->find($userNs->userId);
        $strCommentedByName = $user->getFirstName()." ".$user->getLastName();
		
		//get user details to who wrote the blog (blog owner details)
		$commentedUserId  = $this->_getParam('user_id'); 
		$objCommentedUser = $userM->find($commentedUserId);
		
		$params['CommentedPersonName'] 	= $objCommentedUser->getFirstName()." ".$objCommentedUser->getLastName();
        $params['Comment']				= $this->_getParam('comment');
		$params['blog_id']				= $this->_getParam('item_id');
		$params['CommentedByName']     	= $strCommentedByName;
        $params['email']               	= $objCommentedUser->getEmail();
        
		//now send notification email to blog owner user
		if($id>0)
		{
			//send email to user if not commenting own profile
			if($commentedUserId != $userNs->userId)
			{
				$mail=new Base_Mail(); 
				$mail->sendBlogCommentEmail($params);
			}
			//display comment
			$commentM=new Application_Model_Comment();
			$this->view->comment=$commentM->find($id);
        }
        else
		{
            exit("error");
        }
		$this->render('save-comment');
    }//end of function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 2-Nov-2010
	 * @Description: Sumbit comment by blog owner
	 */
	public function addCommentAction()
    {   
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
		
        $userNs = new Zend_Session_Namespace('members');
        $this->view->userId = $userNs->userId;
		
		if(is_null($userNs->userId) && !numeric($userNs->userId))
		{
			$response = "<span style='color:#ff0000;'>Please login to submit your comment on this blog.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		if($this->_getParam('comment')=="" || $this->_getParam('comment')=="Comment...")
		{
			$response = "<span style='color:#ff0000;'>Please enter your comment.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		
		//save comment
		$commentM = new Application_Model_Comment();
        $commentM->setComment($this->_getParam('comment'));
        $commentM->setItemId($this->_getParam('item_id'));
        $commentM->setItemType($this->_getParam('item_type'));
        $commentM->setParentId(0);
        $commentM->setPublish(1);
        $commentM->setUserId($userNs->userId);
        $id=$commentM->save();

		//set and display response
		if($id>0)
		{
			//get total number of comments
			$total_comments = $commentM->numComments('blog', $this->_getParam('item_id'));
			$total_comments = $total_comments." Comments";
			
			//get comment information to display in comment listings
			$comment = $commentM->find($id);
			//$this->view->comment = $objComment;
			
			$date			=	new Base_Date();
			$objModelUser	=	new Application_Model_User();
			
			$objUser 	= 	$objModelUser->find($comment->userId);
			$username	=	$objUser->getUsername();
			$firstname	=	$objUser->getFirstName();
			$lastname	=	$objUser->getLastName();
			$image		=	$objUser->getThumbnail();
		
			$response  = "<div class='my-journal-view-comment-row' id='comment-detail-".$id."'>";
			$response .= "<div class='my-journal-view-comment-row-l'>";
			$response .= "<a href='/".$username."'><img width='37px' height='43px' border='0' src='".$image."' alt='' /></a>";
			$response .= "</div>";
			$response .= "<div class='my-journal-view-comment-row-r'>";
			$response .= "<p><span><a href='/".$username."'>".$firstname." ".$lastname."</a></span> ".$comment->comment."</p>";
			$response .= "<div class='jposted'>Posted ".$date->timeAgo($comment->getAddedon())." | ";
			$response .= "<a href='#add_comment_form' title='Add Comment'>Comment</a> | ";
			$like_link = "<a href='javascript://' title='Like Comment' onclick='likeComment(".$id.", 1)'>Like</a>";
			$response .= "<label id='like-comment-label-".$id."'>".$like_link."</label> | ";
			$response .= "<a href='javascript://' title='Remove Comment' onclick='removeComment(".$id.",".$this->_getParam('item_id').")'>Remove</a>";
			$response .= "</div></div></div>";
			$JsonResultArray = Array('error'=>0, 'total_comments'=>$total_comments, 'response'=>$response);
		}
        else
		{
			$response = "<span style='color:#ff0000;'>Error occured, Please try again later.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
        }
		echo Zend_Json::encode($JsonResultArray);
		exit;
    }//end of function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 2-Nov-2010
	 * @Description: Delete comment and comment votes by blog owner
	 */
	public function deleteCommentAction()
    {   
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
		
        $userNs = new Zend_Session_Namespace('members');
        $this->view->userId = $userNs->userId;
		
		if(is_null($userNs->userId) && !numeric($userNs->userId))
		{
			$response = "<span style='color:#ff0000;'>Please login to delete this comment.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		
		//delete comment: update comment publish status to '0' to delete the comment
		$commentM = new Application_Model_Comment();
		$commentM = $commentM->find($this->_getParam('comment_id'));
        $commentM->setPublish(0);
        $resp = $commentM->save();

		//set response message
		if($resp)
		{
			//get total number of comments
			$total_comments = $commentM->numComments('blog', $this->_getParam('item_id'));
			$total_comments = $total_comments." Comments";
			
			$response = "<span style='color:#ff0000;'>Comment has been deleted.</span>";
			$JsonResultArray = Array('error'=>0, 'total_comments'=>$total_comments, 'response'=>$response);
		}
        else
		{
			$response = "<span style='color:#ff0000;'>Error occured, Please try again later.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
        }
		echo Zend_Json::encode($JsonResultArray);
		exit;
    }//end of function
}
