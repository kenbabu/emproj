<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author RolandD
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: category.php 4930 2011-12-05 10:15:01Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
* Class Description
*
* @package VirtueMart
* @author RolandD
*/
class VirtueMartControllerCategory extends JController {

    /**
    * Method Description
    *
    * @access public
    * @author RolandD
    */
    public function __construct() {
     	 parent::__construct();

     	 $this->registerTask('browse','category');
   	}

	/**
	* Function Description
	*
	* @author RolandD
	* @access public
	*/
	public function Category() {
	
		/* Create the view */
		$view = $this->getView('category', 'html');

		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart' . DS . 'models');
		/* Add the default model */
		$view->setModel($this->getModel('category', 'VirtuemartModel'), true);

		/* Add the product model */
		$view->setModel($this->getModel('product', 'VirtuemartModel'));
		
		if (JRequest::getvar('search')) $view->display();
		else {
			/* Display it all */
			$safeurlparams = array('virtuemart_category_id'=>'INT','virtuemart_manufacturer_id'=>'INT','virtuemart_currency_id'=>'INT','return'=>'BASE64','lang'=>'CMD','orderby'=>'CMD','limitstart'=>'CMD','order'=>'CMD','limit'=>'CMD');
			parent::display(true, $safeurlparams);
		}
	}
}
// pure php no closing tag
