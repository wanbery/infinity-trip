<?php

class CmsAdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function preDispatch()
    {
        /* Initialize actions on the boot controller*/
        $this->_helper->layout->setLayout('adminlayout');

        $form_logout = new Application_Form_Logout();
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            //USER WAS LOGED
        }else return $this->_helper->redirector('index','auth','default');
    }

    public function indexAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Category();
        
        $select = $Db->select()->where('sub_category = ?',0)->order('position_category');
        $this->view->listCategory = $Db->fetchAll($select);
    }

    public function createAction()
    {
        // action body
        $section = $this->getRequest()->getParams('section');
        
        if ($section['section'] == 'category') {
            $this->view->form = new Application_Form_Category();
            $url = $this->view->url(array('action'=>'add','section'=>'category'));
            $this->view->form->setAction($url);
        }elseif ($section['section'] == 'article') {
            $this->view->form = new Application_Form_Article();
            $url = $this->view->url(array('action'=>'add','section'=>'article'));
            $this->view->form->setAction($url);
        }else 
            throw new Zend_Controller_Action_Exception("Błąd nie ma takich sekcji", 404);

        $this->view->section = $section['section'];
        
    }

    public function addAction()
    {
        // action body
        $section = $this->getRequest()->getParams('section');
        
        if ($section['section'] == 'category') {
            if ($this->getRequest()->isPost()) {
                
                $form = new Application_Form_Category();

                if ($form->isValid($this->getRequest()->getPost())) {
                    
                    $data=$form->getValues();
                    
                    $dbTable = new Application_Model_DbTable_Category();

                    $id = $dbTable->insert($data);
                }
            }else
                throw new Zend_Controller_Action_Exception("Nie mogę dodać 'KATEGORII'", 404);
        }elseif($section['section'] == 'article') {
            if ($this->getRequest()->isPost()) {
                
                $form = new Application_Form_Article();

                if ($form->isValid($this->getRequest()->getPost())) {
                    
                    $data=$form->getValues();
                    
                    $dbTable = new Application_Model_DbTable_Article();

                    $id = $dbTable->insert($data);
                }
            }else
                throw new Zend_Controller_Action_Exception("Nie mogę dodać 'ARTYKUŁU'", 404);
        }else
            throw new Zend_Controller_Action_Exception("Błąd: nie mogę dodać KATEGORII ani ARTYKUŁU", 404);

        $this->view->section = $section['section'];

        return $this->_helper->redirector('list','cms-admin','default',array('section'=>$section['section']));
    }

    public function listAction()
    {
        // action body
        $section = $this->getRequest()->getParams('section');

        $DbCategory = new Application_Model_DbTable_Category();
        $DbArticle = new Application_Model_DbTable_Article();

        if ($section['section'] == 'category') {
            $this->view->data = $DbCategory->fetchAll();
        }elseif($section['section'] == 'article') {
            $this->view->categoryName = $DbCategory->fetchAll();
            $this->view->data = $DbArticle->fetchAll();
        }else
            throw new Zend_Controller_Action_Exception("Błąd: brak 'LISTY': 'KATEGORII' bądź 'ARTYKUŁÓW'", 404);

        $this->view->section = $section['section'];
    }

    public function editAction()
    {
        // action body
        $section = $this->getRequest()->getParams('section');
        $id = $this->getRequest()->getParams('id');

        $this->view->section = $section['section'];

        $this->view->id = $id;

        if ($section['section'] == 'category') {
            $Db = new Application_Model_DbTable_Category();
            $object = $Db->find($id)->current();

            if (!$object)
                throw new Zend_Controller_Action_Exception("Nie ma takiej 'KATEGORII'", 404);

            $this->view->form = new Application_Form_Category();
            $this->view->formDel = new Application_Form_Delete();

            $this->view->form->populate($object->toArray());
            $url = $this->view->url(array('action'=>'update'));
            $this->view->form->setAction($url);

            $urlDel = $this->view->url(array('action'=>'delete'));
            $this->view->formDel->setAction($urlDel);

            $this->view->object = $object;

        }elseif ($section['section'] == 'article') {
            $Db = new Application_Model_DbTable_Article();
            $object = $Db->find($id)->current();

            if (!$object)
                throw new Zend_Controller_Action_Exception("Nie ma takiego 'ARTYKUŁU'", 404);
            
            $this->view->formDel = new Application_Form_Delete();

            $this->view->form = new Application_Form_Article();
            $this->view->form->populate($object->toArray());
            $url = $this->view->url(array('action'=>'update'));
            $this->view->form->setAction($url);

            $urlDel = $this->view->url(array('action'=>'delete'));
            $this->view->formDel->setAction($urlDel);

            $this->view->object = $object;

        }else
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);
    }

    public function updateAction()
    {
        // action body
        $section = $this->getRequest()->getParams('section');
        $id = $this->getRequest()->getParams('id');
        
        if ($section['section'] == 'category') {
            $Db = new Application_Model_DbTable_Category();
            $object = $Db->find($id)->current();

            if (!$object)
                throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost();
                $object->setFromArray($data);
                $Db->update($object->toArray(),'id_category = '.$id['id']);
            }
        }elseif ($section['section'] == 'article') {
            $Db = new Application_Model_DbTable_Article();
            $object = $Db->find($id)->current();

            if (!$object)
                throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost();
                $object->setFromArray($data);
                $Db->update($object->toArray(),'id_article = '.$id['id']);
            }
        }else
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

        $this->view->section = $section['section'];

        return $this->_helper->redirector('edit','cms-admin','default',array('section'=>$section['section'],'id'=>$id['id']));
    }

    public function deleteAction()
    {
        // action body
        $section = $this->getRequest()->getParams('section');
        $id = $this->getRequest()->getParams('id');
        $delete = $this->getRequest()->getParams('delete');

        if ($delete['delete'] != 'DELETE')
            throw new Zend_Controller_Action_Exception("Nie mogę wykonać akcji DELETE!", 404);
        else{
            if ($section['section'] == 'category') {
                $Db = new Application_Model_DbTable_Category();
                $object = $Db->find($id)->current();

                if (!$object)
                    throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

                $object->delete($id);
                $this->view->name = $object['name_category'];
                $this->view->section = $section;

            }elseif ($section['section'] == 'article') {
                $Db = new Application_Model_DbTable_Article();
                $object = $Db->find($id)->current();

                if (!$object)
                    throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

                $object->delete($id);
                $this->view->name = $object['name_article'];
                $this->view->section = $section;
                $this->view->id = $id;

            }else
                throw new Zend_Controller_Action_Exception("Błędny adres!", 404);
        }//closing curly bracket
    }

    public function optionsAction()
    {
        // action body
        /*******************
        ******SITE NAME*****
        *******************/
        $this->view->siteNameForm = new Application_Form_SiteName();
        $DbSettings = new Application_Model_DbTable_Settings();
        $siteObject = $DbSettings->find(1)->current();

        if (!$siteObject)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->siteNameForm->populate($siteObject->toArray());
        $urlSiteName = $this->view->url(array('action'=>'update-sitename'));
        $this->view->siteNameForm->setAction($urlSiteName);
        /*****************
        ******SIDEBAR*****
        *****************/
        $this->view->sidebarForm = new Application_Form_SidebarSettings();
        $sidebarObject = $DbSettings->find(8)->current();

        if (!$sidebarObject)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->sidebarForm->populate($sidebarObject->toArray());
        $urlSidebar = $this->view->url(array('action' => 'update-sidebar'));
        $this->view->sidebarForm->setAction($urlSidebar);

        /**************
        ******FOOT*****
        ***************/
        $this->view->footForm = new Application_Form_Foot();
        $Db = new Application_Model_DbTable_Foot();
        $object = $Db->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->footForm->populate($object->toArray());
        $url = $this->view->url(array('action'=>'update-foot'));
        $this->view->footForm->setAction($url);

        /**********************
        ******ADD NEW USER*****
        ***********************/
        $this->view->userForm = new Application_Form_Useradd();
        $DbUser = new Application_Model_DbTable_User();

        $urlUser = $this->view->url(array('action'=>'add-user'));
        $this->view->userForm->setAction($urlUser);

        /******************************
        ******CHANGE USER PASSWORD*****
        *******************************/
        $this->view->passChangeForm = new Application_Form_Passchange();

        $urlChange = $this->view->url(array('action'=>'change-pass'));
        $this->view->passChangeForm->setAction($urlChange);
    }

    public function updateFootAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Foot();
        $object = $Db->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $object->setFromArray($data);
            $Db->update($object->toArray(),'id_foot = 1');

            return $this->_helper->redirector('options','cms-admin','default');
        }//closing curly bracket
    }

    public function updateSidebarAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Settings();
        $object = $Db->find(8)->current();
        
        if (!$object)
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $Db->update(array('value_settings'=>$data['sidebar_value_settings']),'id_settings = 8');
            
            return $this->_helper->redirector('options','cms-admin','default');
        }//closing curly bracket
    }

    public function addUserAction()
    {
        // action body
        $this->_helper->viewRenderer('options');
        $form = new Application_Form_Useradd();

        $DbUser = new Application_Model_DbTable_User();

        $nameUser = $this->getRequest()->getPost();
        
        $list = $DbUser->fetchAll();

        foreach ($list as $key) {
            if ($key['login_user'] == $nameUser['login_user']) {
                if($form->isValid($this->getRequest()->getPost())){
                    //
                }else{
                    $form->login_user->addError("Podany użytkownik już istnieje!");
                    $form->view->form = $form;
                }
            }            
        }

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data=$form->getValues();
                $data['password_user'] = MD5($data['password_user']);
                $id = $DbUser->insert($data);

                return $this->_helper->redirector('options','cms-admin','default');
            }
        }else
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);
    }

    public function userAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();

        $user = $auth->getIdentity();
        $Db = new Application_Model_DbTable_User();

        $chosenUser = $Db->fetchRow($Db->select()->where('login_user = ?',$user));
        $object = $Db->find($chosenUser['id_user'])->current();

        $this->view->form = new Application_Form_Profile();
        $this->view->changePassForm = new Application_Form_Userpasschange();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

        $this->view->form->populate($object->toArray());
        $url = $this->view->url(array('action'=>'update-profile'));
        $this->view->form->setAction($url);

        $this->view->changePassForm->populate($object->toArray());
        $urlChange = $this->view->url(array('action'=>'profile-passchange'));
        $this->view->changePassForm->setAction($urlChange);
        
        $this->view->user = $auth->getIdentity();
    }

    public function changePassAction()
    {
        // action body
        $Db = new Application_Model_DbTable_User();
        
        $setUser = $this->getRequest()->getPost();

        if ($this->getRequest()->isPost()) {
            $chosenUser = $Db->fetchRow($Db->select()->where('login_user = ?',$setUser['change_login_user']));
            //$object = $Db->find($chosenUser['id_user'])->current();
            
            $Db->update(array('password_user'=>MD5($setUser['change_password_user'])),'id_user = '.$chosenUser['id_user']);

            return $this->_helper->redirector('options','cms-admin','default');
        }//closing curly bracket
    }

    public function updateProfileAction()
    {
        // action body
        $Db = new Application_Model_DbTable_User();

        $setUser = $this->getRequest()->getPost();

        if ($this->getRequest()->isPost()) {

            $object = $Db->find($setUser['id_user'])->current();
            $object->setFromArray($setUser);

            $Db->update($object->toArray(),'id_user = '.$setUser['id_user']);

            return $this->_helper->redirector('user','cms-admin','default');
        }//closing curly bracket
    }

    public function profilePasschangeAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();

        $dataPost = $this->getRequest()->getPost();

        $Db = new Application_Model_DbTable_User();

        if ($this->getRequest()->isPost()) {
            $chosenUser = $Db->fetchRow($Db->select()->where('login_user = ?',$user));
            //$object = $Db->find($chosenUser['id_user'])->current();
            
            $Db->update(array('password_user'=>MD5($dataPost['password_user'])),'id_user = '.$chosenUser['id_user']);

            return $this->_helper->redirector('options','cms-admin','default');
        }//closing curly bracket
    }

    public function newsletterAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Newsletter();

        $this->view->deleteForm = new Application_Form_Delete();

        $id = $this->getRequest()->getParams('id');

        $object = $Db->find($id)->current();

        $this->view->id = $id;

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->form = new Application_Form_Newsletter();

        $this->view->form->populate($object->toArray());

        $url = $this->view->url(array('action'=>'edit-newsletter'));
        $this->view->form->setAction($url);

        $urlDel = $this->view->url(array('action'=>'del-newsletter'));
        $this->view->deleteForm->setAction($urlDel);

    }

    public function newNewsletterAction()
    {
        // action body

        $this->view->form = new Application_Form_Newsletter();

        $url = $this->view->url(array('action'=>'add-newsletter'));
        $this->view->form->setAction($url);
    }

    public function addNewsletterAction()
    {
        // action body
        if ($this->getRequest()->isPost()) {
            
            $form = new Application_Form_Newsletter();

            if ($form->isValid($this->getRequest()->getPost())) {
                            
                $data=$form->getValues();
                            
                $Db = new Application_Model_DbTable_Newsletter();

                $id = $Db->insert($data);
            }
        }else
            throw new Zend_Controller_Action_Exception("Błąd: wykonanie akcji jest nie możliwe!", 404);

        return $this->_helper->redirector('list-newsletter','cms-admin','default');
    }

    public function delNewsletterAction()
    {
        // action body
        $id = $this->getRequest()->getParams('id');
        $delConfirm = $this->getRequest()->getParams('delete');

        if ($delConfirm['delete'] == 'DELETE') {
            $Db = new Application_Model_DbTable_Newsletter();
            $object = $Db->find($id)->current();

            if (!$object)
                throw new Zend_Controller_Action_Exception("ERR_OBJECT", 404);

            $object->delete($id);

            return $this->_helper->redirector('list-newsletter','cms-admin','default');   
        }else
            return $this->_helper->redirector('newsletter','cms-admin','default',array('id'=>$id['id']));
    }

    public function editNewsletterAction()
    {
        // action body 
        $id = $this->getRequest()->getParams('id');
        
        $Db = new Application_Model_DbTable_Newsletter();
        $object = $Db->find($id)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $object->setFromArray($data);
            $Db->update($object->toArray(),'id_newsletter = '.$id['id']);
        }

        return $this->_helper->redirector('newsletter','cms-admin','default',array('id'=>$id['id']));
    }

    public function listNewsletterAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Newsletter();
        $this->view->data = $Db->fetchAll();
    }

    public function settingsNewsletterAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Sender();
        $this->view->form = new Application_Form_SettingsNewsletter();
        $this->view->passwordForm = new Application_Form_PasswordNewsletter();

        $object = $Db->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);
        
        $this->view->form->populate($object->toArray());

        /*ACTION FOR SAVE SMTP SETTINGS*/
        $url = $this->view->url(array('action'=>'save-sender'));
        $this->view->form->setAction($url);

        /*ACTION TO SMTP PASSWORD CHANGE*/
        $passUrl = $this->view->url(array('action'=>'password-sender'));
        $this->view->passwordForm->setAction($url);
    }

    public function saveSenderAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Sender();
        $this->view->form = new Application_Form_SettingsNewsletter();

        $object = $Db->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $object->setFromArray($data);
            $Db->update($object->toArray(),'id_sender = 1');

            return $this->_helper->redirector('settings-newsletter','cms-admin','default');
        }//closing curly bracket      
    }

    public function passwordSenderAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Sender();
        $this->view->form = new Application_Form_PasswordNewsletter();

        $object = $this->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $object->setFromArray($data);
            $Db->update($object->toArray(),'id_sender = 1');

            return $this->_helper->redirector('settings-newsletter','cms-admin','default');
        }//closing curly bracket
    }

    public function settingsCategoryAction()
    {
        // action body
        $Db = new Application_Model_DbTable_CategorySettings();
        $this->view->form = new Application_Form_CategorySettings();
        $object = $Db->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->form->populate($object->toArray());

        $url = $this->view->url(array('action'=>'save-settings','option'=>'category','id'=>'1'));
        $this->view->form->setAction($url);
    }

    public function settingsArticleAction()
    {
        // action body
        $Db = new Application_Model_DbTable_ArticleSettings();
        $this->view->form = new Application_Form_ArticleSettings();
        $object = $Db->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->form->populate($object->toArray());

        $url = $this->view->url(array('action'=>'save-settings','option'=>'article','id'=>'1'));
        $this->view->form->setAction($url);
    }

    public function saveSettingsAction()
    {
        // action body
        $option = $this->getRequest()->getParams();

        $nameDb = 'Application_Model_DbTable_'.ucfirst($option['option']).'Settings';
        $nameForm = 'Application_Form_'.ucfirst($option['option']).'Settings';

        $Db = new $nameDb();
        $this->view->form = new $nameForm();

        $object = $Db->find($option['id'])->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $object->setFromArray($data);
            $Db->update($object->toArray());

            return $this->_helper->redirector('settings-'.$option['option'],'cms-admin','default');
        }//closing curly bracket
    }

    public function sortCategoryAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Category();
        
        $select = $Db->select()->where('sub_category = ?',0)->order('position_category');
        $this->view->listCategory = $Db->fetchAll($select);
    }

    public function sortSubCategoryAction()
    {
        // action body
        $DbCategory = new Application_Model_DbTable_Category();
        $DbArticle = new Application_Model_DbTable_Article();

        $id = $this->getRequest()->getParams('id');

        $selectCategory = $DbCategory->select()->where('sub_category = ?',$id['id'])->order('position_category');
        $this->view->listCategory = $DbCategory->fetchAll($selectCategory);

        $selectArticle = $DbArticle->select()->where('id_category = ?',$id['id'])->order('position_article');
        $this->view->listArticle = $DbArticle->fetchAll($selectArticle);

        $object = $DbCategory->find($id['id'])->current();
        $this->view->nameSortedCategory = $object->toArray();
    }

    public function sortArticleAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Article();
        $DbCategoryName = new Application_Model_DbTable_Category();

        $id = $this->getRequest()->getParams('sub');

        $select = $Db->select()->where('id_category = ?',$id['sub'])->order('position_article');
        $this->view->listArticle = $Db->fetchAll($select);

        $object = $DbCategoryName->find($id['id'])->current();

        $this->view->nameSortedCategory = $object->toArray();
        $this->view->categories = $id['sub'];
    }

    public function saveSortedAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Category();

        $val = explode('/',$_SERVER['REQUEST_URI']);
        $val[3] = str_replace('&', '', $val[3]);
        $value = explode('set[]=', $val[3]);

        for ($i=1; $i < count($value); $i++) { 
            $Db->update(array('position_category'=>$i),array('id_category = '.$value[$i]));
        }

        $this->_helper->layout->clearIdentity();
        return $this->_helper->redirector('sort-sub-category','cms-admin','default');
    }

    public function saveSortedArticleAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Article();

        $val = explode('/',$_SERVER['REQUEST_URI']);
        $val[3] = str_replace('&', '', $val[3]);
        $value = explode('set[]=', $val[3]);

        for ($i=1; $i < count($value); $i++) { 
            $Db->update(array('position_article'=>$i),array('id_article = '.$value[$i]));
        }

        $this->_helper->layout->clearIdentity();
        return $this->_helper->redirector('sort-sub-category','cms-admin','default');
    }

    public function updateSitenameAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Settings();
        $object = $Db->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $object->setFromArray($data);
            $Db->update($object->toArray(),'id_settings = 1');

            return $this->_helper->redirector('options','cms-admin','default');
        }//closing curly bracket
    }

    public function sidebarAction()
    {
        // action body
        $id = $this->getRequest()->getParams('id');

        $Db = new Application_Model_DbTable_Sidebar();
        $object = $Db->find($id['id'])->current();

        $this->view->form = new Application_Form_Sidebar();
        $this->view->sidebar = $object->toArray();

        if (!$object) {
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);
        }

        $this->view->form->populate($object->toArray());

        $url = $this->view->url(array('action'=>'save-sidebar'));
        $this->view->form->setAction($url);
    }

    public function listSidebarAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Sidebar();
        $this->view->data = $Db->fetchAll();
    }

    public function addSidebarAction()
    {
        // action body
        if ($this->getRequest()->isPost()) {
            
            $form = new Application_Form_Sidebar();

            if ($form->isValid($this->getRequest()->getPost())) {
                            
                $data=$form->getValues();
                            
                $Db = new Application_Model_DbTable_Sidebar();

                $id = $Db->insert($data);
            }
        }else
            throw new Zend_Controller_Action_Exception("Błąd: wykonanie akcji jest nie możliwe!", 404);

        return $this->_helper->redirector('list-sidebar','cms-admin','default');
    }

    public function saveSidebarAction()
    {
        // action body
        $id = $this->getRequest()->getParams('id');

        $Db = new Application_Model_DbTable_Sidebar();
        $object = $Db->find($id['id'])->current();
        
        $this->view->form = new Application_Form_Sidebar();

        if (!$object) {
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $object->setFromArray($data);
            $Db->update($object->toArray(),'id_sidebar = '.$id['id']);

            return $this->_helper->redirector('sidebar','cms-admin','default',array('id'=>$id['id']));
        }//closing curly bracket
    }

    public function newSidebarAction()
    {
        // action body
        $this->view->form = new Application_Form_Sidebar();

        $url = $this->view->url(array('action'=>'add-sidebar'));
        $this->view->form->setAction($url);
    }

    public function listProductAction()
    {
        // action body
        $Db = new Application_Model_DbTable_Product();
        $DbProductCategory = new Application_Model_DbTable_ProductCategory();
        $DbCategory = new Application_Model_DbTable_Category();
        
        $this->view->data = $Db->fetchAll();
        $this->view->dataProductCategory = $DbProductCategory->fetchAll();
        $this->view->dataCategory = $DbCategory->fetchAll();
    }

    public function productAction()
    {
        // action body        
        $id = $this->getRequest()->getParams();

        $Db = new Application_Model_DbTable_Product();

        $select = $Db->fetchRow($Db->select()->where('id_product = ?',$id['id']));

        $this->view->formCategory = new Application_Form_ListProduct();

        $this->view->formAddedCategory = new Application_Form_AddedProduct();

        $this->view->form = new Application_Form_Product();
        $this->view->product = $select;

        if (!$select) 
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

        $this->view->form->populate($select->toArray(   ));

        $url = $this->view->url(array('action'=>'save-product'));
        $this->view->form->setAction($url);

        $urlJoin = $this->view->url(array('action'=>'join-product'));
        $this->view->formCategory->setAction($urlJoin);

        $urlUnplug = $this->view->url(array('action'=>'unplug-product'));
        $this->view->formAddedCategory->setAction($urlUnplug);
    }

    public function addProductAction()
    {
        // action body
        if ($this->getRequest()->isPost()) {
            
            $form = new Application_Form_Product();

            if ($form->isValid($this->getRequest()->getPost())) {
                            
                $data=$form->getValues();
                            
                $Db = new Application_Model_DbTable_Product();

                $id = $Db->insert($data);
            }
        }else
            throw new Zend_Controller_Action_Exception("Błąd: wykonanie akcji jest nie możliwe!", 404);

        return $this->_helper->redirector('list-product','cms-admin','default');
    }

    public function saveProductAction()
    {
        // action body
        $id = $this->getRequest()->getParams();

        $Db = new Application_Model_DbTable_Product();

        $object = $Db->find($id['id'])->current();
        
        $this->view->form = new Application_Form_Product();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błędny adres!", 404);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $object->setFromArray($data);
            $Db->update($object->toArray(),'id_product = '.$id['id']);

            return $this->_helper->redirector('product','cms-admin','default',array('id'=>$id['id']));
        }//closing curly bracket
    }

    public function delProductAction()
    {
        // action body
    }

    public function newProductAction()
    {
        // action body
        $this->view->form = new Application_Form_Product();

        $url = $this->view->url(array('action'=>'add-product'));
        $this->view->form->setAction($url);
    }

    public function settingsProductAction()
    {
        // action body
        $Db = new Application_Model_DbTable_ProductSettings();
        $this->view->form = new Application_Form_ProductSettings();
        $object = $Db->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->form->populate($object->toArray());

        $url = $this->view->url(array('action'=>'save-settings','option'=>'product','id'=>'1'));
        $this->view->form->setAction($url);
    }

    public function joinProductAction()
    {
        // action body
        $Db = new Application_Model_DbTable_ProductCategory();

        $id = $this->getRequest()->getParams();

        $postedValue = $this->getRequest()->getPost();

        foreach ($postedValue['id_category'] as $key) {
            $query = $Db->select()->where('id_category = ?',$key)->where('id_product = ?',$id['id']);
            if ($Db->fetchRow($query)) {
                //CATEGORY EXIST - DON'T ADD
            }else{
                $data = array('id_category'=>$key,'id_product'=>$id['id']);
                $result = $Db->insert($data);
            }
        }

        return $this->_helper->redirector('product','cms-admin','default',array('id'=>$id['id']));
    }

    public function unplugProductAction()
    {
        // action body
        $Db = new Application_Model_DbTable_ProductCategory();

        $id = $this->getRequest()->getParams();

        $postedValue = $this->getRequest()->getPost();
        
        foreach ($postedValue['id_category'] as $key) {
            $query = $Db->select()->where('id_category = ?',$key)->where('id_product = ?',$id['id']);

            $data = $Db->fetchRow($query);

            $result = $data->delete();
        }

        return $this->_helper->redirector('product','cms-admin','default',array('id'=>$id['id']));
    }


}

















