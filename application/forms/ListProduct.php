<?php

class Application_Form_ListProduct extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	$this->setCategory();
    	$this->addElement('submit', 'addCategory',array('label'=>'+'));
    }

    public function setCategory()
    {
        $Db = new Application_Model_DbTable_Category();

        foreach ($Db->fetchAll() as $key) {
            $table[$key['id_category']] = $key['name_category'];
        }

        $select = new Zend_Form_Element_Multiselect('id_category',array('label'=>'Lista kategorii:','multiOptions'=>$table));
        
        $this->addElement($select);
    }

}

