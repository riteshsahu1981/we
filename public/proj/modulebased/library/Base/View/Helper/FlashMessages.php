<?php
class Base_View_Helper_FlashMessages extends Zend_View_Helper_Abstract
{
	public function flashMessages()
	{
		$messages = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();
		$output = '';
		if (!empty($messages)) {
			$output .= '<div id="messages">';
			foreach ($messages as $message) {
				$output .= '<div class="notification ' . key($message) . ' png_bg"> <a href="#" class="close"><img src="/images/cross_grey_small.png" title="Close this notification" alt="close"></a><div>' . current($message) . '</div></div>';
			}
			$output .= '</div>';
		}
		return $output;
	}
}
