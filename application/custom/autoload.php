<?php
// Class Autoloader
spl_autoload_register(function($class) {
    
    if($class == 'CremaHandler') {        
        require_once (CUSTOM_ROOT . '/third-party/Crema/autoload.php');
        
    }else if($class == 'FbEncrypt'){
        require_once  (CUSTOM_ROOT . '/third-party/encrypt/FbEncrypt.class.php');
    }
});