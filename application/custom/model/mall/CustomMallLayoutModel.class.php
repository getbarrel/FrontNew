<?php

/**
 * Description of CustomMallLayoutModel
 *
 * @author hoksi
 */
class CustomMallLayoutModel extends ForbizMallLayoutModel
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getLayoutConfig($url)
    {
        return false;
    }

    public function getLayoutUrlConfig($url)
    {
        $url = '/'.ltrim($url, '/');

        $cacheLayoutConfigFile = CUSTOM_ROOT.'/_cache/_layout/'.FORBIZ_TPL_SKIN.".xml";
        if (defined('USE_SHARED_CACHE') && USE_SHARED_CACHE === true && file_exists($cacheLayoutConfigFile)) {
            $layoutConfigFile = $cacheLayoutConfigFile;
        } else {
            $layoutConfigFile = MALL_DATA_PATH."/_layout/".FORBIZ_TPL_SKIN.".xml";
        }

        if (file_exists($layoutConfigFile)) {
            $doc    = new DOMDocument();
            $doc->load($layoutConfigFile);
            $params = (new DOMXpath($doc))->query("*[@basic_link='".$url."']");

            if ($params->length > 0) {
                $data = new stdClass();
                foreach ($params as $param) {

                    $data->layoutPath      = (!empty($param->getElementsByTagName("layout")->item(0)->nodeValue) ? "/layout/".$param->getElementsByTagName("layout")->item(0)->nodeValue
                            : '');
                    $data->headerTopPath   = (!empty($param->getElementsByTagName("header1")->item(0)->nodeValue) ? "/layout/header/".$param->getElementsByTagName("header1")->item(0)->nodeValue
                            : '' );
                    $data->headerMenuPath  = (!empty($param->getElementsByTagName("header2")->item(0)->nodeValue) ? "/layout/header/".$param->getElementsByTagName("header2")->item(0)->nodeValue
                            : '');
                    $data->contentsPath    = (!empty($param->getElementsByTagName("contents")->item(0)->nodeValue) ? "/".$param->getElementsByTagName("page_path")->item(0)->nodeValue."/".$param->getElementsByTagName("contents")->item(0)->nodeValue
                            : '');
                    $data->contentsAddPath = (!empty($param->getElementsByTagName("contents_add")->item(0)->nodeValue) ? "/layout/contents_add/".$param->getElementsByTagName("contents_add")->item(0)->nodeValue
                            : '');
                    $data->leftMenuPath    = (!empty($param->getElementsByTagName("leftmenu")->item(0)->nodeValue) ? "/layout/leftmenu/".$param->getElementsByTagName("leftmenu")->item(0)->nodeValue
                            : '');
                    $data->rightMenuPath   = (!empty($param->getElementsByTagName("rightmenu")->item(0)->nodeValue) ? "/layout/rightmenu/".$param->getElementsByTagName("rightmenu")->item(0)->nodeValue
                            : '');
                    $data->footerMenuPath  = (!empty($param->getElementsByTagName("footer1")->item(0)->nodeValue) ? "/layout/footer/".$param->getElementsByTagName("footer1")->item(0)->nodeValue
                            : '');
                    $data->footerDescPath  = (!empty($param->getElementsByTagName("footer2")->item(0)->nodeValue) ? "/layout/footer/".$param->getElementsByTagName("footer2")->item(0)->nodeValue
                            : '');
                    $data->caching         = $param->getElementsByTagName("caching")->item(0)->nodeValue;
                    $data->cachingTime     = $param->getElementsByTagName("caching_time")->item(0)->nodeValue;
                }

                return $data;
            } else {
                show_error('layout config null');
            }
        } else {
            show_error(FORBIZ_TPL_SKIN.'.xml not found');
        }
    }
}