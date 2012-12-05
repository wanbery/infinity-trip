<?php

class Application_Form_Newsletter extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $this->setMethod('post');

        $this->addElement('hidden','id_newsletter',array('label'=>'','value'=>''));
        $this->selectProperty();
        $this->addElement('text','subject_newsletter',array('label'=>'Tytuł:','size'=>'60'));
        $this->body();
        $this->addElement('submit','submit',array('label'=>'Zapisz'));
    }

    public function selectProperty()
    {
    	$select = new Zend_Form_Element_Select('property_newsletter',array('label'=>'Oznacz właściwość NEWSLETTERA:','multiOptions'=>array('unposted'=>'Niewysłana','posted'=>'Wysłana')));

    	$this->addElement($select);
    }

    public function body()
    {
    	$text = new Zend_Form_Element_Textarea('body_newsletter',array('label'=>'Treść:','class'=>'ckeditor','id'=>'editor1','rows'=>'20','cols'=>'100'));

        $this->addElement($text);
    }

}

