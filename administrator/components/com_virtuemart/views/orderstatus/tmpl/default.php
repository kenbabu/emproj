<?php
/**
*
* Description
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
* @version $Id: default.php 4690 2011-11-12 14:47:46Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

AdminUIHelper::startAdminArea();
$j15 = VmConfig::isJ15();
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div id="editcell">
		<table class="adminlist" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th width="10">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->orderStatusList); ?>);" />
			</th>
			<th width="10">
				<?php echo JText::_('COM_VIRTUEMART_#'); ?>
			</th>
			<th>
			<?php echo JHTML::_('grid.sort'
					, JText::_('COM_VIRTUEMART_ORDER_STATUS_NAME')
					, 'order_status_name'
					, $this->lists['filter_order_Dir']
					, $this->lists['filter_order']); ?>
			</th>
			<th>
			<?php echo JHTML::_('grid.sort'
					, JText::_('COM_VIRTUEMART_ORDER_STATUS_CODE')
					, 'order_status_code'
					, $this->lists['filter_order_Dir']
					, $this->lists['filter_order']); ?>
			</th>
			<th>
				<?php echo JText::_('COM_VIRTUEMART_DESCRIPTION'); ?>
			</th>
			<th>
			<?php echo JHTML::_('grid.sort'
					, JText::_('COM_VIRTUEMART_ORDERING')
					, 'ordering'
					, $this->lists['filter_order_Dir']
					, $this->lists['filter_order']); ?>
			<?php echo JHTML::_('grid.order',  $this->orderStatusList ); ?>
			</th>
			<th width="20">
				<?php echo JText::_('COM_VIRTUEMART_PUBLISHED'); ?>
			</th>

		</tr>
		</thead>
		<?php
		$k = 0;
                $vmCoreStatusCode= $this->lists['vmCoreStatusCode'];
		for ($i = 0, $n = count($this->orderStatusList); $i < $n; $i++) {
			$row = $this->orderStatusList[$i];
			$published = JHTML::_('grid.published', $row, $i );
			$checked = JHTML::_('grid.id', $i, $row->virtuemart_orderstate_id);

                        $coreStatus = (in_array($row->order_status_code, $this->lists['vmCoreStatusCode']));
			$image = ($j15) ? 'checked_out.png' : 'admin/checked_out.png';
			$image = JHtml::_('image.administrator', $image, '/images/', null, null, JText::_('COM_VIRTUEMART_ORDER_STATUS_CODE_CORE'));
			$checked = ($coreStatus) ?
				'<span class="hasTip" title="'. JText::_('COM_VIRTUEMART_ORDER_STATUS_CODE_CORE').'">'. $image .'</span>' :
				JHTML::_('grid.id', $i, $row->virtuemart_orderstate_id);

			$editlink = JROUTE::_('index.php?option=com_virtuemart&view=orderstatus&task=edit&cid[]=' . $row->virtuemart_orderstate_id);
			$deletelink	= JROUTE::_('index.php?option=com_virtuemart&view=orderstatus&task=remove&cid[]=' . $row->virtuemart_orderstate_id);
			$ordering = $row->ordering ;
		?>
			<tr class="row<?php echo $k ; ?>">
				<td width="10">
					<?php echo $checked; ?>
				</td>
				<td width="10">
					<?php echo $row->virtuemart_orderstate_id; ?>
				</td>
				<td align="left">
					<a href="<?php echo $editlink; ?>"><?php echo JText::_($row->order_status_name); ?></a>
				</td>
				<td align="left">
					<?php echo $row->order_status_code; ?>
				</td>
				<td align="left">
					<?php echo JText::_($row->order_status_description); ?>
				</td>
				<td align="center" class="order">
					<span><?php echo $this->pagination->orderUpIcon($i, true, 'orderUp', 'Move Up'); ?></span>
					<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderDown', 'Move Down'); ?></span>
					<input class="ordering" type="text" name="order[<?php echo $i?>]" id="order[<?php echo $i?>]" size="5" value="<?php echo $row->ordering; ?>" style="text-align: center" />
				</td>
				<td align="center"><?php echo $published; ?></td>
			</tr>
			<?php
// 			<td class="order">
// 						<span><?php echo ShopFunctions::orderUpIcon( $i, true, 'orderup', 'Move Up' ); ></span>
// 						<span><?php echo ShopFunctions::orderDownIcon( $i, $n, true, 'orderdown', 'Move Down' ); ></span>
// 					<input class="ordering" type="text" name="order[]" size="5" value="<?php echo $row->ordering;>" class="text_area" style="text-align: center" />
// 				</td>
			$k = 1 - $k;
		}
		?>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
</div>

	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['filter_order_Dir']; ?>" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['filter_order']; ?>" />
	<input type="hidden" name="option" value="com_virtuemart" />
	<input type="hidden" name="controller" value="orderstatus" />
	<input type="hidden" name="view" value="orderstatus" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

<?php AdminUIHelper::endAdminArea(); ?>
