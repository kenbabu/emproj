<?php
/**
*
* Handle the waitinglist
*
* @package	VirtueMart
* @subpackage Product
* @author RolandD
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: product_edit_waitinglist.php 2978 2011-04-06 14:21:19Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<table width="100%">
	<tr>
		<td valign="top" width="%100">

			<?php
			$i=0;
			$tables= array('categories'=>'','products'=>'','fields'=>'','customPlugins'=>'',);
			if (isset($this->product->customfields)) {
				foreach ($this->product->customfields as $customRow) {
					if ($customRow->is_cart_attribute) $cartIcone=  'default';
					else  $cartIcone= 'default-off';
					if ($customRow->field_type == 'Z') {

						$tables['categories'] .=  '
							<div class="vm_thumb_image">
								<span>'.$customRow->display.'</span>'.
								VirtueMartModelCustomfields::setEditCustomHidden($customRow, $i)
							  .'<div class="vmicon vmicon-16-remove"></div>
							</div>';

					} elseif ($customRow->field_type == 'R') {

						$tables['products'] .=  '
							<div class="vm_thumb_image">
								<span>'.$customRow->display.'</span>'.
								VirtueMartModelCustomfields::setEditCustomHidden($customRow, $i)
							  .'<div class="vmicon vmicon-16-remove"></div>
							</div>';

					} elseif ($customRow->field_type == 'G') {
						// no display (group of) child , handled by plugin;
					} elseif ($customRow->field_type == 'E'){
						$tables['customPlugins'] .= '
							<fieldset class="removable">
								<legend>'.JText::_($customRow->custom_title).'</legend>
								<span>'.$customRow->display.$customRow->custom_tip.'</span>'.
								VirtueMartModelCustomfields::setEditCustomHidden($customRow, $i)
							  .'<span class="vmicon icon-nofloat vmicon-16-'.$cartIcone.'"></span>
								<span class="vmicon vmicon-16-remove"></span>
							</fieldset>';
					} else {
						$tables['fields'] .= '<tr class="removable">
							<td>'.JText::_($customRow->custom_title).'</td>
							<td>'.$customRow->custom_tip.'</td>
							<td>'.$customRow->display.'</td>
							<td>'.JText::_($this->fieldTypes[$customRow->field_type]).
							VirtueMartModelCustomfields::setEditCustomHidden($customRow, $i)
							.'</td>
							<td>
							<span class="vmicon vmicon-16-'.$cartIcone.'"></span>
							</td>
							<td><span class="vmicon vmicon-16-remove"></span><input class="ordering" type="hidden" value="'.$customRow->ordering.'" name="field['.$i .'][ordering]" /></td>
						 </tr>';
						}

					$i++;
				}
			}

			 $emptyTable = '
				<tr>
					<td colspan="7">'.JText::_( 'COM_VIRTUEMART_CUSTOM_NO_TYPES').'</td>
				<tr>';
			?>
			<fieldset style="background-color:#F9F9F9;">
				<legend><?php echo JText::_('COM_VIRTUEMART_RELATED_CATEGORIES'); ?></legend>
				<?php echo JText::_('COM_VIRTUEMART_CATEGORIES_RELATED_SEARCH'); ?>
				<div class="jsonSuggestResults" style="width: auto;">
					<input type="text" size="40" name="search" id="relatedcategoriesSearch" value="" />
					<button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
				</div>
				<div id="custom_categories"><?php echo  $tables['categories']; ?></div>
			</fieldset>
			<fieldset style="background-color:#F9F9F9;">
				<legend><?php echo JText::_('COM_VIRTUEMART_RELATED_PRODUCTS'); ?></legend>
				<?php echo JText::_('COM_VIRTUEMART_PRODUCT_RELATED_SEARCH'); ?>
				<div class="jsonSuggestResults" style="width: auto;">
					<input type="text" size="40" name="search" id="relatedproductsSearch" value="" />
					<button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
				</div>
				<div id="custom_products"><?php echo  $tables['products']; ?></div>
			</fieldset>

			<fieldset style="background-color:#F9F9F9;">
				<legend><?php echo JText::_('COM_VIRTUEMART_CUSTOM_FIELD_TYPE' );?></legend>
				<div><?php echo  '<div class="inline">'.$this->customsList; ?></div>

				<table id="custom_fields" class="adminlist" cellspacing="0" cellpadding="0">
					<thead>
					<tr class="row1">
						<th><?php echo JText::_('COM_VIRTUEMART_TITLE');?></th>
						<th><?php echo JText::_('COM_VIRTUEMART_CUSTOM_TIP');?></th>
						<th><?php echo JText::_('COM_VIRTUEMART_VALUE');?></th>
						<th><?php echo JText::_('COM_VIRTUEMART_CART_PRICE');?></th>
						<th><?php echo JText::_('COM_VIRTUEMART_TYPE');?></th>
						<th><?php echo JText::_('COM_VIRTUEMART_CUSTOM_IS_CART_ATTRIBUTE');?></th>
						<th><?php echo JText::_('COM_VIRTUEMART_DELETE'); ?></th>
					</tr>
					</thead>
					<tbody id="custom_field">
						<?php
						if ($tables['fields']) echo $tables['fields'] ;
						else echo $emptyTable;
						?>
					</tbody>
				</table>
			</fieldset>
			<fieldset style="background-color:#F9F9F9;">
				<legend><?php echo JText::_('COM_VIRTUEMART_CUSTOM_EXTENSION'); ?></legend>
				<div id="custom_customPlugins"><?php echo  $tables['customPlugins']; ?></div>
			</fieldset>
		</td>

	</tr>
</table>

<div style="clear:both;"></div>
<div style="display:none;" class="customDelete remove"><span class="vmicon vmicon-16-trash"></span><?php echo JText::_('COM_VIRTUEMART_DELETE'); ?></div>

<script type="text/javascript">
	nextCustom = <?php echo $i ?>;

	jQuery(document).ready(function(){
		jQuery('#custom_field').sortable({
			update: function(event, ui) {
				jQuery(this).find('.ordering').each(function(index,element) {
					jQuery(element).val(index);
					//console.log(index+' ');

				});

			}
		});

	});
	jQuery('select#customlist').chosen().change(function() {
		selected = jQuery(this).find( 'option:selected').val() ;
		jQuery.getJSON('index.php?option=com_virtuemart&view=product&task=getData&format=json&type=fields&id='+selected+'&row='+nextCustom+'&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id; ?>',
		function(data) {
			jQuery.each(data.value, function(index, value){
				jQuery("#custom_"+data.table).append(value);
			});
		});
		nextCustom++;
	});

	jQuery('input#relatedproductsSearch').autocomplete({

		source: 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=relatedproducts&row='+nextCustom,
		select: function(event, ui){
			jQuery("#custom_products").append(ui.item.label);
			nextCustom++;
			jQuery(this).autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=relatedproducts&row='+nextCustom )
			jQuery('input#relatedcategoriesSearch').autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=relatedcategories&row='+nextCustom )
		},
		minLength:1,
		html: true
	});
	jQuery('input#relatedcategoriesSearch').autocomplete({

		source: 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=relatedcategories&row='+nextCustom,
		select: function(event, ui){
			jQuery("#custom_categories").append(ui.item.label);
			nextCustom++;
			jQuery(this).autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=relatedcategories&row='+nextCustom )
			jQuery('input#relatedcategoriesSearch').autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=relatedproducts&row='+nextCustom )
		},
		minLength:1,
		html: true
	});

</script>