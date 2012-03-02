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
* @version $Id: default.php 4690 2011-11-12 14:47:46Z electrocity $
*/
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access'); 

AdminUIHelper::startAdminArea(); 

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
  <div id="editcell">
	  <table class="adminlist" cellspacing="0" cellpadding="0">
	    <thead>
		    <tr>
		      <th width="10">
			      <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->shoppergroups); ?>);" />
		      </th>
		      <th>
			      <?php echo JText::_('COM_VIRTUEMART_SHOPPERGROUP_NAME'); ?>
		      </th>
		      <th>
			      <?php echo JText::_('COM_VIRTUEMART_VENDOR'); ?>
		      </th>
		      <th>
			      <?php echo JText::_('COM_VIRTUEMART_SHOPPERGROUP_DESCRIPTION'); ?>
		      </th>
		      <th>
			      <?php echo JText::_('COM_VIRTUEMART_SHOPPERGROUP_INCLUDE_TAX'); ?>
		      </th>
		      <th>
            <?php echo JText::_('COM_VIRTUEMART_SHOPPERGROUP_LIST_DISCOUNT'); ?>
          </th>
		      <th width="20">
			      <?php echo JText::_('COM_VIRTUEMART_DEFAULT'); ?>
		      </th>
		    </tr>
	    </thead><?php
	    
	    $k = 0;
	    for ($i = 0, $n = count( $this->shoppergroups ); $i < $n; $i++) {
		    $row = $this->shoppergroups[$i];

		    $checked = JHTML::_('grid.id', $i, $row->virtuemart_shoppergroup_id);
		    $editlink = JROUTE::_('index.php?option=com_virtuemart&controller=shoppergroup&task=edit&cid[]=' . $row->virtuemart_shoppergroup_id); ?>
	      
	      <tr class="row<?php echo $k ; ?>">
			    <td width="10">
				    <?php echo $checked; ?>
			    </td>
			    <td align="left">
			      <a href="<?php echo $editlink; ?>"><?php echo $row->shopper_group_name; ?></a>
			    </td>
			    <td align="left">
            <?php echo $row->virtuemart_vendor_id; ?>
          </td>
			    <td align="left">
				    <?php echo $row->shopper_group_desc; ?>
			    </td>
			    <td>
				    <?php echo $row->show_price_including_tax; ?>
			    </td>
			    <td>
				    <?php echo $row->shopper_group_discount; ?>
			    </td>
			    <td>
				    <?php echo $row->default; ?>
			    </td>
	      </tr><?php
		    $k = 1 - $k;
	    } ?>
	    <tfoot>
		    <tr>
		      <td colspan="10">
			      <?php echo $this->pagination->getListFooter(); ?>
		      </td>
		    </tr>
	    </tfoot>
	  </table>
  </div>

  <input type="hidden" name="option" value="com_virtuemart" />
  <input type="hidden" name="controller" value="shoppergroup" />
  <input type="hidden" name="view" value="shoppergroup" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
</form><?php 
AdminUIHelper::endAdminArea(); ?> 