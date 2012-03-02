<?php
class VoteController extends Base_Controller_Action
{

	public function preDispatch()
	{
		parent::preDispatch();
		
	}
	
	public function indexAction()
	{
            $this->view->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
               echo "Bye";
	}

	public function doVoteAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$usersNs=new Zend_Session_Namespace('members');
		$user_id=$usersNs->userId;
		if($user_id=="" || $user_id==0)
		{
			$JsonResultArray=Array('error'=>1, 'msg'=>"Please login to vote." );
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		$vote=$this->_getParam('vote');
		$item_id=$this->_getParam('item_id');
		$item_type=$this->_getParam('item_type');

		$voteM=new Application_Model_Vote();

		$voteM=$voteM->fetchRow("user_id='{$user_id}' and item_type='{$item_type}' and item_id='{$item_id}' ");
		if(false===$voteM)
		{
				$voteM=new Application_Model_Vote();
				$voteM->setVote($vote);
				$voteM->setItemId($item_id);
				$voteM->setItemType($item_type);
				$voteM->setUserId($user_id);
				$savevote=$voteM->save();
				

		}
		else
		{
			$voteM->setVote($vote);
			$savevote=$voteM->save();
		}

		/* --- count up & down-----*/

		$total_up=$voteM->getTotalVotes($item_id,$item_type, 1,null);
		$total_down=$voteM->getTotalVotes($item_id,$item_type, -1,null);
		/*-------------------*/


		$JsonResultArray=Array('error'=>2, 'msg'=>"You have successfully voted.", 'total_down'=>$total_down ,  'total_up'=>$total_up );
		echo Zend_Json::encode($JsonResultArray);
	}
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 2-Nov-2010
	 * @Description: This function is used to like/unlike comment by blog owner
	 */
	public function likeCommentAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$usersNs=new Zend_Session_Namespace('members');
		$user_id=$usersNs->userId;
		if($user_id=="" || $user_id==0)
		{
			$JsonResultArray = Array('error'=>1, 'response'=>"Please login to vote." );
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		$vote		=	$this->_getParam('vote');
		$item_id	=	$this->_getParam('item_id');
		$item_type	=	$this->_getParam('item_type');

		$voteM		=	new Application_Model_Vote();
		$voteM		=	$voteM->fetchRow("user_id='{$user_id}' AND item_type='{$item_type}' AND item_id='{$item_id}' ");
		
		if(false===$voteM)
		{
				$voteM	=	new Application_Model_Vote();
				
				$voteM->setVote($vote);
				$voteM->setItemId($item_id);
				$voteM->setItemType($item_type);
				$voteM->setUserId($user_id);
		}
		else
		{
			$voteM->setVote($vote);
		}
		$savevote	=	$voteM->save();
		if($savevote)
		{
			$response = "";
			if($vote==1)
			{
				$response = "<a href='javascript://' title='Unlike Comment' onclick='likeComment(".$item_id.", -1)'>Unlike</a>";
			}
			else
			{
				$response = "<a href='javascript://' title='Like Comment' onclick='likeComment(".$item_id.", 1)'>Like</a>";
			}
			$JsonResultArray = Array('error'=>0, 'response'=>$response);
		}
		else
		{
			$JsonResultArray = Array('error'=>1, 'response'=>"Error occured please try again later.");
		}
		echo Zend_Json::encode($JsonResultArray);
		exit;	
	}//end of function
		
}
