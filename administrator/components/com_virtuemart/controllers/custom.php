<?php
/**
*
* custom controller
*
* @package	VirtueMart
* @subpackage
* @author Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: custom.php 3039 2011-04-14 22:37:04Z Electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if(!class_exists('VmController'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmcontroller.php');


/**
 * Product Controller
 *
 * @package    VirtueMart
 * @author Max Milbers
 */
class VirtuemartControllerCustom extends VmController {

	/**
	 * Method to display the view
	 *
	 * @access	public
	 * @author
	 */
	function __construct() {
		parent::__construct('virtuemart_custom_id');

//		$this->setMainLangKey('CUSTOM');
		$document = JFactory::getDocument();
		$viewType	= $document->getType();
		$view = $this->getView('custom', $viewType);

		// Push a model into the view
		$model = $this->getModel('custom');
		if (!JError::isError($model)) {
			$view->setModel($model, true);
		}

	}
	public function edit(){

		$document = JFactory::getDocument();
		$viewType	= $document->getType();
		$view = $this->getView($this->_cname, $viewType);
		JRequest::setVar('layout', 'edit');
		// Pushing default model
// 		$view->setModel( $this->getModel( 'custom', 'VirtueMartModel' ), true );
		$view->setModel( $this->getModel( 'customfields', 'VirtueMartModel' ), false );

		parent::display();
	}

	function viewJson() {

		/* Create the view object. */
		$view = $this->getView('custom', 'json');

		/* Standard model */
// 		$view->setModel( $this->getModel( 'custom', 'VirtueMartModel' ), true );

		/* Now display the view. */
		$view->display(null);
	}
	function save() {
		$data = JRequest::get('post');
		// onSaveCustom plugin;
		parent::save($data);
	}

	/**
	* Clone a product
	*
	* @author RolandD, Max Milbers
	*/
	public function createClone() {
		$mainframe = Jfactory::getApplication();

		/* Load the view object */
		$view = $this->getView('custom', 'html');

		$model = $this->getModel('custom');
		$msgtype = '';
		$cids = JRequest::getVar($this->_cidName, JRequest::getVar('virtuemart_custom_id',array(),'', 'ARRAY'), '', 'ARRAY');
		jimport( 'joomla.utilities.arrayhelper' );
		JArrayHelper::toInteger($cids);
		foreach ($cids as $custom_id) {
			if ($model->createClone($custom_id)) $msg = JText::_('COM_VIRTUEMART_CUSTOM_CLONED_SUCCESSFULLY');
			else {
				$msg = JText::_('COM_VIRTUEMART_CUSTOM_NOT_CLONED_SUCCESSFULLY').' : '.$custom_id;
				$msgtype = 'error';
			}
		}
		$mainframe->redirect('index.php?option=com_virtuemart&view=custom', $msg, $msgtype);
	}
}
// pure php no closing tag
