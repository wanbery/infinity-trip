<?php 

/**
* MENU CLASS
*/
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
	public function menu()
	{
		$Category = new Application_Model_DbTable_Category();
		$selectCategory = $Category->select()->from('category',array('id_category', 'sub_category', 'visible_category', 'start_site_category', 'position_category', 'name_category', 'content_category', 'title_meta_category', 'keywords_meta_category', 'description_meta_category'))->where('visible_category = ?','true')->order('position_category');

		//LIST OF CATEGORIES - THE VALUE USED TO GENERATE CATEGORIES
		$categoryMenu = $Category->fetchAll($selectCategory);

		//LIST OF CATEGORIES - THE VALUE USED TO GENERATE SUBCATEGORIES
		$subcategoryMenu = $Category->fetchAll($selectCategory);

		$Article = new Application_Model_DbTable_Article();
		$selectArticle = $Article->select()->from('article',array('id_article', 'id_category', 'visible_article', 'position_article', 'name_article', 'content_article', 'title_meta_article', 'keywords_meta_article', 'description_meta_article'))->where('visible_article = ?','true')->order('position_article');

		//LIST OF ARTICLES - THE VALUE USED TO GENERATE ARTICLES
		$articleMenu = $Article->fetchAll($selectArticle);

		return $this->view->partial('menu.phtml',array('categoryMenu'=>$categoryMenu, 'subcategoryMenu'=>$subcategoryMenu,'articleMenu'=>$articleMenu));
	}
}