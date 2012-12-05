<?php

class Application_Form_Foot extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement('text','content_foot',array('label'=>'Treść stopki strony:','value'=>'','size'=>150));
        $this->displayFoot();
        $this->addElement('submit','Zapisz',array('value'=>'Zapisz'));
    }

    public function displayFoot()
    {
    	$select = new Zend_Form_Element_Select('visible_foot',array('label'=>'Czy stopka ma być widoczna:','multiOptions'=>array('true'=>'Tak','false'=>'Nie')));

    	$this->addElement($select);
    }


}

