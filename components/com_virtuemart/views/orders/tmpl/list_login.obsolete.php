<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	echo 'Developer notice, shouldnt be called list_login.php';
// if(!class_exists('shopFunctionsF')) require(JPATH_VM_SITE.DS.'helpers'.DS.'shopfunctionsf.php');

//  echo shopFunctionsF::getLoginForm(false,true);

/*
$comUserOption=shopfunctionsF::getComUserOption();
?>

<?php if(JPluginHelper::isEnabled('authentication', 'openid')) :
		$lang = &JFactory::getLanguage();
		$lang->load( 'plg_authentication_openid', JPATH_ADMINISTRATOR );
		$langScript = 	'var JLanguage = {};'.
						' JLanguage.WHAT_IS_OPENID = \''.JText::_( 'WHAT_IS_OPENID' ).'\';'.
						' JLanguage.LOGIN_WITH_OPENID = \''.JText::_( 'LOGIN_WITH_OPENID' ).'\';'.
						' JLanguage.NORMAL_LOGIN = \''.JText::_( 'NORMAL_LOGIN' ).'\';'.
						' var comlogin = 1;';
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration( $langScript );
		JHTML::_('script', 'openid.js');
endif;

			$uri = JFactory::getURI();
			$url = $uri->toString(array('path', 'query', 'fragment'));


 ?>
 <div class="order-view">
 <fieldset class="input">
	<LEGEND><?php echo JText::_('COM_VIRTUEMART_ORDER_ANONYMOUS') ?></LEGEND>

<form action="<?php echo JRoute::_( 'index.php', true, 0); ?>" method="post" name="com-login" >

	<div class="width30 floatleft" id="com-form-order">
		<label for="order_number"><?php echo JText::_('COM_VIRTUEMART_ORDER_NUMBER') ?></label><br />
		<input type="text" id="order_number " name="order_number" class="inputbox" size="18" alt="order_number " />
	</div>
	<div class="width30 floatleft" id="com-form-order">
		<label for="order_pass"><?php echo JText::_('COM_VIRTUEMART_ORDER_PASS') ?></label><br />
		<input type="text" id="order_pass" name="order_pass" class="inputbox" size="18" alt="order_pass" value="P_"/>
	</div>
	<div class="width30 floatleft" id="com-form-order">
		<input type="submit" name="Submitbuton" class="button" value="<?php echo JText::_('COM_VIRTUEMART_ORDER_BUTTON_VIEW') ?>" />
	</div>
	<div class="clr"></div>
	<input type="hidden" name="option" value="com_virtuemart" />
	<input type="hidden" name="view" value="orders" />
	<input type="hidden" name="task" value="details" />
	<input type="hidden" name="return" value="" />

</form>
</fieldset>
</div>

 <div class="order-view">
<form action="<?php echo JRoute::_( 'index.php', true, 0 ); ?>" method="post" name="com-login" >

<fieldset class="input">
	<LEGEND><?php echo JText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM') ?></LEGEND>

	<p class="width30 floatleft" id="com-form-login-username">
		<label for="username"><?php echo JText::_('COM_VIRTUEMART_USERNAME') ?></label><br />
		<input name="username" id="username" type="text" class="inputbox" alt="username" size="18" />
	</p>
	<p class="width30 floatleft" id="com-form-login-password">
		<label for="passwd"><?php echo JText::_('COM_VIRTUEMART_PASSWORD') ?></label><br />
		<?php if ( VmConfig::isJ15() ) { ?>
			<input type="password" id="passwd" name="passwd" class="inputbox" size="18" alt="password" />
		<?php } else { ?>
			<input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18"  />
		<?php } ?>
	</p>
	<p class="width30 floatleft" id="com-form-login-remember">
		<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
		<?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
		<br/ >
			<label for="remember"><?php echo $remember_me = VmConfig::isJ15()? JText::_('Remember me') : JText::_('JGLOBAL_REMEMBER_ME') ?></label>
		<input type="checkbox" id="remember" name="remember" class="inputbox" value="yes" alt="Remember Me" />
	</p>
	<?php endif; ?>
	<div class="clr"></div>
	<div class="width30 floatleft">
		<a class="details" href="<?php echo JRoute::_( 'index.php?option='.$comUserOption.'&view=reset' ); ?>">
		<?php echo JText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD'); ?></a>
	</div>
	<div class="width30 floatleft">
		<a class="details" href="<?php echo JRoute::_( 'index.php?option='.$comUserOption.'&view=remind' ); ?>">
		<?php echo JText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_USERNAME'); ?></a>
	</div>
	<?php
	$usersConfig = &JComponentHelper::getParams( $comUserOption );
	if ($usersConfig->get('allowUserRegistration')) { ?>
	<div class="width30 floatleft">
		<a  class="details" href="<?php echo JRoute::_( 'index.php?option=com_virtuemart&view=user',$this->useXHTML,$this->useSSL ); ?>">
			<?php echo JText::_('COM_VIRTUEMART_ORDER_REGISTER'); ?></a>
	</div>
	<?php } ?>
	<div class="clr"></div>
</fieldset>

<?php if ( VmConfig::isJ15() ) { ?>
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />
<?php } else { ?>
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
<?php } ?>
	<input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
*/
