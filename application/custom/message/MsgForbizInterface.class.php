<?php
/**
 * Forbiz 메시지 인터페이스
 * @author hoksi
 */
interface MsgForbizInterface
{
    /**
     * 클래스 초기화
     * @param array $config
     */
    public function initialize($config);
    /**
     * 가변 데이터 정리
     */
    public function clear();
    /**
     * 발송자
     * @param string $from
     * @param string $name 이름[옵션]
     */
    public function from($from, $name = false);
    /**
     * 수신자
     * @param string $to
     * @param string $name 이름[옵션]
     */
    public function to($to, $name = false);
    /**
     * 제목
     * @param string $subject
     */
    public function subject($subject);
    /**
     * 메시지
     * @param string $body 메시지
     * @param string $type 메시지 타입
     */
    public function message($body, $type = 'text');
    /**
     * 메시지 발송
     */
    public function send();
    /**
     * 상태값
     */
    public function status();
}