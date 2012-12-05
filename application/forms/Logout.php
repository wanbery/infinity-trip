<?php

class Application_Form_Logout extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $view = Zend_Layout::getMvcInstance()->getView();
        $url = $view->url(array('controller'=>'auth','action'=>'logout'));

        $this->setAction($url);

        $this->addElement('submit','submit',array('Label'=>'Wyloguj'));
    }


}

