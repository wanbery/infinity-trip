<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $form = new Application_Form_Search();
        $url = $this->view->url(array('controller'=>'index','action'=>'search'),'default',true);
        $this->view->formSearch = $form;
        $this->view->formSearch->setAction($url);
    }

    public function indexAction()
    {
        // action body
        $Category = new Application_Model_DbTable_Category();
        $select = $Category->select()->where('start_site_category = ?','true');
        $titleDb = new Application_Model_DbTable_CategorySettings();
        $id_category = $this->getRequest()->getParams('id_category');

        $object = $titleDb->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->titleResult = $object->toArray();
        $this->view->category = $Category->fetchRow($select);
    }

    public function showAction()
    {
        // action body
    }

    public function categoryAction()
    {
        // action body
        $Category = new Application_Model_DbTable_Category();
        $titleDb = new Application_Model_DbTable_CategorySettings();
        $id_category = $this->getRequest()->getParams('id_category');

        $object = $titleDb->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->titleResult = $object->toArray();

        $select = $Category->select()->where('id_category = ?',$id_category['id_category'])->where('visible_category = ?','true')->order('position_category');
        $this->view->category = $Category->fetchRow($select);
        
        if (!$this->view->category) throw new Zend_Controller_Action_Exception('Błąd - brak kategorii', 404);
    }

    public function articlesAction()
    {
        // action body
        $Article = new Application_Model_DbTable_Article();
        $titleDb = new Application_Model_DbTable_ArticleSettings();
        $id_article = $this->getRequest()->getParams('id_article');

        $object = $titleDb->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->titleResult = $object->toArray();

        $select = $Article->select()->where('id_article = ?',$id_article['id_article'])->where('visible_article = ?','true')->order('position_article');

        $this->view->article = $Article->fetchRow($select);
   
        if (!$this->view->article) throw new Zend_Controller_Action_Exception('Błąd - brak artykuł', 404);
    }

    public function searchAction()
    {
        // action body
        $this->_helper->viewRenderer('search');

        $Category = new Application_Model_DbTable_Category();
        $Article = new Application_Model_DbTable_Article();
        $Product = new Application_Model_DbTable_Product();

        $form = new Application_Form_Search();
        
        $fraze = $this->getRequest()->getPost();

        $selectCategory = $Category->select()->where('visible_category = ?','true')
                                             ->where('name_category LIKE ?','%'.$fraze['search'].'%')
                                             ->orWhere('content_category LIKE ?','%'.$fraze['search'].'%')
                                             ->where('visible_category = ?','true');

        $selectArticle = $Article->select()->where('visible_article = ?','true')
                                           ->where('name_article LIKE ?','%'.$fraze['search'].'%')
                                           ->orWhere('content_article LIKE ?','%'.$fraze['search'].'%')
                                           ->where('visible_article = ?','true');

        $selectProduct = $Product->select()->where('visible_product = ?','true')
                                           ->where('name_product LIKE ?','%'.$fraze['search'].'%')
                                           ->orWhere('content_product LIKE ?','%'.$fraze['search'].'%')
                                           ->where('visible_product = ?','true');

        echo $selectProduct->__toString();

        if ($Category->fetchAll($selectCategory)!='' || $Article->fetchAll($selectArticle)!='' || $Product->fetchAll($selectProduct)!='') {
            foreach ($Category->fetchAll($selectCategory) as $categories) {
                echo '<br /><a href="'.$this->view->url(array('action'=>'category','id_category'=>$categories['id_category']),'default',true).'">'.$categories['name_category'].'</a>';
            }
        
            foreach ($Article->fetchAll($selectArticle) as $articles) {
                echo '<br /><a href="'.$this->view->url(array('action'=>'articles','id_category'=>$articles['id_category'],'id_article'=>$articles['id_article']),'default',true).'">'.$articles['name_article'].'</a>';
            }

            foreach ($Product->fetchAll($selectProduct) as $products) {
                echo '<br /><a href="'.$this->view->url(array('action'=>'product','id_product'=>$products['id_product']),'default',true).'">'.$products['name_product'].'</a>';
            }
        }else echo 'Brak wyników dla podanej frazy: '.$fraze['search'];

        echo " </p>";
    }

    public function sitemapAction()
    {
        $Category = new Application_Model_DbTable_Category();
        $Article = new Application_Model_DbTable_Article();
        
        $select = $Category->select()->where('visible_category = ?','true')->order('position_category');
        $this->view->categoryMap = $Category->fetchAll($select);
        $this->view->subcategoryMap = $Category->fetchAll($select);

        $select = $Article->select()->where('visible_article = ?','true')->order('position_article');
        $this->view->articleMap = $Article->fetchAll($select);
    }

    public function productAction()
    {
        // action body
        $Product = new Application_Model_DbTable_Product();
        $titleDb = new Application_Model_DbTable_ProductSettings();
        $id_product = $this->getRequest()->getParams();

        $object = $titleDb->find(1)->current();

        if (!$object)
            throw new Zend_Controller_Action_Exception("Błąd: obiekt nie istnieje!", 404);

        $this->view->titleResult = $object->toArray();

        $select = $Product->select()->where('id_product = ?',$id_product['id_product'])->where('visible_product = ?','true')->order('position_product');
        $this->view->product = $Product->fetchRow($select);
        
        if (!$this->view->product) throw new Zend_Controller_Action_Exception('Błąd - brak produktu', 404);
    }


}





