<?php
/**
 *
 * Handle the orders view
 *
 * @package	VirtueMart
 * @subpackage Orders
 * @author Oscar van Eijk
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 5029 2011-12-12 10:27:18Z alatak $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
jimport('joomla.application.component.view');

// Set to '0' to use tabs i.s.o. sliders
// Might be a config option later on, now just here for testing.
define ('__VM_ORDER_USE_SLIDERS', 0);

/**
 * Handle the orders view
 */
class VirtuemartViewOrders extends JView {

	public function display($tpl = null)
	{
//		$mainframe = JFactory::getApplication();
//		$pathway = $mainframe->getPathway();
		$task = JRequest::getWord('task', 'list');

		$_currentUser = JFactory::getUser();
		$document = JFactory::getDocument();
		$document->setTitle( JText::_('COM_VIRTUEMART_ACC_ORDER_INFO') );
		if (!class_exists('VirtueMartModelOrders')) require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'orders.php');
		$orderModel = new VirtueMartModelOrders();

		if ($task == 'details') {

			$cuid = $_currentUser->get('id');
			if(!empty($cuid)){
				$virtuemart_order_id = JRequest::getInt('virtuemart_order_id',0) ;
				if (!$virtuemart_order_id) {
					$virtuemart_order_id = $orderModel->getOrderIdByOrderNumber(JRequest::getString('order_number'));
				}
				$orderDetails = $orderModel->getOrder($virtuemart_order_id);
				if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
				if(!Permissions::getInstance()->check("admin")) {
					if(!empty($orderDetails['details']['BT']->virtuemart_user_id)){
						if ($orderDetails['details']['BT']->virtuemart_user_id != $cuid) {
							echo JText::_('COM_VIRTUEMART_RESTRICTED_ACCESS');
							return;
						}
					}
				}
			}
			if ($orderPass = JRequest::getString('order_pass',false)){
				$orderNumber = JRequest::getString('order_number',false);
				$orderId = $orderModel->getOrderIdByOrderPass($orderNumber,$orderPass);
				if(empty($orderId)){
					echo JText::_('COM_VIRTUEMART_RESTRICTED_ACCESS');
					return;
				}
				$orderDetails = $orderModel->getOrder($orderId);

			}
			$shipment_name='';
			if (!class_exists('vmPSPlugin')) require(JPATH_VM_PLUGINS . DS . 'vmpsplugin.php');
			JPluginHelper::importPlugin('vmshipment');
			$dispatcher = JDispatcher::getInstance();
			$returnValues = $dispatcher->trigger('plgVmOnShowOrderFEShipment',array(  $orderDetails['details']['BT']->virtuemart_order_id, $orderDetails['details']['BT']->virtuemart_shipmentmethod_id, &$shipment_name));

			$payment_name='';
			if(!class_exists('vmPSPlugin')) require(JPATH_VM_PLUGINS.DS.'vmpsplugin.php');
			JPluginHelper::importPlugin('vmpayment');
			$dispatcher = JDispatcher::getInstance();
			$returnValues = $dispatcher->trigger('plgVmOnShowOrderFEPayment',array( $orderDetails['details']['BT']->virtuemart_order_id, $orderDetails['details']['BT']->virtuemart_paymentmethod_id,  &$payment_name));


			$this->assignRef('shipment_name', $shipment_name);
			$this->assignRef('payment_name', $payment_name);
			$this->assignRef('orderdetails', $orderDetails);

			// Implement the Joomla panels. If we need a ShipTo tab, make it the active one.
			// In tmpl/edit.php, this is the 4th tab (0-based, so set to 3 above)
			// jimport('joomla.html.pane');
			// $pane = JPane::getInstance((__VM_ORDER_USE_SLIDERS?'Sliders':'Tabs'));
			// $this->assignRef('pane', $pane);
		} else { // 'list' -. default
			$useSSL = VmConfig::get('useSSL',0);
			$useXHTML = true;
			$this->assignRef('useSSL', $useSSL);
			$this->assignRef('useXHTML', $useXHTML);
			if ($_currentUser->get('id') == 0) {
				// getOrdersList() returns all orders when no userID is set (admin function),
				// so explicetly define an empty array when not logged in.
				$orderList = array();
			} else {
				$orderList = $orderModel->getOrdersList($_currentUser->get('id'), true);
			}
			$this->assignRef('orderlist', $orderList);
		}

		if (!class_exists('CurrencyDisplay')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'currencydisplay.php');

		$currency = CurrencyDisplay::getInstance();
		$this->assignRef('currency', $currency);
		if(!class_exists('VirtueMartModelOrderstatus')) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'orderstatus.php');
		// Create a simple indexed array woth ordertatuses
		$orderStatusModel = new VirtueMartModelOrderstatus();
		$_orderstatuses = $orderStatusModel->getOrderStatusList();
		$orderstatuses = array();
		foreach ($_orderstatuses as $_ordstat) {
			$orderstatuses[$_ordstat->order_status_code] = JText::_($_ordstat->order_status_name);
		}



		$this->assignRef('orderstatuses', $orderstatuses);


		if(!class_exists('ShopFunctions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'shopfunctions.php');

		// this is no setting in BE to change the layout !
		//shopFunctionsF::setVmTemplate($this,0,0,$layoutName);

		parent::display($tpl);
	}
}
