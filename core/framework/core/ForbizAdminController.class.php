<?php

/**
 * Description of ForbizController
 *
 * @author hoksi
 *
 * @property ForbizAdminInfo $adminInfo 관리자 로그인 정보
 */
class ForbizAdminController extends Forbiz
{
    private $responseResult    = "success";
    private $responseData      = [];
    private $responseType      = 'html';
    private $accessType        = false;
    protected $moduleGroup;
    protected $moduleName;
    protected $adminLoginCheck = true;
    protected $layout          = 'layout';
    protected $is_mobile       = false;
    protected $layoutCss       = [];
    protected $layoutJs        = [];
    protected $scmlang         = 'korean';
    protected $layoutData      = [];
    protected $debugTxt        = false;
    public $adminInfo          = false;

    public function __construct($adminLoginCheck = true)
    {
        parent::__construct();

        // Admin 로그인 여부 확인
        $this->adminLoginCheck = $adminLoginCheck;

        // 로그인 정보
        $this->adminInfo = new ForbizAdminInfo(sess_val('admininfo'));

        // 모듈 정보
        $tMod              = explode('\\', get_class($this));
        $this->moduleGroup = $tMod[2];
        $this->moduleName  = $tMod[3];

        // 로그인 점검여부 확인
        if ($this->adminLoginCheck !== false && !$this->adminInfo->admin_level) {
            // 로그인 되어 있지 않을때
            if ($this->input->method() == 'get') {
                redirect('/');
            } else {
                exit(json_encode($this->setResponseData([])->getResponse()));
            }
        } else {
            // 템플릿 공용 Assign 데이타
            if (file_exists(APPLICATION_ROOT."/config/assign.php")) {
                $this->layoutData = require_once(APPLICATION_ROOT."/config/assign.php");
            }

            // 이벤트 로드
            if (file_exists(APPLICATION_ROOT."/config/event.php")) {
                $eventFunc = require_once(APPLICATION_ROOT."/config/event.php");
                if (is_callable($eventFunc)) {
                    $eventFunc($this->router->method, ($this->router->params[0] ?? ''));
                }
            }
        }
    }

    public function _remap($method, $params)
    {

        $prefix = substr($method, 0, 3);

        if (in_array($prefix, ['add', 'get', 'put', 'del', 'dwn']) === false && $method !== 'index') {
            array_unshift($params, $method);
            $method = 'index';
        }

        // AccessType 설정
        $this->setAccessType($method);

        // 권한 확인
        if ($this->chkAccessType()) {
            if (method_exists($this, $method)) {
                call_user_func_array(array($this, $method), $params);

                if ($method == 'index') {
                    $this->displayView(lcfirst($this->moduleName), $this->responseData);
                } else {
                    $this->displayView('json');
                }
            } elseif ($this->class_name != 'Fobiz') {
                show_error("The page you requested was not found. ({$this->moduleGroup}/{$this->moduleName}/{$method})", 404);
            }
        } else {
            show_error("Do not have access. ({$this->moduleGroup}/{$this->moduleName})", 400);
        }
    }
    /* -- 내부 메소드 -- */

    /**
     * controller 에서 응답 결과를 set
     * @param $result
     */
    public function setResponseType($responseType)
    {
        $this->responseType = strtolower($responseType);

        return $this;
    }

    /**
     * controller 에서 응답 결과를 set
     * @param $result
     */
    public function setResponseResult($result)
    {
        $this->responseType   = 'json';
        $this->responseResult = $result;

        return $this;
    }

    /**
     * controller 에서 응답 결과 data 를 set
     * @param $data
     */
    public function setResponseData($key, $data = null)
    {
        if (is_array($key)) {
            $this->responseData = array_merge($this->responseData, $key);
        } elseif (is_object($key)) {
            $this->responseData = array_merge($this->responseData, get_object_vars($key));
        } elseif ($key && $data) {
            $this->responseData[$key] = $data;
        } else {
            $this->responseData[] = $key;
        }

        return $this;
    }

    /**
     * 응답시 Json
     */
    public function getResponse()
    {
        return [
            'result' => $this->responseResult,
            'data' => $this->responseData
        ];
    }

    /**
     * debug
     */
    public function debug()
    {
        $this->debugTxt = "<script>!function(){var debugData = ".
            json_encode($this->responseData)
            .";console.table ? console.table(debugData) : console.log(debugData);alert('Debug Mode 입니다.\\n배포전 반드시 OFF해 주세요.');}()</script>";
    }

    ///////////// Protected Method /////////////////////////////
    protected function setTopBtn($text, $class, $id = '')
    {
        $this->layoutData['headerMenu']['btnData'][] = [
            'text' => $text
            , 'class' => $class
            , 'id' => ($id == '' ? 'devTopMenu'.ucfirst($class).'Btn' : $id)
        ];

        return $this;
    }

    protected function getModulTplPath()
    {
        // 모듈 템플릿 폴더 설정
        return realpath(MODULE_ROOT.'/'.lcfirst($this->moduleGroup).'/'.($this->is_mobile ? 'assets_mobile' : 'assets').'/views');
    }

    protected function getModuleCplPath()
    {
        $moduleCplPath = str_replace('//', '/', SCM_TPL_COMPILE.'/module/'.($this->is_mobile ? 'mobile' : 'web').'/'.lcfirst($this->moduleGroup).'/');

        if (!is_dir($moduleCplPath)) {
            $tag = mkdir($moduleCplPath, 0777, true);
            if ($tag === false) {
                show_error('Check please '.$this->tpl->compile_dir.' Permission!');
            }
        }

        return $moduleCplPath;
    }

    protected function define($defineId, $viewName = '')
    {
        // 템플릿 프리필터 설정
        $this->tpl->prefilter  = "prefilter_trans&{$this->scmlang}";
        // 템플릿 포스트필터 설정
        $this->tpl->postfilter = 'removeTmpCode|mustache';

        // 모듈 템플릿 폴더 설정
        $moduleTplPath = $this->getModulTplPath();
        // 모듈 템플릿 컴파일 폴더 설정
        $moduleCplPath = $this->getModuleCplPath();

        $orgTplPath = $this->tpl->template_dir;
        $orgCplPath = $this->tpl->compile_dir;

        $this->tpl->template_dir = $moduleTplPath;
        $this->tpl->compile_dir  = $moduleCplPath;

        $viewName = ($viewName ? ($viewName.'.htm') : '');

        if (is_array($defineId)) {
            // 확장자 확인
            foreach ($defineId as $idx => $data) {
                if (substr($data, -4) != '.htm') {
                    $defineId[$idx] = $data.'.htm';
                }
            }
        }

        $this->tpl->define($defineId, $viewName);

        $this->tpl->template_dir = $orgTplPath;
        $this->tpl->compile_dir  = $orgCplPath;
    }

    protected function displayView($viewName = '', $data = [])
    {
        if ($this->responseType == 'void') {
            if ($this->responseData) {
                if (is_array($this->responseData)) {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($this->responseData, JSON_PARTIAL_OUTPUT_ON_ERROR));
                } else {
                    $this->output
                        ->set_output($this->responseData);
                }
            }
        } elseif (strtolower($viewName) == 'json' || $this->responseType == 'json') {

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($this->getResponse(), JSON_PARTIAL_OUTPUT_ON_ERROR));
        } else {
            // 템플릿 프리필터 설정
            $this->tpl->prefilter  = "prefilter_trans&{$this->scmlang}";
            // 템플릿 포스트필터 설정
            $this->tpl->postfilter = 'removeTmpCode|mustache';

            // 모듈 템플릿 폴더 설정
            $moduleTplPath = $this->getModulTplPath();
            // 모듈 템플릿 컴파일 폴더 설정
            $moduleCplPath = $this->getModuleCplPath();

            // 템플릿 경로 백업
            $orgTplPath = $this->tpl->template_dir;
            $orgCplPath = $this->tpl->compile_dir;

            $this->tpl->template_dir = $moduleTplPath;
            $this->tpl->compile_dir  = $moduleCplPath;

            $defaultName = ($this->uri->segments[2] ?? '');

            if ($defaultName) {
                $this->setCss("{$defaultName}.css")->setJs("{$defaultName}.js");
                $data['layoutCss'] = $this->layoutCss;
                $data['layoutJs']  = $this->layoutJs;
            }

            $viewName = $viewName.'.htm';

            // CSRF
            $data['ForbizCsrf'] = [
                'name' => $this->security->get_csrf_token_name()
                , 'hash' => $this->security->get_csrf_hash()
            ];

            // 컨텐츠
            $data['FbContent'] = $this->load->tpl($viewName, $data, true);

            $this->tpl->template_dir = $orgTplPath;
            $this->tpl->compile_dir  = $orgCplPath;

            $this->displayLayout($data);
        }

        // 이벤트 트리거
        $this->triggerEvent();
    }

    protected function displayLayout($data = [])
    {
        $orgTplPath = $this->tpl->template_dir;
        $orgCplPath = $this->tpl->compile_dir;

        $this->tpl->template_dir = LAYOUT_ROOT.'/'.($this->is_mobile ? 'moblie' : 'web').'/';
        $this->tpl->compile_dir  = str_replace('//', '/', SCM_TPL_COMPILE.'/layout/'.($this->is_mobile ? 'mobile' : 'web').'/');

        if (!is_dir($this->tpl->compile_dir)) {
            $tag = mkdir($this->tpl->compile_dir, 0777, true);
            if ($tag === false) {
                show_error('Check please '.$this->tpl->compile_dir.' Permission!');
            }
        }

        $leftMenuPath = $this->tpl->template_dir.'leftmenu/'.strtolower($this->moduleName).'.htm';
        if (file_exists($leftMenuPath)) {
            $leftMenu = 'leftmenu/'.strtolower($this->moduleName).'.htm';
        } else {
            $leftMenu = 'leftmenu/void.htm';
        }

        $this->tpl->define([
            'headerTop' => 'header/top.htm'
            , 'headerMenu' => 'header/menu.htm'
            , 'leftMenu' => $leftMenu
            , 'contentsAddNav' => 'contents_add/nav.htm'
            , 'contentsAddMenu' => 'contents_add/menu.htm'
            , 'rightMenu' => 'rightmenu/void.htm'
            , 'footerMenu' => 'footer/menu.htm'
            , 'footerDesc' => 'footer/desc.htm'
        ]);

        $layoutName = $this->layout.'.htm';

        if (!empty($this->layoutData)) {
            $data = array_merge($this->layoutData, $data);
        }

        // 컨텐츠
        $this->load->tpl($layoutName, $data);

        $this->tpl->template_dir = $orgTplPath;
        $this->tpl->compile_dir  = $orgCplPath;

        if ($this->debugTxt) {
            $this->output->append_output($this->debugTxt);
        }
    }

    protected function setAccessType($method)
    {
        $pre_method = strtolower(substr($method, 0, 3));

        if ($method == 'index' || $pre_method == 'get') {
            $this->accessType = 'read';
        } elseif ($pre_method == 'add' || $pre_method == 'put') {
            $this->accessType = 'write';
        } elseif ($pre_method == 'del') {
            $this->accessType = 'delete';
        } elseif ($pre_method == 'dwn') {
            $this->accessType = 'down';
        }

        return $this;
    }

    protected function chkAccessType()
    {
        static $acl = false;

        if ($acl === false) {
            // ACL 조회
            $acl = ForbizConfig::getAcl($this->moduleGroup, $this->moduleName, $this->adminInfo->charger_ix, $this->adminInfo->group_code);
        }

        return isset($acl[$this->accessType]) && $acl[$this->accessType] == 'Y' ? true : false;
    }

    protected function setCss($css)
    {
        if (is_array($css)) {
            foreach ($css as $css_item) {
                $this->setCss($css_item);
            }
        } else {
            if (strncmp($css, 'http', 4) != 0 && $css[0] != '/') {
                $css = assets_url(lcfirst($this->moduleGroup)."/assets/css/{$css}");
            }

            if ($css) {
                $this->layoutCss[md5($css)] = $css;
            }
        }

        return $this;
    }

    protected function setJs($js)
    {
        if (is_array($js)) {
            foreach ($js as $js_item) {
                $this->setJs($js_item);
            }
        } else {
            if (strncmp($js, 'http', 4) != 0 && $js[0] != '/') {
                $js = assets_url(lcfirst($this->moduleGroup)."/assets/js/{$js}");
            }

            if ($js) {
                $this->layoutJs[md5($js)] = $js;
            }
        }

        return $this;
    }

    protected function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    protected function setTitle($title)
    {
        $this->layoutData['layoutCommon']['title'] = $title;

        return $this;
    }

    protected function triggerEvent()
    {
        if ($this->uri->uri_string) {
            // 디버그용 이벤트 로그
            // log_message('debug', '** Trigger Event ['.$this->uri->uri_string.'] : '.json_encode($this->getResponse()));
            // 이벤트 트리거
            $this->event->trigger($this->uri->uri_string, ['response' => $this->getResponse()]);
            // 모듈별 이벤트 트리거
            $this->event->setTarget(lcfirst($this->moduleName))->trigger('default', ['response' => $this->getResponse()]);
        }
    }
}