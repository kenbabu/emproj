<?php

defined('_JEXEC') or die;

$left_width = ($this->countModules('left')>0) ? $left_width : 0;

$right_width = ($this->countModules('right')>0) ? $right_width : 0;

$temp_width = ''. $temp_width .'';

$inlinestyle = "

#wrapper, #wrapper1, #wrapper2, #footer { ".$temp_width."padding:0;}

.s-c-s #colmid { left:".$left_width."px;}

.s-c-s #colright { margin-left:-".($left_width + $right_width)."px;}

.s-c-s #col1pad { margin-left:".($left_width + $right_width)."px;}

.s-c-s #col2 { left:".$right_width."px;width:".$left_width."px;}

.s-c-s #col3 { width:".$right_width."px;}

.s-c-x #colright { left:".$left_width."px;}

.s-c-x #col1wrap { right:".$left_width."px;}

.s-c-x #col1 { margin-left:".$left_width."px;}

.s-c-x #col2 { right:".$left_width."px;width:".$left_width."px;}

.x-c-s #colright { margin-left:-".$right_width."px;}

.x-c-s #col1 { margin-left:".$right_width."px;}

.x-c-s #col3 { left:".$right_width."px;width:".$right_width."px;}";
$this->addStyleDeclaration($inlinestyle);

$main2_count = ($this->countModules('position-3')>0) + ($this->countModules('position-4')>0) + ($this->countModules('position-5')>0);

$main2_width = $main2_count > 0 ? ' x' . floor(99 / $main2_count) : '';

$main3_count = ($this->countModules('user8')>0) + ($this->countModules('user9')>0) + ($this->countModules('user10')>0);

$main3_width = $main3_count > 0 ? ' x' . floor(99 / $main3_count) : '';

?>