<?php

/**
 * Description of ForbizMallCollectModel
 *
 * @author hong
 */
class ForbizMallCollectModel extends ForbizModel
{
    protected $sess_id;
    protected $ldate;
    protected $hour;
    protected $week;
    protected $host;
    protected $inflow_url;
    protected $user_id;
    protected $sex;
    protected $age;
    protected $pid;
    protected $refhash;
    protected $hash;

    public function __construct()
    {
        parent::__construct();

        $referer = $this->getReferer();

        $this->sess_id    = session_id();
        $this->ldate      = date('Y-m-d');
        $this->hour       = date('H');
        $this->week       = date('N');
        $this->host       = parse_url($referer, PHP_URL_HOST) ?? '';
        $this->inflow_url = parse_url($referer, PHP_URL_PATH);
        $this->refhash    = md5($this->inflow_url);
        $this->wtype      = is_mobile() ? 'M' : 'W';
        $this->hash       = false;

        //로그인 여부에 따라 기본 set
        if (is_login()) {
            $this->user_id = $this->userInfo->id;
            $this->sex     = $this->userInfo->sex;
            $this->age     = $this->userInfo->age;
        } else {
            $this->user_id = DEFAULT_GUEST_ID;
            $this->sex     = 'N';
            $this->age     = -1;
        }

        $this->initCfg();
    }

    protected function initCfg()
    {
        // DB 설정
        $statDb    = 'enter_statistics.';
        $productDb = 'enterprisedev_db.';

        // 테이블 설정
        define('STAT_TBL_LOG', $statDb.'system_prdt_vwlog');
    }

    /**
     * 통계 DB
     * @return NunaQb
     */
    public function sQb()
    {
        return $this->qb->setDatabase('stat');
    }

    public function getReferer()
    {
        $referer = $this->input->server('HTTP_REFERER');

        $this->setSessReferer($referer);

        return $referer;
    }

    public function setSessReferer($referer)
    {
        $_SESSION[DEFAULT_SESS_REF_NAME] = $referer;

        return $this;
    }

    public function setLastHash()
    {
        $_SESSION[DEFAULT_VIEW_HASH] = $this->hash;

        return $this;
    }

    public function setPid($pid)
    {
        $this->pid = $pid;

        // 해시 설정
        $this->setHash($pid);

        return $this;
    }

    public function getHash()
    {
        $row = $this->sQb()
            ->select('hash_idx')
            ->from(STAT_TBL_LOG)
            ->where('pid', $this->pid)
            ->where('sess_id', $this->sess_id)
            ->exec()
            ->getRowArray();

        return ($row['hash_idx'] ?? '');
    }

    public function setHash($pid)
    {
        $this->hash = md5($this->ldate.$this->hour.$this->host.$this->inflow_url.$this->pid.$this->wtype.$this->sess_id.$this->user_id);

        return $this;
    }

    public function existsHash()
    {
        return $this->sQb()
                ->from(STAT_TBL_LOG)
                ->where('hash_idx', $this->hash)
                ->getCount() > 0;
    }

    public function addViewData()
    {
        if ($this->hash !== false && $this->existsHash() === false) {
            // 최근 해시값 기록
            $this->setLastHash();
            // view 데이타 기록
            $this->sQb()
                ->set('ldate', $this->ldate)
                ->set('hour', $this->hour)
                ->set('week', $this->week)
                ->set('wtype', $this->wtype)
                ->set('host', $this->host)
                ->set('inflow_url', $this->inflow_url)
                ->set('pid', $this->pid)
                ->set('sess_id', $this->sess_id)
                ->set('user_id', $this->user_id)
                ->set('sex', $this->sex)
                ->set('age', $this->age)
                ->set('refhash', $this->refhash)
                ->set('hash_idx', $this->hash)
                ->set('regdate', date('Y-m-d H:i:s'))
                ->insert(STAT_TBL_LOG)
                ->exec();
        }
    }
}