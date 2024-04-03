<?php
/**
 * Description of ForbizController
 *
 * @author hoksi
 *
 * @property ForbizUserInfo $userInfo 로그인 회원 정보
 */
class ForbizController extends Forbiz
{
    public $userInfo = false;

    public function __construct()
    {
        parent::__construct();

        $this->userInfo = new ForbizUserInfo($_SESSION['user'] ?? []);
    }
}