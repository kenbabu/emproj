<?php
/**
*
* Handle the category view
*
* @package	VirtueMart
* @subpackage
* @author Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2011 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: view.html.php 2703 2011-02-11 22:06:12Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
jimport('joomla.application.component.view');

/**
* Handle the category view
*
* @package VirtueMart
* @author Max Milbers
* @todo add full path to breadcrumb
*/
class VirtuemartViewCategories extends JView {

	public function display($tpl = null) {

		$document = JFactory::getDocument();

		$mainframe = JFactory::getApplication();
		$pathway = $mainframe->getPathway();

		/* Set the helper path */
		$this->addHelperPath(JPATH_VM_ADMINISTRATOR.DS.'helpers');

		/* Load helpers */
		$this->loadHelper('image');
		$vendorId = JRequest::getInt('vendorid', 1);

		$vendorModel = $this->getModel('vendor');

		$vendorModel->setId(1);
		$vendor = $vendorModel->getVendor();
		//$this->assignRef('vendor',$vendor);

		$categoryModel = $this->getModel('category');
	    $categoryId = JRequest::getInt('virtuemart_category_id', 0);
		$this->assignRef('categoryModel', $categoryModel);
//		$categoryId = 0;	//The idea is that you can choose a parent catgory, this value should come from the joomla view parameter stuff
		$category = $categoryModel->getCategory($categoryId);
		//if($category->children)	$categoryModel->addImages($category->children);
		$cache = & JFactory::getCache('com_virtuemart','callback');
		$category->children = $cache->call( array( 'VirtueMartModelCategory', 'getChildCategoryList' ),$vendorId, $categoryId );
		//$category->children = $categoryModel->getChildCategoryList($vendorId, $categoryId);
		$categoryModel->addImages($category->children,1);

	   //Add the category name to the pathway
// 		$pathway->addItem(strip_tags($category->category_name)); //Todo what should be shown up?
		// Add the category name to the pathway
		if ($category->parents) {
			foreach ($category->parents as $c){
				$pathway->addItem(strip_tags($c->category_name),JRoute::_('index.php?option=com_virtuemart&view=categories&virtuemart_category_id='.$c->virtuemart_category_id));
			}
		} else {
			if(!empty($category->category_name)){
				$pathway->addItem(strip_tags($category->category_name,JRoute::_('index.php?option=com_virtuemart&view=categories&virtuemart_category_id='.$category->virtuemart_category_id)));
			} else {
				$pathway->addItem(strip_tags(JText::_('COM_VIRTUEMART_CATEGORY_TOP_LEVEL'),JRoute::_('index.php?option=com_virtuemart&view=categories&virtuemart_category_id='.$category->virtuemart_category_id)));
			}

		}

	   $this->assignRef('category', $category);

	    /* Set the titles */

		if ($category->category_name) $document->setTitle($category->category_name); //Todo same here, what should be shown up?
		else {
			$menus = &JSite::getMenu();
			$menu  = $menus->getActive();
			if(!empty($menu)){
				if (!class_exists('JParameter')) require(JPATH_VM_LIBRARIES . DS . 'joomla' . DS . 'html' . DS . 'parameter.php' );
				$menu_params = new JParameter( $menu->params );
			}

			if (empty($menu) || !$menu_params->get( 'page_title')) {
				$document->setTitle($vendor->vendor_store_name);
				$category->category_name = $vendor->vendor_store_name ;
			} else $category->category_name = $menu_params->get( 'page_title');
		}
		//Todo think about which metatags should be shown in the categories view
	    if ($category->metadesc) {
			$document->setDescription( $category->metadesc );
		} else $document->setDescription( $category->category_description );
		if ($category->metakey) {
			$document->setMetaData('keywords', $category->metakey);
		}
		if ($category->metarobot) {
			$document->setMetaData('robots', $category->metarobot);
		}

		//if ($mainframe->getCfg('MetaTitle') == '1') {
			$document->setMetaData('title', strip_tags($category->category_name));  //Maybe better category_name
		//}
		if ($mainframe->getCfg('MetaAuthor') == '1') {
			$document->setMetaData('author', $category->metaauthor);
		}

// 	    if(empty($category->category_template)){
// 	    	$catTpl = VmConfig::get('categorytemplate');
// 	    }else {
// 	    	$catTpl = $category->category_template;
// 	    }

	    shopFunctionsF::setVmTemplate($this,$category->category_template,0,$category->category_layout);

		parent::display($tpl);
	}
}


//no closing tag