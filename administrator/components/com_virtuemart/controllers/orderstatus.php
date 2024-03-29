<?php
/**
*
* Order status controller
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
* @version $Id: orderstatus.php 3504 2011-06-16 13:46:23Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if(!class_exists('VmController'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmcontroller.php');


/**
 * Controller class for the Order status
 *
 * @package    VirtueMart
 * @subpackage OrderStatus
 * @author     Oscar van Eijk
 */
class VirtuemartControllerOrderstatus extends VmController {

	/**
	 * Method to display the view
	 *
	 * @access public
	 * @author
	 */
	function __construct()
	{
		parent::__construct();

	}

	function Orderstatus () {

		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$view = $this->getView($this->_cname, $viewType);

		// Push a model into the view
		$model = $this->getModel($this->_cname);

		if (!JError::isError($model)) {
			$view->setModel($model, true);
		}

		parent::display();
	}

	/**
	 * Handle the edit task
	 */
	function edit(){

		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$view = $this->getView($this->_cname, $viewType);
		$view->setModel( $this->getModel( 'vendor', 'VirtueMartModel' ));

		parent::edit();
	}

}

//No Closing tag
