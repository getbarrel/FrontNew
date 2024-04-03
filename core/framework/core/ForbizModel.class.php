<?php

/**
 * Description of ForbizModel
 *
 * @author hoksi
 *
 * @property CI_Qb $qb
 * @property CI_Input $input
 * @property CI_Security $security
 * @property CI_Loader $load
 * @property CI_Event $event
 * @property CI_URI $uri
 * @property ForbizAdminInfo $adminInfo
 * @property ForbizUserInfo $userInfo
 */
class ForbizModel
{
//    public $master_db;
//    public $slave_db;
//    public $db;
    public $qb;
    public $input;
    public $security;
    public $load;
    public $event;
    public $adminInfo = false;
    public $userInfo  = false;

    // 결과 생성용
    protected $result;
    protected $data = [];

    public function __construct()
    {
        $this->load      = &load_class('Loader', 'core');
        $this->event     = &load_class('Event', 'core');
        $this->qb        = &load_class('Qb', 'core');
        $this->input     = &load_class('Input', 'core');
        $this->security  = &load_class('Security', 'core');
        $this->uri       = &load_class('URI', 'core');
//        $this->master_db = getForbiz()->import('db.master');
//        $this->slave_db  = getForbiz()->import('db.slave');
//        $this->db        = getForbiz()->import('db.db');

        if (defined('FORBIZ_SCM_VERSION')) {
            $this->adminInfo = new ForbizAdminInfo($_SESSION['admininfo'] ?? []);
        } else {
            $this->userInfo = new ForbizUserInfo($_SESSION['user'] ?? []);
        }
    }

    public function import($resource, $params = null, $return = false)
    {
        return getForbiz()->import($resource, $params, $return);
    }

    /**
     * 결과 생성
     * @return array
     */
    public function getResult()
    {
        $result = [
            'result' => $this->result
            , 'data' => $this->data
        ];

        $this->result = '';
        $this->data = [];

        return $result;
    }
}