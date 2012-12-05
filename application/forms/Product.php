<?php

class Application_Form_Product extends Zend_Form
{
	public function init()
    {
    	$section = 'product';
        //id_product	visible_product	position_product	name_product	content_product	title_meta_product	keywords_meta_product	description_meta_product
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $id = $request->getParam('id');
        
        $this->setMethod('post');
        $this->addElement('submit','submit',array('label'=>'Zapisz'));
        $this->addElement('hidden','id_'.$section,array('value'=>''));
        $this->setCategory();
        $this->select('visible_'.$section,'Czy strona ma być widoczna:');
        $this->addElement('text','position_'.$section,array('label'=>'Podaj pozycje w menu:'));
        $this->addElement('text','name_'.$section,array('label'=>'Tytuł:'));
        $this->textArea($section);
        $this->addElement('text','title_meta_'.$section,array('label'=>'Meta: title:'));
        $this->addElement('text','keywords_meta_'.$section,array('label'=>'Meta: keywords:'));
        $this->addElement('text','description_meta_'.$section,array('label'=>'Meta: description:'));
    }

    public function select($section,$label)
    {
        $select = new Zend_Form_Element_Select($section,array('label'=>$label,'multiOptions'=>array('true'=>'Tak','false'=>'Nie')));

        $this->addElement($select);
    }

    public function textArea($section)
    {
        $text = new Zend_Form_Element_Textarea('content_'.$section,array('label'=>'Treść:','class'=>'ckeditor','id'=>'editor1','rows'=>'20','cols'=>'100'));

        $this->addElement($text);
    }
    
    public function delete()
    {
        $this->addElement('text','delete_text',array('value'=>'wpisz DELETE'));
    }

    public function setCategory()
    {
        $Db = new Application_Model_DbTable_Category();

        foreach ($Db->fetchAll() as $key) {
            $table[$key['id_category']] = $key['name_category'];
        }

        $select = new Zend_Form_Element_Select('id_category',array('label'=>'Wybierz kategorie:','multiOptions'=>$table));
        
        $this->addElement($select);
    }

}

