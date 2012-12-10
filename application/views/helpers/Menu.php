<?php 

/**
* MENU CLASS
*/
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
	public function menu()
	{
		$Category = new Application_Model_DbTable_Category();
		$selectCategory = $Category->select()->from('category')->where('visible_category = ?','true')->order('position_category');

		//LIST OF CATEGORIES - THE VALUE USED TO GENERATE CATEGORIES
		$categoryMenu = $Category->fetchAll($selectCategory);

		//LIST OF CATEGORIES - THE VALUE USED TO GENERATE SUBCATEGORIES
		$subcategoryMenu = $Category->fetchAll($selectCategory);

		$Article = new Application_Model_DbTable_Article();
		$selectArticle = $Article->select()->from('article')->where('visible_article = ?','true')->order('position_article');

		//LIST OF ARTICLES - THE VALUE USED TO GENERATE ARTICLES
		$articleMenu = $Article->fetchAll($selectArticle);

		$Product = Zend_Db_Table::getDefaultAdapter();

		//LIST OF PRODUCTS - THE VALUE USED TO GENERATE PRODUCTS
		$query = $Product->select()->from('product_category')->joinInner('product','product_category.id_product = product.id_product')->order('product_category.id_product');
        $productMenu = $Product->fetchAll($query);	

		return $this->view->partial('menu.phtml',array('categoryMenu'=>$categoryMenu, 'subcategoryMenu'=>$subcategoryMenu,'articleMenu'=>$articleMenu,'productMenu'=>$productMenu));
	}
}