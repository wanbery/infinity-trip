<?php

class Application_Form_Delete extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        $this->addElement('text','delete',array('label'=>'Aby usunąć należy wpisać w komórce poniżej DELETE:'));
        $this->addElement('submit','delSubmit',array('label'=>'USUŃ'));
    }


}

