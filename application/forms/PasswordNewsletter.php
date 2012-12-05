<?php

class Application_Form_PasswordNewsletter extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement('password','password_sender',array('label'=>'Hasło: '));

        $this->addElement('submit','change',array('label'=>'Zmień'));
    }


}

