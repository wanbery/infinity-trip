<?php 

/**
* FOOTER CLASS
*/
class Zend_View_Helper_Footer extends Zend_View_Helper_Abstract
{
	public function footer()
	{
		$Db = new Application_Model_DbTable_Foot();
		
        $this->view->foot = $Db->fetchAll();

		return $this->view->partial('footer.phtml',array('foot'=>$this->view->foot));
	}
}