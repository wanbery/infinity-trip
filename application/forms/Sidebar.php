<?php

class Application_Form_Sidebar extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $prefix = 'sidebar';

        $this->setMethod('post');
        $this->select($prefix);
        $this->addElement('text','name_'.$prefix,array('label'=>'Temat:'));
        $this->content($prefix);
        $this->addElement('submit','submit',array('label'=>'Zapisz'));
    }

    public function content($prefix)
    {
        $text = new Zend_Form_Element_Textarea('content_'.$prefix,array('label'=>'Treść:','class'=>'ckeditor','id'=>'editor1','rows'=>'20','cols'=>'100'));

        $this->addElement($text);
    }

	public function select($prefix)
    {
        $select = new Zend_Form_Element_Select('visibility_'.$prefix,array('label'=>'Czy ten element ma być widoczny:','multiOptions'=>array('true'=>'Widoczny','false'=>'Niewidoczny')));

        $this->addElement($select);
    }
}

