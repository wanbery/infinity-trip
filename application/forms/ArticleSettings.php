<?php

class Application_Form_ArticleSettings extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
		
        $this->select();

        $this->addElement('submit','Zapisz',array('value'=>'Zapisz'));
    }

    public function select()
    {
    	$select = new Zend_Form_Element_Select('value_article_settings',array('label'=>'Czy tytuły artykułów mają być widoczne:','multiOptions'=>array('true'=>'Tak','false'=>'Nie')));

    	$this->addElement($select);
    }


}

