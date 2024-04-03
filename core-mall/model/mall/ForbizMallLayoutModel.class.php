<?php

/**
 * Description of ForbizMallLayoutModel
 *
 * @author hoksi
 * @property LayOut $layout
 */
class ForbizMallLayoutModel extends ForbizModel
{
    protected $layout;

    public function __construct()
    {
        parent::__construct();

        $this->layout = new LayOut();
    }

    public function getAssign($key = false)
    {
        $data                             = ForbizConfig::getAssign($key);
        // CSRF 토큰 전달
        $data['layout']['ForbizCsrfName'] = $this->security->get_csrf_token_name();
        $data['layout']['ForbizCsrfHash'] = $this->security->get_csrf_hash();

        return $data;
    }

    protected function getLayoutConfig($url)
    {
        $layoutConfigFilePath = (MALL_DATA_PATH."/_layout/".FORBIZ_TPL_SKIN.(substr($url, -1) == '/' ? $url.'index' : $url).'.layout.php');

        if (is_file($layoutConfigFilePath)) {
            return require_once($layoutConfigFilePath);
        }

        return false;
    }

    public function getLayoutUrlConfig($url)
    {
        $url = '/'.ltrim($url, '/');

        // config 조회
        $config = $this->getLayoutConfig($url);

        if ($config) {
            $data = new stdClass();

            $page_path = ltrim(($config['parent_path'] ?? '') .'/'. ($config['path'] ?? ''), '/');

            $data->layoutPath      = ($config['layout'] ? '/layout/' .  $config['layout']: '');
            $data->headerTopPath   = ($config['header1'] ? '/layout/header/' . $config['header1'] : '');
            $data->headerMenuPath  = ($config['header2'] ? '/layout/header/' . $config['header2'] : '');
            $data->contentsPath    = ($config['contents'] ? '/'.$page_path.'/'.$config['contents'] : '');
            $data->contentsAddPath = ($config['contents_add'] ? '/layout/contents_add/'.$config['contents_add'] : '');
            $data->leftMenuPath    = ($config['leftmenu'] ? '/layout/leftmenu/'.$config['leftmenu'] : '');
            $data->rightMenuPath   = ($config['rightmenu'] ? '/layout/rightmenu/'.$config['rightmenu'] : '');
            $data->footerMenuPath  = ($config['footer1'] ? '/layout/footer/'.$config['footer1'] : '');
            $data->footerDescPath  = ($config['footer2'] ? '/layout/footer/'.$config['footer2'] : '');
            $data->caching         = $config['caching'] ?? '';
            $data->cachingTime     = $config['caching_time'] ?? '';

            return $data;
        } else {
            $cacheLayoutConfigFile = CUSTOM_ROOT.'/_cache/_layout/'.FORBIZ_TPL_SKIN.".xml";
            if(defined('USE_SHARED_CACHE') && USE_SHARED_CACHE === true && file_exists($cacheLayoutConfigFile)) {
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

    public function getLayout($layoutConfigData)
    {
        // 전역 변수 설정
        $this->layout->setCommonAssign($this->getAssign());
        // layout file path
        $this->layout->setLayoutPath($layoutConfigData->layoutPath);

        // layout Top & TopMenu Partial
        $this->layout->setHeaderTopPath($layoutConfigData->headerTopPath);
        $this->layout->setHeaderMenuPath($layoutConfigData->headerMenuPath);
        // layout LeftMenu Partial
        $this->layout->setLeftMenuPath($layoutConfigData->leftMenuPath);
        // layout Content Partial
        $this->layout->setContentsPath($layoutConfigData->contentsPath);
        // Layout Content Add Partial
        $this->layout->setContentsAddPath($layoutConfigData->contentsAddPath);
        // Layout RightMenu Partial
        $this->layout->setRightMenuPath($layoutConfigData->rightMenuPath);
        // Layout Footer & FooterMenu Partial
        $this->layout->setFooterMenuPath($layoutConfigData->footerMenuPath);
        $this->layout->setFooterDescPath($layoutConfigData->footerDescPath);

        return $this->layout;
    }
}