<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: view.html.php 4700 2011-11-14 05:50:36Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
jimport( 'joomla.application.component.view');

/**
 * HTML View class for the VirtueMart Component
 *
 * @package		VirtueMart
 * @author
 */
class VirtuemartViewMedia extends JView {

	function display($tpl = null) {

		// Load the helper(s)
		$this->loadHelper('adminui');
		$this->loadHelper('shopFunctions');
		$this->loadHelper('html');
		$this->loadHelper('permissions');
		$this->loadHelper('html');
		//@todo should be depended by loggedVendor
		$vendorId=1;
		$this->assignRef('vendorId', $vendorId);

		// TODO add icon for media view
		$viewName=ShopFunctions::SetViewTitle();
		$this->assignRef('viewName',$viewName);

		$model = $this->getModel('media');
		$this->assignRef('perms', Permissions::getInstance());

		$layoutName = JRequest::getWord('layout', 'default');
		if ($layoutName == 'edit') {

			$media = $model->getFile();
			$this->assignRef('media',	$media);

			$isNew = ($media->virtuemart_media_id < 1);
			if ($isNew) {
				$usermodel = $this->getModel('user', 'VirtuemartModel');
				$usermodel->setCurrent();
				$userDetails = $usermodel->getUser();
				if(empty($userDetails->virtuemart_vendor_id)){
					JError::raiseError(403,'Forbidden for non vendors');
				}
				if(empty($media->virtuemart_vendor_id))$media->virtuemart_vendor_id = $userDetails->virtuemart_vendor_id;
			}

			ShopFunctions::addStandardEditViewCommands();

        }
        else {
        	$virtuemart_product_id = JRequest::getInt('virtuemart_product_id',0);
        	$cat_id = JRequest::getInt('virtuemart_category_id',0);

			$files = $model->getFiles(false,false,$virtuemart_product_id,$cat_id);
			$this->assignRef('files',	$files);

			JToolBarHelper::customX('synchronizeMedia', 'new', 'new', JText::_('COM_VIRTUEMART_TOOLS_SYNC_MEDIA_FILES'),false);
			ShopFunctions::addStandardDefaultViewCommands(false);
			$lists = ShopFunctions::addStandardDefaultViewLists($model,null,null,'searchMedia');
			$options = array( '' => JText::_('COM_VIRTUEMART_LIST_EMPTY_OPTION'),
				'product' => JText::_('COM_VIRTUEMART_PRODUCT'),
				'category' => JText::_('COM_VIRTUEMART_CATEGORY'),
				'manufacturer' => JText::_('COM_VIRTUEMART_MANUFACTURER'),
				'vendor' => JText::_('COM_VIRTUEMART_VENDOR')
				);
			$lists['search_type'] = VmHTML::selectList('search_type', JRequest::getVar('search_type'),$options,1,'','onchange="this.form.submit();"');
			$this->assignRef('lists', $lists);

		}
		parent::display($tpl);
	}

}
// pure php no closing tag