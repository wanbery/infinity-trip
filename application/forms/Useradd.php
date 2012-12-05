<?php

class Application_Form_Useradd extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        $this->addElement('text','user',array('label'=>'Imię, nazwisko:','required'=>false,'filters'=>array('StringTrim')));
        $this->addElement('text','login_user',array('label'=>'Login:','required'=>true,'filters'=>array('StringTrim')));
        $this->addElement('password','password_user',array('label'=>'Hasło:','required'=>true));
        $this->displayRights();
        $this->addElement('submit','Dodaj',array('value'=>'Dodaj'));
    }

	public function displayRights()
    {
    	$select = new Zend_Form_Element_Select('rights_user',array('label'=>'Prawa:','multiOptions'=>array('3'=>'Użytkownik', '2'=>'Moderator', '1'=>'Administrator')));

    	$this->addElement($select);
    }
}

