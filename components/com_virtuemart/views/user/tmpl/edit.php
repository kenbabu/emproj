<?php
/**
*
* Modify user form view
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
* @version $Id: edit.php 4562 2011-10-26 21:28:08Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

//AdminMenuHelper::startAdminArea();

// Implement Joomla's form validation
JHTML::_('behavior.formvalidation');
JHTML::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/'); // VM_THEMEURL
?>
<style type="text/css">
.invalid {
	border-color: #f00;
	background-color: #ffd;
	color: #000;
}
label.invalid {
	background-color: #fff;
	color: #f00;
}
</style>
<script language="javascript">
function myValidator(f, t)
{
	f.task.value=t;

	if (f.task.value=='cancel') {
		f.submit();
		return true;
	}
	if (document.formvalidator.isValid(f)) {
		f.submit();
		return true;
	} else {
		var msg = '<?php echo addslashes( JText::_('COM_VIRTUEMART_USER_FORM_MISSING_REQUIRED_JS') ); ?>';
		alert (msg);
	}
	return false;
}
</script>

<?php echo shopFunctionsF::getLoginForm(false); ?>

<h1><?php echo JText::_('COM_VIRTUEMART_YOUR_ACCOUNT_DETAILS'); ?></h1>
<form method="post" id="adminForm" name="userForm" action="<?php echo JRoute::_('index.php?view=user',$this->useXHTML,$this->useSSL) ?>" class="form-validate">
<div style="text-align: right; width: 100%;">
	<button class="button" type="submit" onclick="javascript:return myValidator(userForm, 'saveuser');" ><?php echo $this->button_lbl ?></button>
	&nbsp;
	<button class="button" type="submit" onclick="javascript:return myValidator(userForm, 'cancel');" ><?php echo JText::_('COM_VIRTUEMART_CANCEL'); ?></button>
</div>
<?php // Loading Templates in Tabs

$tabarray = array();
if($this->userDetails->user_is_vendor){
	$tabarray['vendor'] = 'COM_VIRTUEMART_VENDOR';
}
$tabarray['shopper'] = 'COM_VIRTUEMART_SHOPPER_FORM_LBL';
$tabarray['user'] = 'COM_VIRTUEMART_USER_FORM_TAB_GENERALINFO';
if (!empty($this->shipto)) {
	$tabarray['shipto'] = 'COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL';
}
if (($_ordcnt = count($this->orderlist)) > 0) {
	$tabarray['orderlist'] = 'COM_VIRTUEMART_YOUR_ORDERS';
}


shopFunctionsF::buildTabs ($tabarray);

/*
 * TODO this Stuff should be converted in a payment module. But the idea to show already saved payment information to the user is a good one
 * So maybe we should place here a method (joomla plugin hook) which loads all published plugins, which already used by the user and display
 * them.
 */
//	echo $this->pane->startPanel( JText::_('COM_VIRTUEMART_SHOPPER_PAYMENT_FORM_LBL'), 'edit_payment' );
//	echo $this->loadTemplate('payment');
//	echo $this->pane->endPanel();

//	echo $this->pane->startPanel( JText::_('COM_VIRTUEMART_SHOPPER_SHIPMENT_FORM_LBL'), 'edit_shipto' );
//	echo $this->loadTemplate('shipto');
//	echo $this->pane->endPanel();
//	if ($this->shipto !== 0) {
//		// Note:
//		// Of the order of the tabs change here, change the startOffset value for
//		// JPane::getInstance() as well in view.html.php!
//		echo $this->pane->startPanel( JText::_('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'), 'edit_shipto' );
//		echo $this->loadTemplate('shipto');
//		echo $this->pane->endPanel();
//	}

// 	if (($_ordcnt = count($this->orderlist)) > 0) {
// 		echo $this->pane->startPanel( JText::_('COM_VIRTUEMART_ORDER_LIST_LBL') . ' (' . $_ordcnt . ')', 'edit_orderlist' );
// 		echo $this->loadTemplate('orderlist');
// 		echo $this->pane->endPanel();
// 	}

// 	if (!empty($this->userDetails->user_is_vendor)) {
// 		echo $this->pane->startPanel( JText::_('COM_VIRTUEMART_VENDOR_MOD'), 'edit_vendor' );
// 		echo $this->loadTemplate('vendor');
// 		echo $this->pane->endPanel();
// 	}

// 	echo $this->pane->endPane();
?>
<input type="hidden" name="option" value="com_virtuemart" />
<input type="hidden" name="controller" value="user" />
<input type="hidden" name="task" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

