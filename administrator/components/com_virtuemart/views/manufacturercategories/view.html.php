<?php
/**
*
* Manufacturer Category View
*
* @package	VirtueMart
* @subpackage Manufacturer Category
* @author Patrick Kohl
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: view.html.php 4747 2011-11-17 22:54:03Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
jimport( 'joomla.application.component.view');

/**
 * HTML View class for maintaining the list of manufacturer categories
 *
 * @package	VirtueMart
 * @subpackage Manufacturer Categories
 * @author Patrick Kohl
 */
class VirtuemartViewManufacturercategories extends JView {

	function display($tpl = null) {

		// Load the helper(s)
		$this->loadHelper('adminui');
		$this->loadHelper('shopFunctions');
		$this->loadHelper('html');

		// get necessary model
		$model = $this->getModel();

		$viewName=ShopFunctions::SetViewTitle('MANUFACTURER_CATEGORY');
		$this->assignRef('viewName',$viewName);

                $layoutName = JRequest::getWord('layout', 'default');
		if ($layoutName == 'edit') {

			$manufacturerCategory = $model->getManufacturerCategory();
			$this->assignRef('manufacturerCategory',	$manufacturerCategory);

			ShopFunctions::addStandardEditViewCommands($manufacturerCategory->virtuemart_manufacturercategories_id);


        }
        else {

			$manufacturerCategories = $model->getManufacturerCategories();
			$this->assignRef('manufacturerCategories',	$manufacturerCategories);

			ShopFunctions::addStandardDefaultViewCommands();
			$lists = ShopFunctions::addStandardDefaultViewLists($model);

		}
		parent::display($tpl);
	}

}
// pure php no closing tag
