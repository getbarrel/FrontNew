<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

$param = $view->getParams(0);

$src = '//about.getbarrel.com/'.$param;

$view->assign('param', $param);
$view->assign('src', $src);

echo $view->loadLayout();