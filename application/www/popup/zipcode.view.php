<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();

if (ForbizConfig::getMallConfig('zipcode_type') == 'D') {
    $view->define("content", 'popup/zipcode/zipcode_daum.htm');
}

// content output
echo $view->loadLayout();