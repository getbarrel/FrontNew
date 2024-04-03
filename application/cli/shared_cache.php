<?php
// 도메인 변경이 필요할 때 설정함
// define('FORBIZ_BASEURL', 'localhost');

/*
 * Fobiz Framework Load
 */
require_once(__DIR__.'/../../core/framework/ForbizCli.php');

/**
 * @property CustomMallCartModel $cartModel
 */
(new class extends ForbizCli {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo "Usage : ";
        echo __FILE__." caching\n";
    }

    public function caching()
    {
        $this->load->helper('file');

        $sharedPath      = MALL_DATA_PATH.'/_shared/';
        $cacheSharedPath = CUSTOM_ROOT.'/_cache/_shared/';

        $sharedFiles = get_filenames($sharedPath);

        foreach ($sharedFiles as $sfName) {
            $cFile   = $cacheSharedPath.$sfName;
            $sFile   = $sharedPath.$sfName;
            $copyAct = false;

            if (file_exists($cFile)) {
                $sfTime = filemtime($sFile);
                $cfTime = filemtime($cFile);
                if ($cfTime < $sfTime) {
                    $copyAct = true;
                    var_dump($sfTime, $cfTime);
                }
            } else {
                $copyAct = true;
            }

            if ($copyAct === true) {
                copy($sFile, $cFile);
                var_dump($sFile, $cFile);
            }
        }
    }
})->run();
