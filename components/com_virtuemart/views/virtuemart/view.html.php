<?php
/**
 *
 * Description
 *
 * @package	VirtueMart
 * @subpackage
 * @author
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2011 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 4852 2011-11-28 22:10:02Z electrocity $
 */

# Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

# Load the view framework
jimport( 'joomla.application.component.view');

/**
 * Default HTML View class for the VirtueMart Component
 * @todo Find out how to use the front-end models instead of the backend models
 */
class VirtueMartViewVirtueMart extends JView {

	var $mediaModel = null;

	public function display($tpl = null) {

		/* MULTI-X
		 * $this->loadHelper('vendorHelper');
		* $vendorModel = new Vendor;
		* $vendor = $vendorModel->getVendor();
		* $this->assignRef('vendor',	$vendor);
		*/

		$vendorId = JRequest::getInt('vendorid', 1);

		$vendorModel = $this->getModel('vendor');

		$vendorModel->setId(1);
		$vendor = $vendorModel->getVendor();
		$this->assignRef('vendor',$vendor);
	
/* 	$db =& JFactory::getDBO();
 
	$q ="SELECT * FROM `#__virtuemart_manufacturers`as mf1 left join `#__fr_virtuemart_manufacturers` as mf2 on mf2.`virtuemart_manufacturer_id`=mf1.`virtuemart_manufacturer_id` 
	where mf1.mf_name LIKE 'Manu%'
";
	$db->setQuery($q);
	$row = $db->loadObjectList();
	print_r($row); */

		if(!VmConfig::get('shop_is_offline',0)){

			$categoryModel = $this->getModel('category');
			$productModel = $this->getModel('product');
			$products = array();
			$categoryId = JRequest::getInt('catid', 0);
			$cache = & JFactory::getCache('com_virtuemart','callback');

			$categoryChildren = $cache->call( array( 'VirtueMartModelCategory', 'getChildCategoryList' ),$vendorId, $categoryId );
			// self::$categoryTree = self::categoryListTreeLoop($selectedCategories, $cid, $level, $disabledFields);
			
			//$categoryChildren = $categoryModel->getChildCategoryList($vendorId, $categoryId);
			
			//$categoryChildren = $categoryModel->getChildCategoryList($vendorId, $categoryId);
			$categoryModel->addImages($categoryChildren,1);

			$this->assignRef('categories',	$categoryChildren);

			if(!class_exists('CurrencyDisplay'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'currencydisplay.php');
			$currency = CurrencyDisplay::getInstance( );
			$this->assignRef('currency', $currency);

			if (VmConfig::get('show_featured', 1)) {
				$products['featured'] = $productModel->getProductListing('featured', 5);
				$productModel->addImages($products['featured'],1);
			}

			if (VmConfig::get('show_latest', 1)) {
				$products['latest']= $productModel->getProductListing('latest', 5);
				$productModel->addImages($products['latest'],1);
			}

			if (VmConfig::get('show_topTen', 1)) {
				$products['topten']= $productModel->getProductListing('topten', 5);
				$productModel->addImages($products['topten'],1);
			}
			$this->assignRef('products', $products);

			if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
			$showBasePrice = Permissions::getInstance()->check('admin'); //todo add config settings
			$this->assignRef('showBasePrice', $showBasePrice);

			//		$layoutName = VmConfig::get('vmlayout','default');

			$layout = VmConfig::get('vmlayout','default');
			$this->setLayout($layout);

		} else {
			$this->setLayout('off_line');
		}

		# Set the titles
		$document = JFactory::getDocument();

		$error = JRequest::getInt('error',0);

		//Todo this may not work everytime as expected, because the error must be set in the redirect links.
		if(!empty($error)){
			/*			$head = $document->getHeadData();
			 $head['title'] = JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
			$document->setHeadData($head);*/
			$document->setTitle(JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND').JText::sprintf('COM_VIRTUEMART_HOME',$vendor->vendor_store_name));
		} else {
			$document->setTitle(JText::sprintf('COM_VIRTUEMART_HOME',$vendor->vendor_store_name));
		}

		$template = VmConfig::get('vmtemplate','default');
		if (is_dir(JPATH_THEMES.DS.$template)) {
			$mainframe = JFactory::getApplication();
			$mainframe->set('setTemplate', $template);
		}



		parent::display($tpl);

	}

}
# pure php no closing tag