<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $section = 'category';

        $this->setMethod('post');
        $this->addElement('submit','submit',array('label'=>'Zapisz'));
        $this->addElement('hidden','id_'.$section,array('value'=>''));
        $this->subCategory($section);
        $this->select('visible_'.$section,'Czy strona ma być widoczna:');
        $this->select('start_site_'.$section,'Czy ma być to strona startowa:');
        $this->addElement('hidden','position_'.$section,array('value'=>0));
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

    public function subCategory($section)
    {
        $Db = new Application_Model_DbTable_Category();

        $table[0] = 'Bez kategorii';

        foreach ($Db->fetchAll() as $key) {
            if ($key['sub_category'] == 0) {
                $table[$key['id_category']] = $key['name_category'];
            }
        }

        $select = new Zend_Form_Element_Select('sub_'.$section,array('label'=>'Wybór podkategorii:','multiOptions'=>$table));

        $this->addElement($select);
    }
}

