<?php
/**
*
* View for the PluginResponse
*
* @package	VirtueMart
* @subpackage
* @author Valérie Isaksen
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: view.html.php 3386 2011-05-27 12:34:11Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
jimport( 'joomla.application.component.view');

/**
* View for the shopping cart
* @package VirtueMart
* @author Valérie Isaksen
*/
class VirtueMartViewPluginresponse extends JView {



	public function display($tpl = null) {
		$mainframe = JFactory::getApplication();
		$pathway = $mainframe->getPathway();
		$document = JFactory::getDocument();
                $paymentResponse = JRequest::getVar('paymentResponse', '');

                  $paymentResponseHtml = JRequest::getVar('paymentResponseHtml','','post','STRING',JREQUEST_ALLOWRAW);
		$layoutName = $this->getLayout();

                $this->assignRef('paymentResponse', $paymentResponse);
                $this->assignRef('paymentResponseHtml', $paymentResponseHtml);

		parent::display($tpl);
	}


}

//no closing tag