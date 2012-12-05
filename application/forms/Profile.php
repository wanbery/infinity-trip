<?php

class Application_Form_Profile extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... id_user	user	login_user	password_user	rights_user	name_user	surname_user	adress_user	house_number_user	apartment_number_user*/
        $this->setMethod('post');

        $this->addElement('hidden','id_user');
        $this->addElement('text','name_user',array('label'=>'Imię:'));
        $this->addElement('text','surname_user',array('label'=>'Nazwisko:'));
        $this->addElement('text','adress_user',array('label'=>'Adres:'));
        $this->addElement('text','number_user',array('label'=>'Numer:'));

        $this->addElement('submit','Zapisz',array('value'=>'Zapisz'));
    }


}

