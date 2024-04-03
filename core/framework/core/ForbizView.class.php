<?php
/**
 * Description of ForbizView
 *
 * @author hoksi
 *
 * @property ForbizUserInfo $userInfo 로그인 회원 정보
 */
class ForbizView extends Forbiz
{
    public $userInfo;

    public function __construct()
    {
        parent::__construct();

        $this->userInfo = new ForbizUserInfo(sess_val('user') ?? []);
    }

    public function assign($key, $val = '')
    {
        if (is_array($key)) {
            $this->tpl->assign($key);
        } else {
            $this->tpl->assign($key, $val);
        }

        return $this;
    }

    public function define($arg, $path = '')
    {
        $this->tpl->define($arg, $path);

        return $this;
    }

    public function debug()
    {
        $tplData = !empty($this->tpl->var_) ? $this->tpl->var_ : [null];

        foreach ($tplData as $key => $val) {
            $key = $key ? $key : 'Global';
            echo "<script>!function(){var debugData = ".json_encode([$key => $val]).";console.table ? console.table(debugData) : console.log(debugData);alert('Debug Mode 입니다.\\n배포전 반드시 OFF해 주세요.');}()</script>";
        }
    }
}