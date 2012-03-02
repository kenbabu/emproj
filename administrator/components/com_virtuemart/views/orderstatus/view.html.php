<?php
/**
*
* List/add/edit/remove Order Status Types
*
* @package	VirtueMart
* @subpackage OrderStatus
* @author Oscar van Eijk
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
 * HTML View class for maintaining the list of order types
 *
 * @package	VirtueMart
 * @subpackage OrderStatus
 * @author Oscar van Eijk
 */
class VirtuemartViewOrderstatus extends JView {

	function display($tpl = null) {

		$option = JRequest::getCmd( 'option');
		$mainframe = JFactory::getApplication() ;

		// Load the helper(s)
		$this->loadHelper('adminui');
		$this->loadHelper('shopFunctions');
		$this->loadHelper('html');

		$model = $this->getModel();
		$orderStatus = $model->getOrderStatus();

		$viewName=ShopFunctions::SetViewTitle('',JText::_($orderStatus->order_status_name) );
		$this->assignRef('viewName',$viewName);

		$layoutName = JRequest::getWord('layout', 'default');

               
		if ($layoutName == 'edit') {
			$editor = JFactory::getEditor();

			if ($orderStatus->virtuemart_orderstate_id < 1) {

				$this->assignRef('ordering', JText::_('COM_VIRTUEMART_NEW_ITEMS_PLACE'));
			} else {
				// Ordering dropdown
				$qry = 'SELECT ordering AS value, order_status_name AS text'
					. ' FROM #__virtuemart_orderstates'
					. ' ORDER BY ordering';
				$ordering = JHTML::_('list.specificordering',  $orderStatus, $orderStatus->virtuemart_orderstate_id, $qry);
				$this->assignRef('ordering', $ordering);


			}
                           $lists['vmCoreStatusCode'] = $model->getVMCoreStatusCode();
			$this->assignRef('lists', $lists);
			// Vendor selection
			$vendor_model = $this->getModel('vendor');
			$vendor_list = $vendor_model->getVendors();
			$lists['vendors'] = JHTML::_('select.genericlist', $vendor_list, 'virtuemart_vendor_id', '', 'virtuemart_vendor_id', 'vendor_name', $orderStatus->virtuemart_vendor_id);

                     
			$this->assignRef('orderStatus', $orderStatus);
			$this->assignRef('editor', $editor);

			ShopFunctions::addStandardEditViewCommands();
		} else {

			$orderStatusList = $model->getOrderStatusList();
			$this->assignRef('orderStatusList', $orderStatusList);

			ShopFunctions::addStandardDefaultViewCommands();
			$lists = ShopFunctions::addStandardDefaultViewLists($model);
                        $lists['vmCoreStatusCode'] = $model->getVMCoreStatusCode();
			$this->assignRef('lists', $lists);
		}

		parent::display($tpl);
	}
}

//No Closing Tag
