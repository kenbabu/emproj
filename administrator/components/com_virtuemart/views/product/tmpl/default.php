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
* @version $Id: product.php 3304 2011-05-20 06:57:27Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
AdminUIHelper::startAdminArea();

/* Load some variables */
$search_date = JRequest::getVar('search_date', null); // Changed search by date
$now = getdate();
$nowstring = $now["hours"].":".substr('0'.$now["minutes"], -2).' '.$now["mday"].".".$now["mon"].".".$now["year"];
$search_order = JRequest::getVar('search_order', '>');
$search_type = JRequest::getVar('search_type', 'product');
$virtuemart_category_id = JRequest::getInt('virtuemart_category_id', false);
if ($product_parent_id=JRequest::getInt('product_parent_id', false))   $col_product_name='COM_VIRTUEMART_PRODUCT_CHILDREN_LIST'; else $col_product_name='COM_VIRTUEMART_PRODUCT_NAME';

?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="header">
<div id="filterbox">
	<table class="">
		<tr>
			<td align="left">
			<?php echo JText::_('COM_VIRTUEMART_FILTER') ?>:
				<select class="inputbox" id="virtuemart_category_id" name="virtuemart_category_id" onchange="document.adminForm.submit(); return false;">
					<option value=""><?php echo JText::sprintf( 'COM_VIRTUEMART_SELECT' ,  JText::_('COM_VIRTUEMART_CATEGORY')) ; ?></option>
					<?php echo $this->category_tree; ?>
				</select>
				<?php echo JText::_('COM_VIRTUEMART_PRODUCT_LIST_SEARCH_BY_DATE') ?>&nbsp;
					<input type="text" value="<?php echo JRequest::getVar('filter_product'); ?>" name="filter_product" size="25" />
				<?php
					echo $this->lists['search_type'];
					echo $this->lists['search_order'];
					echo vmJsApi::jDate(JRequest::getVar('search_date', $nowstring), 'search_date', 'class="datepicker" size="9"');
					//echo JHTML::calendar( JRequest::getVar('search_date', $nowstring), 'search_date', 'search_date', '%H.%M %d.%m.%Y', 'size="20"');
				?>
				<button onclick="this.form.submit();"><?php echo JText::_('COM_VIRTUEMART_GO'); ?></button>
				<button onclick="document.adminForm.filter_product.value=''; document.adminForm.search_type.options[0].selected = true;"><?php echo JText::_('COM_VIRTUEMART_RESET'); ?></button>
			</td>

		</tr>
	</table>
	</div>
	<div id="resultscounter"><?php echo $this->pagination->getResultsCounter(); ?></div>

</div>

<div style="text-align: left;">
<?php
// $this->productlist

?>
	<table class="adminlist" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th><input type="checkbox" name="toggle" value="" onclick="checkAll('<?php echo count($this->productlist); ?>')" /></th>
		<th><?php echo JHTML::_('grid.sort', $col_product_name, 'product_name', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
		<?php if (!$product_parent_id ) { ?>
                <th><?php echo JText::_('COM_VIRTUEMART_PRODUCT_CHILDREN_OF'); ?></th>
                <?php } ?>
                <th><?php echo JText::_('COM_VIRTUEMART_PRODUCT_PARENT_LIST_CHILDREN'); ?></th>
                <th><?php echo JText::_('COM_VIRTUEMART_PRODUCT_MEDIA'); ?></th>
		<th><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_PRODUCT_SKU', 'product_sku', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
		<th><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_PRODUCT_PRICE_TITLE', 'product_price', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
<?php /*		<th><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_CATEGORY', 'c.category_name', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th> */ ?>
<th><?php echo JText::_( 'COM_VIRTUEMART_CATEGORY'); ?></th>
		<!-- Only show reordering fields when a category ID is selected! -->
		<?php
		$num_rows = 0;
		if( $virtuemart_category_id ) { ?>
			<th>
				<?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_FIELDMANAGER_REORDER', 'ordering', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?>
				<?php echo JHTML::_('grid.order', $this->productlist); //vmCommonHTML::getSaveOrderButton( $num_rows, 'changeordering' ); ?>
			</th>
		<?php } ?>
		<th><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_MANUFACTURER_S', 'mf_name', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
		<th><?php echo JText::_('COM_VIRTUEMART_REVIEW_S'); ?></th>
		<th width="40px" ><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_PUBLISHED', 'published', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
	                <th><?php echo 'id' //echo JHTML::_('grid.sort', 'COM_VIRTUEMART_PRODUCT_LIST_VENDOR_NAME', 'vendor_name', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>

        </tr>
	</thead>
	<tbody>
	<?php
	if ($total = count($this->productlist) ) {
		$i = 0;
		$k = 0;
		$keyword = JRequest::getWord('keyword');
		foreach ($this->productlist as $key => $product) {
			$checked = JHTML::_('grid.id', $i , $product->virtuemart_product_id,null,'virtuemart_product_id');
			$published = JHTML::_('grid.published', $product, $i );
			?>
			<tr class="row<?php echo $k ; ?>">
				<!-- Checkbox -->
				<td><?php echo $checked; ?></td>
				<!-- Product name -->
				<?php
				$link = 'index.php?option=com_virtuemart&view=product&task=edit&virtuemart_product_id='.$product->virtuemart_product_id.'&product_parent_id='.$product->product_parent_id;
                                /* Product list should be ordered */
				$parent_id = JRequest::getVar('product_parent_id');

				?>
				<td><?php
                        echo JHTML::_('link', JRoute::_($link), $product->product_name, array('title' => JText::_('COM_VIRTUEMART_EDIT').' '.$product->product_name));

                                ?></td>
				<!-- Vendor name -->
                                <?php if (!$product_parent_id ) { ?>
				<td><?php
                                if ($product->product_parent_id  ) {
							VirtuemartViewProduct::displayLinkToParent($product->product_parent_id);
						}
                                   ?></td>
				<!-- Vendor name -->
                                <?php } ?>
				<td><?php
						 VirtuemartViewProduct::displayLinkToChildList($product->virtuemart_product_id , $product->product_name);
                                                 ?>
                                </td>
				<!-- Media -->
				<?php
					/* Create URL */
					$link = JRoute::_('index.php?view=media&virtuemart_product_id='.$product->virtuemart_product_id.'&option=com_virtuemart');
				?>
				<td><?php echo JHTML::_('link', $link, '<span class="icon-nofloat vmicon vmicon-16-media"></span> ('.$product->mediaitems.')', 'title ="'. JText::_('COM_VIRTUEMART_MEDIA_MANAGER').'" ' );
				 ?></td>
				<!-- Product SKU -->
				<td><?php echo $product->product_sku; ?></td>
				<!-- Product price -->
				<td><?php echo isset($product->product_price_display)? $product->product_price_display:JText::_('COM_VIRTUEMART_NO_PRICE_SET') ?></td>
				<!-- Category name -->
				<td><?php //echo JHTML::_('link', JRoute::_('index.php?view=category&task=edit&virtuemart_category_id='.$product->virtuemart_category_id.'&option=com_virtuemart'), $product->category_name);
					echo $product->categoriesList;
				?></td>
				<!-- Reorder only when category ID is present -->
				<?php if( $virtuemart_category_id ) { ?>
					<td class="order">
						<span><?php echo $this->pagination->orderUpIcon( $i, true, 'orderup', 'Move Up', $product->ordering ); ?></span>
						<span><?php echo $this->pagination->orderDownIcon( $i, $total , true, 'orderdown', 'Move Down', $product->ordering ); ?></span>
						<input class="ordering" type="text" name="order[<?php echo $product->id?>]" id="order[<?php echo $i?>]" size="5" value="<?php echo $product->ordering; ?>" style="text-align: center" />
						<?php // echo vmCommonHTML::getOrderingField( $product->ordering ); ?>
					</td>
				<?php } ?>
				<!-- Manufacturer name -->
				<td><?php echo JHTML::_('link', JRoute::_('index.php?view=manufacturer&task=edit&virtuemart_manufacturer_id[]='.$product->virtuemart_manufacturer_id.'&option=com_virtuemart'), $product->mf_name); ?></td>
				<!-- Reviews -->
				<?php $link = 'index.php?option=com_virtuemart&view=ratings&task=listreviews&virtuemart_product_id='.$product->virtuemart_product_id; ?>
				<td><?php echo JHTML::_('link', $link, $product->reviews.' ['.JText::_('COM_VIRTUEMART_REVIEW_FORM_LBL').']'); ?></td>
				<!-- published -->
				<td><?php echo $published; ?></td>
                                <!-- Vendor name -->
				<td><?php echo $product->virtuemart_product_id; // echo $product->vendor_name; ?></td>
			</tr>
		<?php
			$k = 1 - $k;
			$i++;
		}
	}
	?>
	</tbody>
	<tfoot>
		<tr>
		<td colspan="16">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
		</tr>
	</tfoot>
	</table>
</div>
<!-- Hidden Fields -->
<input type="hidden" name="option" value="com_virtuemart" />
<input type="hidden" name="view" value="product" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="product_parent_id" value="<?php echo JRequest::getInt('product_parent_id', 0); ?>" />
<?php /*<input type="hidden" name="virtuemart_product_price_id" value="<?php echo $this->virtuemart_product_price_id; ?>" /> */ ?>
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['filter_order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['filter_order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

<?php AdminUIHelper::endAdminArea(); ?>
