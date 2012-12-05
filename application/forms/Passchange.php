<?php

class Application_Form_Passchange extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->userSelect();
        $this->addElement('password','change_password_user',array('Label'=>'Nowe hasło:'));
        $this->addElement('submit','Zmień',array('Value'=>'Zmień hasło'));
    }

    public function userSelect()
    {
    	$select = new Zend_Form_Element_Select('change_login_user',array('label'=>'Użytkownicy:','multiOptions'=>$this->showUser()));

    	$this->addElement($select);
    }

    public function showUser()
    {
        $Db = new Application_Model_DbTable_User();
        $result['empty'] = '';
        foreach ($Db->fetchAll() as $key) {
            $result[$key['login_user']] = $key['login_user'];
        }

        return $result;
    }
}

