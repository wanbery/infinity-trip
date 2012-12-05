<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $view = Zend_Layout::getMvcInstance()->getView();
        $url = $view->url(array('controller'=>'auth','action'=>'login'));

        $this->setAction($url);

        $this->addElement('text','login_user',array('label'=>'Użytkownik','required'=>true,'filters'=>array('StringTrim')));

        $this->addElement('password','password_user',array('label'=>'Hasło:','required'=>true));

        $this->addElement('submit','submit',array('ignore'=>true,'label'=>'login'));
    }

}

