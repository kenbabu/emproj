<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage   ratings
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: ratings.php 2233 2010-01-21 21:21:29Z SimonHodgkiss $
*/

// @todo a link or tooltip to show the details of shop user who posted comment
// @todo more flexible templating, theming, etc..

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
AdminUIHelper::startAdminArea();
/* Get the component name */
$option = JRequest::getWord('option');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="header">
	<div id="filterbox">
	<table>
	  <tr>
		 <td align="left" width="100%">
			<?php echo JText::_('COM_VIRTUEMART_FILTER'); ?>:
			<input type="text" name="filter_ratings" value="<?php echo JRequest::getVar('filter_ratings', ''); ?>" />
			<button onclick="this.form.submit();"><?php echo JText::_('COM_VIRTUEMART_GO'); ?></button>
			<button onclick="document.adminForm.filter_ratings.value='';"><?php echo JText::_('COM_VIRTUEMART_RESET'); ?></button>
		 </td>
	  </tr>
	</table>
	</div>
	<div id="resultscounter" ><?php echo $this->pagination->getResultsCounter();?></div>
</div>


<div style="text-align: left;">
	<table class="adminlist" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th><input type="checkbox" name="toggle" value="" onclick="checkAll('<?php echo count($this->ratingslist); ?>')" /></th>
		<th><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_DATE', 'created_on', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
		<th><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_PRODUCT_NAME', 'product_name', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
		<th><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_RATE_NOM', 'rating', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
		<th width="20"><?php echo JHTML::_('grid.sort', 'COM_VIRTUEMART_PUBLISHED', 'published', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if (count($this->ratingslist) > 0) {
		$i = 0;
		$k = 0;
		$keyword = JRequest::getWord('keyword');
		foreach ($this->ratingslist as $key => $review) {
			$checked = JHTML::_('grid.id', $i , $review->virtuemart_rating_id);
			$published = JHTML::_('grid.published', $review, $i );
			?>
			<tr class="row<?php echo $k ; ?>">
				<!-- Checkbox -->
				<td><?php echo $checked; ?></td>
				<!-- Username + time -->
				<?php $link = 'index.php?option='.$option.'&view=ratings&task=listreviews&virtuemart_product_id='.$review->virtuemart_product_id; ?>
				<td><?php echo JHTML::_('link', $link,vmJsApi::date($review->created_on,'LC2',true) , array("title" => JText::_('COM_VIRTUEMART_RATING_EDIT_TITLE'))); ?></td>
				<!-- Product name -->
				<?php $link = 'index.php?option='.$option.'&view=product&task=edit&virtuemart_product_id='.$review->virtuemart_product_id ; ?>
				<td><?php echo JHTML::_('link', JRoute::_($link), $review->product_name, array('title' => JText::_('COM_VIRTUEMART_EDIT').' '.$review->product_name)); ?></td>
				<!-- Stars rating -->
				<td>
				<?php echo JHTML::_('image', JURI::root().'/components/com_virtuemart/assets/images/stars/'.round($review->rating).'.gif',$review->rating,array("title" => (JText::_('COM_VIRTUEMART_RATING_TITLE').' : '. $review->rating . ' :: ' . $this->max_rating))); ?>
				</td>
				<!-- published -->
				<td><?php echo $published; ?></td>
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
<input type="hidden" name="filter_order" value="<?php echo $this->lists['filter_order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['filter_order_Dir']; ?>" />
<input type="hidden" name="task" value="ratings" />
<input type="hidden" name="option" value="com_virtuemart" />
<input type="hidden" name="view" value="ratings" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php AdminUIHelper::endAdminArea(); ?>

