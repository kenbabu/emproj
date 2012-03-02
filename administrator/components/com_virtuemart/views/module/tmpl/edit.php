<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage ShopperGroup
* @author Markus �hler
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: edit.php 4700 2011-11-14 05:50:36Z electrocity $
*/
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

AdminUIHelper::startAdminArea(); 
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">

<div class="col50">
	<fieldset>
	<legend><?php echo JText::_('COM_VIRTUEMART_SHOPPERGROUP_DETAILS'); ?></legend>
	<table class="admintable">			
		<tr>
			<td width="110" class="key">
				<label for="shopper_group_name">
					<?php echo JText::_('COM_VIRTUEMART_SHOPPERGROUP_NAME'); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="shopper_group_name" id="shopper_group_name" size="50" value="<?php echo $this->shoppergroup->shopper_group_name; ?>" />				
			</td>
		</tr>	
		<tr>
			<td width="110" class="key">
				<label for="virtuemart_vendor_id">
					<?php echo JText::_('COM_VIRTUEMART_VENDOR'); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="virtuemart_vendor_id" id="virtuemart_vendor_id" size="5" value="<?php echo $this->shoppergroup->virtuemart_vendor_id; ?>" /> 							
			</td>
		</tr>
		<tr>
      <td width="110" class="key">
        <label for="default">
          <?php echo JText::_('COM_VIRTUEMART_DEFAULT'); ?>:
        </label>
      </td>
      <td>
        <?php echo JHTML::_('select.booleanlist',  'default', 'class="inputbox"', $this->shoppergroup->default); ?>                
      </td>
    </tr>   			
		<tr>
			<td width="110" class="key">
				<label for="shopper_group_discount">
					<?php echo JText::_('COM_VIRTUEMART_SHOPPERGROUP_FORM_DISCOUNT'); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="shopper_group_discount" id="shopper_group_discount" size="5" value="<?php echo $this->shoppergroup->shopper_group_discount; ?>" />			
			</td>
		</tr>		
		<tr>
			<td width="110" class="key">
				<label for="show_price_including_tax">
					<?php echo JText::_('COM_VIRTUEMART_ADMIN_CFG_PRICES_INCLUDE_TAX'); ?>:
				</label>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist', 'show_price_including_tax', 'class="inputbox"', $this->shoppergroup->show_price_including_tax); ?>				
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="shopper_group_desc">
					<?php echo JText::_('COM_VIRTUEMART_SHOPPERGROUP_DESCRIPTION'); ?>:
				</label>
			</td>
			<td>
				<textarea rows="10" cols="30" name="shopper_group_desc" id="shopper_group_desc"><?php echo $this->shoppergroup->shopper_group_desc; ?></textarea>  				
			</td>
		</tr>					
	</table>
	</fieldset>
</div>

	<input type="hidden" name="virtuemart_shoppergroup_id" value="<?php echo $this->shoppergroup->virtuemart_shoppergroup_id; ?>" />
	<?php echo VmHTML::HiddenEdit('module') ?>
</form>

<?php AdminUIHelper::endAdminArea(); ?> 