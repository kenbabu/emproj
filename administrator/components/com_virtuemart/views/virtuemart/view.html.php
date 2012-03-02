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
* @version $Id: view.html.php 4885 2011-11-30 20:14:42Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
jimport( 'joomla.application.component.view');
jimport('joomla.html.pane');

/**
 * HTML View class for the VirtueMart Component
 *
 * @package		VirtueMart
 * @author
 */
class VirtuemartViewVirtuemart extends JView {

	function display($tpl = null) {

		// Load the helper(s)
		$this->loadHelper('adminui');
		$this->loadHelper('image');

		$model = $this->getModel();

		$nbrCustomers = $model->getTotalCustomers();
		$this->assignRef('nbrCustomers', $nbrCustomers);

		$nbrActiveProducts = $model->getTotalActiveProducts();
		$this->assignRef('nbrActiveProducts', $nbrActiveProducts);
		$nbrInActiveProducts = $model->getTotalInActiveProducts();
		$this->assignRef('nbrInActiveProducts', $nbrInActiveProducts);
		$nbrFeaturedProducts = $model->getTotalFeaturedProducts();
		$this->assignRef('nbrFeaturedProducts', $nbrFeaturedProducts);

		$ordersByStatus = $model->getTotalOrdersByStatus();
		$this->assignRef('ordersByStatus', $ordersByStatus);

		$recentOrders = $model->getRecentOrders();
			if(!class_exists('CurrencyDisplay'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'currencydisplay.php');

			/* Apply currency This must be done per order since it's vendor specific */
			$_currencies = array(); // Save the currency data during this loop for performance reasons
			foreach ($recentOrders as $virtuemart_order_id => $order) {

				//This is really interesting for multi-X, but I avoid to support it now already, lets stay it in the code
				if (!array_key_exists('v'.$order->virtuemart_vendor_id, $_currencies)) {
					$_currencies['v'.$order->virtuemart_vendor_id] = CurrencyDisplay::getInstance('',$order->virtuemart_vendor_id);
				}
				$order->order_total = $_currencies['v'.$order->virtuemart_vendor_id]->priceDisplay($order->order_total,'',false);
			}
		$this->assignRef('recentOrders', $recentOrders);
		$recentCustomers = $model->getRecentCustomers();
		$this->assignRef('recentCustomers', $recentCustomers);
		// Options button.
		// if ( !VmConfig::isJ15()) {
			// if (JFactory::getUser()->authorise('core.admin', 'com_virtuemart')) {
				// JToolBarHelper::preferences('com_virtuemart');
			// }
		// }
		parent::display($tpl);
	}
}

//pure php no tag