<?php

class Application_Form_SettingsNewsletter extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        //id_sender	host_sender	port_sender	secure_sender	authentication_sender	debug_sender	charset_sender	user_sender	password_sender	mail_sender 
        $this->setMethod('post');

        $this->addElement('hidden','id_sender',array('label'=>''));

        $this->addElement('text','host_sender',array('label'=>'Host: '));
        $this->addElement('text','user_sender',array('label'=>'Użytkownik'));

        $this->addElement('text','mail_sender',array('label'=>'Adres pocztowy: '));

        $this->addElement('text','port_sender',array('label'=>'Port: '));
        $this->secure();
        $this->authentication();
        $this->debug();
        $this->charset();

        $this->addElement('submit','save',array('label'=>'Zapisz', 'value'=>'Zapisz'));
    }

    public function debug()
    {
    	$select = new Zend_Form_Element_Select('debug_sender',array('label'=>'Opcje debugowania: ','multiOptions'=>array('1'=>'Włączona','0'=>'Wyłączona')));

    	$this->addElement($select);
    }

    public function authentication()
    {
    	$select = new Zend_Form_Element_Select('authentication_sender',array('label'=>'Wymaga uwierzytelnienia: ','multiOptions'=>array('true'=>'Włączona','false'=>'Wyłączona')));

    	$this->addElement($select);
    }
	
	public function secure()
    {
    	$select = new Zend_Form_Element_Select('secure_sender',array('label'=>'Ustawienia zabezpieczeń: ','multiOptions'=>array('ssl'=>'ssl',''=>'Bez szyfrowania','startssl'=>'Startssl')));

    	$this->addElement($select);
    }

    public function charset()
    {
    	$table = array('utf-8','ascii','iso-8859-1','iso-8859-2','iso-8859-3','iso-8859-4','iso-8859-5');

    	$select = new Zend_Form_Element_Select('charset_sender',array('label'=>'Kodowanie znaków: ','multiOptions'=>$table));

    	$this->addElement($select);
    }

}

