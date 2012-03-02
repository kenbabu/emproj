<?php
/**
*
* Order detail view
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
* @version $Id: details_order.php 5029 2011-12-12 10:27:18Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
    	<tr>
		<td class="orders-key"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PO_NUMBER') ?></td>
		<td class="orders-key" align="left">
                <?php echo $this->orderdetails['details']['BT']->order_number;?>
                </td>
	</tr>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PO_DATE') ?></td>
		<td align="left"><?php echo vmJsApi::date($this->orderdetails['details']['BT']->created_on,'LC2',true); ?></td>
	</tr>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PO_STATUS') ?></td>
		<td align="left"><?php echo $this->orderstatuses[$this->orderdetails['details']['BT']->order_status]; ?></td>
	</tr>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_LAST_UPDATED') ?></td>
		<td align="left"><?php  echo vmJsApi::date($this->orderdetails['details']['BT']->modified_on,'LC2',true); ?></td>
	</tr>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPMENT_LBL') ?></td>
		<td align="left"><?php
		echo $this->shipment_name;
		?></td>
	</tr>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PAYMENT_LBL') ?></td>
		<td align="left"><?php echo $this->payment_name; ?>
		</td>
	</tr>

<tr>
		<td class="orders-key"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL') ?></td>
		<td class="orders-key" align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_total); ?></td>
	</tr>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SUBTOTAL') ?></td>
		<td align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_subtotal); ?></td>
	</tr>

	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPPING') ?></td>
		<td align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_shipment); ?></td>
	</tr>
       	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPPING_TAX') ?></td>
		<td align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_shipment_tax); ?></td>
	</tr>
<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PAYMENT') ?></td>
		<td align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_payment); ?></td>
	</tr>
       	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PAYMENT_TAX') ?></td>
		<td align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_payment_tax); ?></td>
	</tr>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') ?></td>
		<td align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_discount); ?></td>
	</tr>
<?php if (VmConfig::get('coupons_enable',0)=='1') : ?>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_COUPON_DISCOUNT') ?></td>
		<td align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->coupon_discount); ?></td>
	</tr>
<?php  endif; ?>
	<tr>
		<td class=""><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL_TAX') ?></td>
		<td align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_tax); ?></td>
	</tr>

</table>
