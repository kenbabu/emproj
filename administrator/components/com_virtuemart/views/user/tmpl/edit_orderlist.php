<?php
/**
*
* User details, Orderlist
*
* @package	VirtueMart
* @subpackage User
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: edit_orderlist.php 4690 2011-11-12 14:47:46Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$j15 = VmConfig::isJ15();
?>

<div id="editcell">
	<table class="adminlist" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th width="10">
			<?php echo JText::_('COM_VIRTUEMART_#'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_NUMBER'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_PRINT_VIEW'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_CDATE'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_MDATE'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_STATUS'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_TOTAL'); ?>
		</th>
	</thead>
	<?php
		$k = 0;
		$n = 1;
		foreach ($this->orderlist as $i => $row) {
			$editlink = JROUTE::_('index.php?option=com_virtuemart&view=orders&task=edit&virtuemart_order_id=' . $row->virtuemart_order_id);

			$print_url = JURI::base().'?option=com_virtuemart&view=orders&task=orderPrint&virtuemart_order_id='.$row->virtuemart_order_id.'&format=raw';
			$print_link = "&nbsp;<a href=\"javascript:void window.open('$print_url', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\">"
				. JHTML::_('image.site', 'printButton.png', ($j15 ? '/images/M_images/' : '/images/system/'), null, null, JText::_('COM_VIRTUEMART_PRINT'), array('align' => 'center', 'height'=> '16',  'width' => '16', 'border' => '0')).'</a>';

			?>
			<tr class="row<?php echo $k ; ?>">
				<td align="center">
					<?php echo $n++; ?>
				</td>
				<td align="left">
					<a href="<?php echo $editlink; ?>"><?php echo $row->order_number; ?></a>
				</td>
				<td align="center">
					<?php echo $print_link; ?>
				</td>
				<td align="left">
					<?php echo vmJsApi::date($row->created_on,'LC2',true); ?>
				</td>
				<td align="left">
					<?php echo vmJsApi::date($row->modified_on,'LC2',true); ?>
				</td>
				<td align="left">
					<?php echo ShopFunctions::getOrderStatusName($row->order_status); ?>
				</td>
				<td align="left">
					<?php echo $this->currency->priceDisplay($row->order_total,'',false); ?>
				</td>
			</tr>
	<?php
			$k = 1 - $k;
		}
	?>
	</table>
</div>
