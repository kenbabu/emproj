<?php
/**
*
* Base controller Frontend
*
* @package		VirtueMart
* @subpackage
* @author Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2011 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: virtuemart.php 4852 2011-11-28 22:10:02Z electrocity $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
 * VirtueMart Component Controller
 *
 * @package		VirtueMart
 */
class VirtueMartControllerVirtuemart extends JController
{

	function __construct() {
		parent::__construct();
		if (VmConfig::get('shop_is_offline') == '1') {
		    JRequest::setVar( 'layout', 'off_line' );
	    }
	    else {
		    JRequest::setVar( 'layout', 'default' );
	    }
	}

	function Virtuemart() {

		$view = $this->getView(JRequest::getWord('view', 'virtuemart'), 'html');

		/* Load the backend models */
		/* Push a model into the view */
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart' . DS . 'models');
		/* Category functions */
		$view->setModel( $this->getModel( 'category', 'VirtuemartModel' ));

		/* Vendor functions */
		$view->setModel( $this->getModel( 'vendor', 'VirtuemartModel' ));

		/* Product functions */
		$view->setModel( $this->getModel( 'product', 'VirtuemartModel' ));

		/* Set the layout */
		$view->setLayout(JRequest::getWord('layout','default'));

		/* Display it all */
		$safeurlparams = array('virtuemart_category_id'=>'INT','virtuemart_currency_id'=>'INT','return'=>'BASE64','lang'=>'CMD');
		parent::display(true, $safeurlparams);//$view->display();
	}
}
 //pure php no closing tag
