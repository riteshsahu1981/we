<?php
class TestController extends Base_Controller_Action
{
    public function facebookInviteAction()
    {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

            $facebook = $this->view->facebook();
            $session = $facebook->getSession();
            if ($session)
            {
                   $uid = $facebook->getUser();
                   $friends = $facebook->api('/me/friends');
                   //print_r($friends);
                    ?>
                    <script language="javascript">
                           //window.opener.location.href='/index/connect-your-account';
                           //window.close();
                    </script>
                    <?
            }
    }




}
?>
