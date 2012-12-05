<?php

class Application_Form_Userpasschange extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        
        $this->addElement('password','password_user',array('Label'=>'Nowe hasło:'));
        $this->addElement('submit','Zmień',array('Value'=>'Zmień hasło'));
    }

}

