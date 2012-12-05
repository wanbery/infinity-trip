<?php 

/**
* MENU CLASS
*/
class Zend_View_Helper_Sidebar extends Zend_View_Helper_Abstract
{
	public function sidebar()
	{
		$Db = new Application_Model_DbTable_Sidebar();
                $Settings = new Application_Model_DbTable_Settings();
                $object = $Settings->find(8)->current();

                $sidebarQuery = $Db->select()->where('visibility_sidebar = ?','true');

                if (!$object) throw new Zend_Controller_Action_Exception('Błąd obiektu sidebar', 404);

                $visible = $object->toArray();

                if ($visible['value_settings'] == 'true') {
                	return $this->view->partial('sidebar.phtml',array('sidebar'=>$Db->fetchAll($sidebarQuery),'advertisemenet'=>'REKLAMA'));
                }
	}
}