<?php 

/**
* MENU CLASS
*/
class Zend_View_Helper_Sitename extends Zend_View_Helper_Abstract
{
	public function sitename()
	{
		$DbSettings = new Application_Model_DbTable_Settings();
		$siteName = $DbSettings->find(1)->current();

		$this->view->siteName = $siteName->toArray();

		return $this->view->partial('sitename.phtml',array('sitename'=>$siteName));
	}
}