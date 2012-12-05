<?php

class Application_Form_Search extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        
        $this->addElement('text','search',array('Label'=>'Szukaj:','required'=>true));
        $this->addElement('submit','submitSearch',array('value'=>'search','label'=>'Szukaj','ignore'=>true,));
	}

}