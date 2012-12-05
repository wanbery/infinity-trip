<?php 

/**
* MENU CLASS
*/
class Zend_View_Helper_Menuadmin extends Zend_View_Helper_Abstract
{
	public function menuAdmin()
	{
		return $this->view->partial('menuadmin.phtml');
	}
}