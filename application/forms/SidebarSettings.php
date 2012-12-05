<?php

class Application_Form_SidebarSettings extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
		
        $this->select();

        $this->addElement('submit','sidebar',array('label'=>'Zapisz'));
    }

    public function select()
    {
    	$select = new Zend_Form_Element_Select('sidebar_value_settings',array('label'=>'Czy pasek boczny ma być widoczny:','multiOptions'=>$this->getSidebar()));

    	$this->addElement($select);
    }

    public function getSidebar()
    {
    	$Db = new Application_Model_DbTable_Settings();
        $obj = $Db->find(8)->current();

        $arrayObj = $obj->toArray();

        /*$result = $arrayObj['value_settings'];*/

        if ($arrayObj['value_settings'] == 'false') {
        	$result = array('false'=>'Nie','true'=>'Tak');
        }else $result = array('true'=>'Tak','false'=>'Nie',);

        return $result;
    }


}

