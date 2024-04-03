<?php
/* SEO url Router */
$router_path = realpath(__DIR__.'/../../core-mall/mallRouter.php');

if ($router_path) {
    if (require_once($router_path)) {
        unset($router_path);
        require_once(__DIR__.'/index.view.php');
    }
} else {
    throw new Exception("Invalid mallRouter path");
}