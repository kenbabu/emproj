<?php

/**
 *
 * Controller for the cart
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author RolandD
 * @author Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: cart.php 5105 2011-12-16 10:18:16Z electrocity $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
 * Controller for the cart view
 *
 * @package VirtueMart
 * @subpackage Cart
 * @author RolandD
 * @author Max Milbers
 */
class VirtueMartControllerCart extends JController {

    /**
     * Construct the cart
     *
     * @access public
     * @author Max Milbers
     */
    public function __construct() {
	parent::__construct();
	if (VmConfig::get('use_as_catalog', 0)) {
	    $app = JFactory::getApplication();
	    $app->redirect('index.php');
	} else {
	    if (!class_exists('VirtueMartCart'))
		require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
	    if (!class_exists('calculationHelper'))
		require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'calculationh.php');
	}
	$this->useSSL = VmConfig::get('useSSL', 0);
	$this->useXHTML = true;
    }

    /**
     * Show the main page for the cart
     *
     * @author Max Milbers
     * @author RolandD
     * @access public
     */
    public function Cart() {
	/* Create the view */
	$view = $this->getView('cart', 'html');
	/* Add the default model */
	$this->addModelPath(JPATH_VM_ADMINISTRATOR . DS . 'models');
	$view->setModel($this->getModel('user', 'VirtuemartModel'), false);
	$view->setModel($this->getModel('vendor', 'VirtuemartModel'), false);
	$view->setModel($this->getModel('userfields', 'VirtuemartModel'), true);
	$view->setModel($this->getModel('country', 'VirtuemartModel'), true);
	$view->setModel($this->getModel('state', 'VirtuemartModel'), true);

	/* Set the layout */
	$layoutName = JRequest::getWord('layout', 'default');
	$view->setLayout($layoutName);

	/* Display it all */
	$view->display();
    }

    /**
     * Add the product to the cart
     *
     * @author RolandD
     * @author Max Milbers
     * @access public
     */
    public function add() {
	$mainframe = JFactory::getApplication();
	if (VmConfig::get('use_as_catalog', 0)) {
	    $msg = JText::_('COM_VIRTUEMART_PRODUCT_NOT_ADDED_SUCCESSFULLY');
	    $type = 'error';
	    $mainframe->redirect('index.php', $msg, $type);
	}
	$cart = VirtueMartCart::getCart();
	if ($cart) {
		$virtuemart_product_ids = JRequest::getVar('virtuemart_product_id', array(), 'default', 'array');
		$success = true;
	    if ($cart->add($virtuemart_product_ids,$success)) {
		$msg = JText::_('COM_VIRTUEMART_PRODUCT_ADDED_SUCCESSFULLY');
		$mainframe->enqueueMessage($msg);
		$type = '';
	    } else {
		$msg = JText::_('COM_VIRTUEMART_PRODUCT_NOT_ADDED_SUCCESSFULLY');
		$type = 'error';
	    }
//			if (JRequest::getWord('format','') =='raw' ) {
//				JRequest::setVar('layout','minicart','POST');
//				$this->cart();
//				//$view->display();
//				return ;
//			} else {
	    $mainframe->enqueueMessage($msg, $type);
	    $mainframe->redirect('index.php?option=com_virtuemart&view=cart');
//			}
	} else {
	    $mainframe->enqueueMessage('Cart does not exist?', 'error');
	}
    }

    /**
     * Add the product to the cart, with JS
     *
     * @author Max Milbers
     * @access public
     */
    public function addJS() {

	//maybe we should use $mainframe->close(); or jexit();instead of die;
	/* Load the cart helper */
	//require_once(JPATH_VM_SITE.DS.'helpers'.DS.'cart.php');
	$this->json = null;
	$cart = VirtueMartCart::getCart(true, false);
	if ($cart) {
	    // Get a continue link */
	    $virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId();
	    if ($virtuemart_category_id) {
		$categoryLink = '&view=category&virtuemart_category_id=' . $virtuemart_category_id;
	    } else
		$categoryLink = '';
	    $continue_link = JRoute::_('index.php?option=com_virtuemart' . $categoryLink);
	    $virtuemart_product_ids = JRequest::getVar('virtuemart_product_id', array(), 'default', 'array');
	    $errorMsg = JText::_('COM_VIRTUEMART_CART_PRODUCT_ADDED');
	    if ($cart->add($virtuemart_product_ids, $errorMsg )) {
			
		$this->json->msg = '<a class="continue" href="' . $continue_link . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
		$this->json->msg .= '<a style ="float:right;" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart") . '">' . JText::_('COM_VIRTUEMART_CART_SHOW') . '</a>';
		if ($errorMsg) $this->json->msg .= '<div>'.$errorMsg.'</div>';
		$this->json->stat = '1';
	    } else {
		// $this->json->msg = '<p>' . $cart->getError() . '</p>';
		$this->json->msg = '<a class="continue" href="' . $continue_link . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
		$this->json->msg .= '<div>'.$errorMsg.'</div>';
		$this->json->stat = '2';
	    }
	} else {
	    $this->json->msg = '<a href="' . JRoute::_('index.php?option=com_virtuemart') . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
	    $this->json->msg .= '<p>' . JText::_('COM_VIRTUEMART_MINICART_ERROR') . '</p>';
	    $this->json->stat = '0';
	}
	echo json_encode($this->json);
	jExit();
    }

    /**
     * Add the product to the cart, with JS
     *
     * @author Max Milbers
     * @access public
     */
    public function viewJS() {

	if (!class_exists('VirtueMartCart'))
	    require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
	$cart = VirtueMartCart::getCart(false, false);
	$this->data = $cart->prepareAjaxData();
	$lang = JFactory::getLanguage();
	$extension = 'com_virtuemart';
	$lang->load($extension); //  when AJAX it needs to be loaded manually here >> in case you are outside virtuemart !!!
	if ($this->data->totalProduct > 1)
	    $this->data->totalProductTxt = JText::sprintf('COM_VIRTUEMART_CART_X_PRODUCTS', $this->data->totalProduct);
	else if ($this->data->totalProduct == 1)
	    $this->data->totalProductTxt = JText::_('COM_VIRTUEMART_CART_ONE_PRODUCT');
	else
	    $this->data->totalProductTxt = JText::_('COM_VIRTUEMART_EMPTY_CART');
	if ($this->data->dataValidated == true) {
	    $taskRoute = '&task=confirm';
	    $linkName = JText::_('COM_VIRTUEMART_CART_CONFIRM');
	} else {
	    $taskRoute = '';
	    $linkName = JText::_('COM_VIRTUEMART_CART_SHOW');
	}
	$this->data->cart_show = '<a style ="float:right;" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart" . $taskRoute, $this->useXHTML, $this->useSSL) . '">' . $linkName . '</a>';
	$this->data->billTotal = $lang->_('COM_VIRTUEMART_CART_TOTAL') . ' : <strong>' . $this->data->billTotal . '</strong>';
	echo json_encode($this->data);
	Jexit();
    }

    /**
     * For selecting couponcode to use, opens a new layout
     *
     * @author Max Milbers
     */
    public function edit_coupon() {
	/* Create the view */
	$view = $this->getView('cart', 'html');
	$view->setLayout('edit_coupon');

	$this->addModelPath(JPATH_VM_ADMINISTRATOR . DS . 'models');
	$view->setModel($this->getModel('coupon', 'VirtuemartModel'), true);

	/* Display it all */
	$view->display();
    }

    /**
     * Store the coupon code in the cart
     * @author Oscar van Eijk
     */
    public function setcoupon() {
	$mainframe = JFactory::getApplication();
	/* Get the coupon_code of the cart */
	$coupon_code = JRequest::getVar('coupon_code', ''); //TODO VAR OR INT OR WORD?
	if ($coupon_code) {

	    $cart = VirtueMartCart::getCart();
	    if ($cart) {
		$msg = $cart->setCouponCode($coupon_code);
		if (!empty($msg)) {
		    $mainframe->enqueueMessage($msg, 'error');
		}
//				$cart->setDataValidation(); //Not needed already done in the getCart function
		if ($cart->getInCheckOut()) {
		    $mainframe = JFactory::getApplication();
		    $mainframe->redirect('index.php?option=com_virtuemart&view=cart&task=checkout');
		}
	    }
	}
	self::Cart();
    }

    /**
     * For selecting shipment, opens a new layout
     *
     * @author Max Milbers
     */
    public function edit_shipment() {

	/* Create the view */
	$view = $this->getView('cart', 'html');
	$view->setLayout('select_shipment');

	$this->addModelPath(JPATH_VM_ADMINISTRATOR . DS . 'models');
	$view->setModel($this->getModel('shipmentmethod', 'VirtuemartModel'), true);

// 	$view->setModel($this->getModel('user', 'VirtuemartModel'), false);
	$view->setModel($this->getModel('userfields', 'VirtuemartModel'), true);

	/* Display it all */
	$view->display();
    }

    /**
     * Sets a selected shipment to the cart
     *
     * @author Max Milbers
     */
    public function setshipment() {

	/* Get the shipment ID from the cart */
	$virtuemart_shipmentmethod_id = JRequest::getInt('virtuemart_shipmentmethod_id', '0');
	if ($virtuemart_shipmentmethod_id) {
	    //Now set the shipment ID into the cart
	    $cart = VirtueMartCart::getCart();
	    if ($cart) {
		if (!class_exists('vmPSPlugin')) require(JPATH_VM_PLUGINS . DS . 'vmpsplugin.php');
		JPluginHelper::importPlugin('vmshipment');
		$cart->setShipment($virtuemart_shipmentmethod_id);
		//Add a hook here for other payment methods, checking the data of the choosed plugin
		$_dispatcher = JDispatcher::getInstance();
		$_retValues = $_dispatcher->trigger('plgVmOnSelectCheckShipment', array(   $cart));
		$dataValid = true;
		foreach ($_retValues as $_retVal) {
		    if ($_retVal === true ) {// Plugin completed succesfull; nothing else to do
			$cart->setCartIntoSession();
			break;
		    } else if ($_retVal === false ) {
		       $mainframe = JFactory::getApplication();
		       $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=editshipment',$this->useXHTML,$this->useSSL), $_retVal);
			break;
		    }
		}

		if ($cart->getInCheckOut()) {
		    $mainframe = JFactory::getApplication();
		    $mainframe->redirect('index.php?option=com_virtuemart&view=cart&task=checkout');
		}
	    }
	}
	self::Cart();
    }

    /**
     * To select a payment method
     *
     * @author Max Milbers
     */
    public function editpayment() {
	/* Create the view */
	$view = $this->getView('cart', 'html');
	$view->setLayout('select_payment');

	$this->addModelPath(JPATH_VM_ADMINISTRATOR . DS . 'models');
	$view->setModel($this->getModel('paymentmethod', 'VirtuemartModel'), true);

	/* Display it all */
	$view->display();
    }

    /**
     * To set a payment method
     *
     * @author Max Milbers
     * @author Oscar van Eijk
     * @author Valerie Isaksen
     */
    function setpayment() {

	/* Get the payment id of the cart */
	//Now set the payment rate into the cart
	$cart = VirtueMartCart::getCart();
	if ($cart) {
		if(!class_exists('vmPSPlugin')) require(JPATH_VM_PLUGINS.DS.'vmpsplugin.php');
	    JPluginHelper::importPlugin('vmpayment');
	    //Some Paymentmethods needs extra Information like
	    $virtuemart_paymentmethod_id = JRequest::getInt('virtuemart_paymentmethod_id', '0');
	    $cart->setPaymentMethod($virtuemart_paymentmethod_id);

	    //Add a hook here for other payment methods, checking the data of the choosed plugin
	    $_dispatcher = JDispatcher::getInstance();
	    $_retValues = $_dispatcher->trigger('plgVmOnSelectCheckPayment', array( $cart));
	    $dataValid = true;
	    foreach ($_retValues as $_retVal) {
		if ($_retVal === true ) {// Plugin completed succesfull; nothing else to do
		    $cart->setCartIntoSession();
		    break;
		} else if ($_retVal === false ) {
		   $mainframe = JFactory::getApplication();
		   $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment',$this->useXHTML,$this->useSSL), $_retVal);
		    break;
		}
	    }
//			$cart->setDataValidation();	//Not needed already done in the getCart function

	    if ($cart->getInCheckOut()) {
		$mainframe = JFactory::getApplication();
		$mainframe->redirect('index.php?option=com_virtuemart&view=cart&task=checkout', $msg);
	    }
	}
	self::Cart();
    }

    /**
     * Delete a product from the cart
     *
     * @author RolandD
     * @access public
     */
    public function delete() {
	$mainframe = JFactory::getApplication();
	/* Load the cart helper */
	$cart = VirtueMartCart::getCart();
	if ($cart->removeProductCart())
	    $mainframe->enqueueMessage(JText::_('COM_VIRTUEMART_PRODUCT_REMOVED_SUCCESSFULLY'));
	else
	    $mainframe->enqueueMessage(JText::_('COM_VIRTUEMART_PRODUCT_NOT_REMOVED_SUCCESSFULLY'), 'error');

	$mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart'));
    }

    /**
     * Delete a product from the cart
     *
     * @author RolandD
     * @access public
     */
    public function update() {
	$mainframe = JFactory::getApplication();
	/* Load the cart helper */
	$cartModel = VirtueMartCart::getCart();
	if ($cartModel->updateProductCart())
	    $mainframe->enqueueMessage(JText::_('COM_VIRTUEMART_PRODUCT_UPDATED_SUCCESSFULLY'));
	else
	    $mainframe->enqueueMessage(JText::_('COM_VIRTUEMART_PRODUCT_NOT_UPDATED_SUCCESSFULLY'), 'error');

	$mainframe->redirect('index.php?option=com_virtuemart&view=cart');
    }

    /**
     * Checks for the data that is needed to process the order
     *
     * @author Max Milbers
     *
     *
     */
    public function checkout() {
	//Tests step for step for the necessary data, redirects to it, when something is lacking

	$cart = VirtueMartCart::getCart();
	if ($cart && !VmConfig::get('use_as_catalog', 0)) {
	    $cart->checkout();
	}
    }

    /**
     * Executes the confirmDone task,
     * cart object checks itself, if the data is valid
     *
     * @author Max Milbers
     *
     *
     */
    public function confirm() {

	//Use false to prevent valid boolean to get deleted
	$cart = VirtueMartCart::getCart(false);
	if ($cart) {
	    $cart->confirmDone();
	    $view = $this->getView('cart', 'html');
	    $view->setLayout('order_done');
	    /* Display it all */
	    $view->display();
	} else {
	    $mainframe = JFactory::getApplication();
	    $mainframe->redirect('index.php?option=com_virtuemart&view=cart', JText::_('COM_VIRTUEMART_CART_DATA_NOT_VALID'));
	}
    }

    function cancel() {
	$mainframe = JFactory::getApplication();
	$mainframe->redirect('index.php?option=com_virtuemart&view=cart', 'Cancelled');
    }

}

//pure php no Tag
