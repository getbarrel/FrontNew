<?php

/**
 * Description of ForbizMallController
 *
 * @author hoksi
 */
class ForbizMallController extends ForbizController
{
    private $responseResult  = "success";
    private $responseData    = false;
    private $responseType    = 'json';
    protected $useLoginCheck = false;
    protected $noCheckMethod = [];

    public function __construct()
    {
        parent::__construct();

        // 사용자 이벤트 정의 파일 로드
        if (file_exists(CUSTOM_CONFIG_PATH.'/event.php')) {
            $eventFunc = require CUSTOM_CONFIG_PATH.'/event.php';

            if (is_callable($eventFunc)) {
                $eventFunc('controller');
            }
        }
    }

    /**
     * Request re-mapper
     * @param string $method
     * @param array $params
     */
    public function _remap($method, $params)
    {
        if ($this->useLoginCheck === true) {
            $this->chkLogin($method);
        }

        if (method_exists($this, $method)) {
            $result = call_user_func_array([$this, $method], $params);

            switch ($this->responseType) {
                case 'html':
                    $this->output->set_content_type('text/html');
                    break;
                case 'js':
                    $this->output->set_content_type('application/javascript');
                    break;
                case 'pdf':
                case 'txt':
                case 'xls':
                case 'xlsx':
                case 'csv':
                case 'xml':
                default:
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($this->getResponse()));
                    break;
            }

            if ($this->uri->uri_string != '') {
                $this->event->trigger($this->uri->uri_string, $result);
            }
            
            $this->event->trigger('controller');
        } else {
            show_404();
        }
    }

    /**
     * controller 에서 응답 결과를 set
     * @param $result
     */
    public function setResponseType($responseType)
    {
        $this->responseType = $responseType;

        return $this;
    }

    /**
     * controller 에서 응답 결과를 set
     * @param $result
     */
    public function setResponseResult($result)
    {
        $this->responseResult = $result;

        return $this;
    }

    /**
     * controller 에서 응답 결과 data 를 set
     * @param $data
     */
    public function setResponseData($data)
    {
        $this->responseData = $data;

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

    protected function chkLogin($method = null)
    {
        if ($method !== null) {
            if (in_array($method, $this->noCheckMethod) === false && is_login() === false) {
                show_error(trans('로그인하여 주십시오.'));
            }
        } else {
            if (is_login() === false) {
                show_error(trans('로그인하여 주십시오.'));
            }
        }
    }
}