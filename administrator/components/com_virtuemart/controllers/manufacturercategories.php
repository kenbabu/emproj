<?php
/**
*
* Manufacturer category controller
*
* @package	VirtueMart
* @subpackage Manufacturer Category
* @author Patrick Kohl
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: manufacturercategories.php 3438 2011-06-06 20:37:06Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if(!class_exists('VmController'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmcontroller.php');


/**
 * Manufacturer category controller
 *
 * @package    VirtueMart
 * @subpackage Manufacturer
 * @author
 */
class VirtuemartControllermanufacturercategories extends VmController {

	/**
	 * Method to display the view
	 *
	 * @access	public
	 * @author
	 */
	function __construct() {
		parent::__construct();

	}

	function Manufacturercategories () {

		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$view = $this->getView($this->_cname, $viewType);

		// Push a model into the view
		$model = $this->getModel( 'manufacturercategories' );
		if (!JError::isError($model)) {
			$view->setModel($model, true);
		}
		parent::display();
	}


}
// pure php no closing tag
