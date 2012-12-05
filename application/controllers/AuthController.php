<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        /*$form_logout = new Application_Form_Logout();

        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            echo $this->view->identity = $auth->getIdentity();
            $this->view->form_logout = $form_logout;
            echo $this->view->form_logout;
        } else {
            $this->view->form = new Application_Form_Login();
        }*/
    }

    public function preDispatch()
    {
        $this->_helper->layout->setLayout('adminlayout');
    }

    public function indexAction()
    {
        // action body
        $this->view->form = new Application_Form_Login();
    }

    public function loginAction()
    {
        // action body
        $this->_helper->viewRenderer('index');
        $form = new Application_Form_Login();

        if ($form->isValid($this->getRequest()->getPost())) 
        {
            $adapter = new Zend_Auth_Adapter_DbTable(null,'user','login_user','password_user');
            
            $adapter->setIdentity($form->getValue('login_user'));
            $adapter->setCredential(MD5($form->getValue('password_user')));
            
            $auth = Zend_Auth::getInstance();

            $result = $auth->authenticate($adapter);

            if ($result->isValid()) {
                return $this->_helper->redirector('index','cms-admin','default');
            }else {
                $form->password_user->addError('Błędna próba logowania!');
                $this->view->form = $form;
            }
        }
    }

    public function logoutAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();  
        $auth->clearIdentity();  
        return $this->_helper->redirector('index','auth','default'); 
    }

}







