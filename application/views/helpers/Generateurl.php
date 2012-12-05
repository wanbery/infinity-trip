<?php 

/**
* ADDITIONAL FUNCTIONS CLASS
*/
class Zend_View_Helper_Generateurl extends Zend_View_Helper_Abstract
{
	public function generateurl($action,$controller)
	{
		echo $this->url(array('action'=>$action,'controller'=>$controller),'default',true);
	}
}