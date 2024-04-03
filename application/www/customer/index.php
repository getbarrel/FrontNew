<?php
// Load Framework
require_once($_SERVER["DOCUMENT_ROOT"].'/../../core-mall/forbiz.config.php');

// view url set
getForbizView(false)->setUri('customer/index');

// require secureComplete.view.php
require_once(__DIR__ . '/index.view.php');