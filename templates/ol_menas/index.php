<?php

defined('_JEXEC') or die;

define( 'YOURBASEPATH', dirname(__FILE__) );
$app                = JFactory::getApplication();
$templateparams     = $app->getTemplate(true)->params;
$left_width = $this->params->get("leftWidth", "220");
$right_width = $this->params->get("rightWidth", "220");
$temp_width = $this->params->get("templateWidth", "960"); 
$show_date = ($this->params->get("showDate", 1)  == 0)?"false":"true";
$sitetitle = $this->params->get("sitetitle", "olwebdesign.com Joomla Templates"); 
$col_mode = "s-c-s";
if ($left_width==0 and $right_width>0) $col_mode = "x-c-s";
if ($left_width>0 and $right_width==0) $col_mode = "s-c-x";
if ($left_width==0 and $right_width==0) $col_mode = "x-c-x";
$temp_width = 'margin: 0 auto; width: ' . $temp_width . 'px;'; 
$font_Library  = $this->params->get("fontLibrary", "google");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.com/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.com/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<?php
require(YOURBASEPATH . DS . "tools.php");
?>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<script src="<?php echo $this->baseurl ?>/templates/ol_menas/js/ie_suckerfish.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/ol_menas/css/styles.css" type="text/css" media="screen,projection" />
<?php if($font_Library == "google") : ?>
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=<?php echo $this->params->get('fontLibrary-google-Fonts'); ?>" type="text/css" />
<style type="text/css">
<?php echo $this->params->get('fontLibrary-google-Fonts-for'); ?> {font-family:'<?php echo $this->params->get('fontLibrary-google-Fonts'); ?>';}
</style>
<?php endif; ?>

<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/ol_menas/css/styles.ie7.css" type="text/css" media="screen,projection" />
<![endif]-->     
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/scroll.js"></script>
</head>
<body>
<div id="main">
<div id="topheader">
<div id="wrapper"> 
<?php if($show_date == "true") : ?> 
<div class="leftop">
<?php $now = &JFactory::getDate(); echo $now->toFormat("%A %d %b %Y"); ?>
</div>
<?php endif; ?>
<div class="logo">
<a href="index.php" title="<?php echo $sitetitle ?>" ><img src="<?php echo $this->baseurl ?>/templates/ol_menas/images/logo.png" alt="<?php echo $sitetitle ?>" /></a>
</div>
<div id="nav">  
<jdoc:include type="modules" name="position-1" style="none"/>
</div>
<div class="clear"></div>

</div>
</div>
<!-- START FLASH HEADER -->
<?php if($templateparams->get('show-header',1)) : ?>
<?php if (JRequest::getVar('view') == 'featured') : ?>
<div id="header">
<div id="wrapper1"> 
<object type="application/x-shockwave-flash" data="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/header.swf" width="100%" height="300">
<param name="wmode" value="transparent" />
<param name="movie" value="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/header.swf" />
</object>
</div>	
</div>
<?php endif; ?>
<?php else: ?>
<div id="header">
<div id="wrapper1"> 
<object type="application/x-shockwave-flash" data="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/header.swf" width="100%" height="300">
<param name="wmode" value="transparent" />
<param name="movie" value="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/header.swf" />
</object>
</div>	
</div>
<?php endif; ?>
<!-- END FLASH HEADER -->
<div id="bgr">
<div id="wrapper2"> 
<div id="main-content" class="<?php echo $col_mode; ?>">  
<div id="colmask">  
<div id="colmid">    
<div id="colright">   
<div id="col1wrap">      
<div id="col1pad">          
<div id="col1">  
<div id="message">
<jdoc:include type="message" />
</div>
<?php if ($this->countModules('position-2')) : ?>
<div class="breadcrumbs-pad">
<jdoc:include type="modules" name="position-2" />
</div>
<?php endif; ?>  
<div class="component">
<jdoc:include type="component" />
<?php if ($this->countModules('position-3 or position-4 or position-5')) : ?>
<div id="main2" class="spacer2<?php echo $main2_width; ?>"><jdoc:include type="modules" name="position-3" style="xhtml"/><jdoc:include type="modules" name="position-4" style="xhtml"/><jdoc:include type="modules" name="position-5" style="xhtml"/></div>    	
<?php endif; ?>
<?php if ($this->countModules('bannersload')) : ?>
<div class="modulebottom">
<jdoc:include type="modules" name="bannersload" style="xhtml"/>
</div>
<?php endif; ?>
</div>
</div>
</div>
</div><?php if ($left_width != 0) : ?>    
<div id="col2"> 
<jdoc:include type="modules" name="left" style="res"/>
</div>  
<?php endif; ?>
<?php if ($right_width != 0) : ?>
<div id="col3">
<jdoc:include type="modules" name="right" style="res"/>
</div>
<?php endif; ?>
</div>
</div>   
</div>
</div>	
</div>
</div>
<?php if ($this->countModules('user8 or user9 or user10')) : ?>
<div id="main3" class="spacer<?php echo $main3_width; ?>">
<div class="centerbox">
<jdoc:include type="modules" name="user8" style="xhtml"/>
<jdoc:include type="modules" name="user9" style="xhtml"/>
<jdoc:include type="modules" name="user10" style="xhtml"/>
</div>
</div>
<?php endif; ?> 
<div id="footerout">    
<div id="footer"> 
<div class="scroll">
<a href="#" onclick="scrollToTop();return false;"><img src="templates/<?php echo $this->template ?>/images/top.png" width="24" height="24" alt="top" /></a></div>
<jdoc:include type="modules" name="footerload" style="none" />
<div class="copy">
<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
global $_VERSION;
require_once('libraries/joomla/utilities/date.php');
$date  = new JDate();
$config = new JConfig();
?>
Copyright &copy; <?php echo $date->toFormat( '%Y' ) . ' ' . $config->sitename;?>. Designed by <a href="http://www.olwebdesign.com/" title="Visit olwebdesign.com!" target="blank">olwebdesign</a>
</div>
</div>
</div>
<div id="debug">
<jdoc:include type="modules" name="debug" style="none" />
</div>
</div>
</body></html>