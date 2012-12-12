<?php

class Application_Form_AddedProduct extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $id = $request->getParam('id');

        $this->setMethod('post');
    	$this->addedCategory($id);
    	$this->addElement('submit', 'removeCategory',array('label'=>'-'));
    }

    public function addedCategory($id)
    {
    	$Db = new Application_Model_DbTable_ProductCategory();
    	$DbCategory = new Application_Model_DbTable_Category();
        $table = array();
    	
    	foreach ($Db->fetchAll($Db->select()->where('id_product = ?',$id)->order('id_product')->order('id_category')) as $key) {
    		$selectCategory = $DbCategory->fetchRow($DbCategory->select()->where('id_category = ?',$key['id_category']));
    		$table[$key['id_category']] = $selectCategory['name_category'];
    	}

        if ($table) {
            $select = new Zend_Form_Element_Multiselect('id_category',array('label'=>'Lista dodanych kategorii:','multiOptions'=>$table));
        }else{
            $table[0] = '-------------------------';
            $select = new Zend_Form_Element_Multiselect('id_category',array('label'=>'Lista dodanych kategorii:','multiOptions'=>array($table[0])));
        }
        
        
        $this->addElement($select);
    }

}

