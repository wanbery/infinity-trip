<?php

class Application_Form_SiteName extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement('hidden','id_settings',array('label'=>'','value'=>''));
        $this->select();
        $this->addElement('text','content_settings',array('label'=>'Tytuł strony:','size'=>'60'));
        $this->addElement('submit','update',array('label'=>'Zapisz'));
    }

    public function select()
    {
    	$select = new Zend_Form_Element_Select('value_settings',array('label'=>'Czy tytuł ma być widoczny:','multiOptions'=>array('true'=>'Tak','false'=>'Nie')));

    	$this->addElement($select);
    }


}

