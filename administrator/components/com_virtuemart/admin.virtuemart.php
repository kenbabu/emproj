<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
*
* @version $Id: admin.virtuemart.php 4885 2011-11-30 20:14:42Z electrocity $
* @package VirtueMart
* @subpackage core
* @copyright Copyright (C) VirtueMart Team - All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/

if (!class_exists( 'VmConfig' )) require(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
// Access check.
// if ( !VmConfig::isJ15()) {
	// if (!JFactory::getUser()->authorise('core.manage', 'com_virtuemart')) {
		// return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	// }
// }
// vmSetStartTime('test');
// vmTime('Smallest Unit','test');

//This is for akeeba release system, it must be executed before any other task
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'liveupdate'.DS.'liveupdate.php';
if(JRequest::getCmd('view','') == 'liveupdate') {
    LiveUpdate::handleRequest();
    return;
}


vmJsApi::jQuery();
vmJsApi::jSite();
// check for permission Only vendor and Admin can use VM2 BE
// this makes trouble somehow, we need to check if the perm object works not too strict maybe
/*if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
if(!Permissions::getInstance()->check('admin','storeowner')){
	die( 'Access restricted to Vendor and Administrator only' );
}*/
/* Require specific controller if requested */
if($_controller = JRequest::getWord('controller', JRequest::getWord('view', 'virtuemart'))) {
	if (file_exists(JPATH_VM_ADMINISTRATOR.DS.'controllers'.DS.$_controller.'.php')) {
		// Only if the file exists, since it might be a Joomla view we're requesting...
		require (JPATH_VM_ADMINISTRATOR.DS.'controllers'.DS.$_controller.'.php');
	} else {
		// try plugins
		JPluginHelper::importPlugin('vmextended');
		$dispatcher = JDispatcher::getInstance();
		$results = $dispatcher->trigger('onVmAdminController', array($_controller));
		if (empty($results)) {
			$app = JFactory::getApplication();
			$app->enqueueMessage('Fatal Error in maincontroller admin.virtuemart.php: Couldnt find file '.$_controller);
			$app->redirect('index.php?option=com_virtuemart');
		}
	}
}

// Create the controller
$_class = 'VirtueMartController'.ucfirst($_controller);
$controller = new $_class();

// Perform the Request task
$controller->execute(JRequest::getWord('task', $_controller));

$controller->redirect();

// pure php no closing tag