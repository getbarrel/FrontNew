<?php

/**
 * Description of ForbizMsgSms
 * @property CI_Qb $qb
 * @author hoksi
 */
class MsgForbizSms implements MsgForbizInterface
{
    protected $charset;
    protected $sms_send_url;
    protected $sms_count_url;
    protected $license;
    protected $send_host;
    protected $qb;
    protected $params = [];


    public function __construct()
    {
        $this->qb = getForbiz()->qb;
    }

    public function initialize($config)
    {

        return $this;
    }

    public function kakaoCode($kakaoCode,$kakaoBtnCode)
    {

        // log_message('error', 'kakaoCode ===: '.$this->template_id[$kakaoCode]);
        $this->params['k_template_code'] = $kakaoCode;
        $this->params['kakao_btn_code'] = $kakaoBtnCode;
        return $this;
    }

    public function clear()
    {
        $this->params = [];
        return $this;
    }

    public function from($from, $name = false)
    {
        $this->params['send_phone'] = $from;
        if ($name !== false) {
            $this->params['send_name'] = iconv("utf-8", "CP949", $name);
        } else {
            $this->params['send_name'] = '';
        }
        return $this;
    }

    public function to($to, $name = false)
    {
        $this->params['dest_phone'] = str_replace('-', '', $to);
        if ($name !== false) {
            $this->params['dest_name'] = iconv("utf-8", "CP949", $name);
        } else {
            $this->params['dest_name'] = '';
        }
        return $this;
    }

    public function subject($subject)
    {
        return $this;
    }

    public function message($body, $type = 0)
    {
        $this->params['msg_body'] = iconv("utf-8", "CP949", $body);
        $this->params['send_type'] = $type;
        return $this;
    }

    public function getSmsAbleCount()
    {
        $curl = new Curl\Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $ret = ($curl->post($this->sms_count_url, ['license' => $this->license])->isSuccess() ? intval($curl->response) : -1);
        $curl->close();

        return $ret;
    }

    public function send($clean = true)
    {
//        $params                  = $this->params;
//        $params['license']       = $this->license;
//        $params['send_host']     = $this->send_host;
//        $params['send_date']     = 0;
//        $params['send_time']     = 0;
//        $params['sms_send_type'] = 'A';
//
//        $curl = new Curl\Curl();
//        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
//        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
//        $ret  = ($curl->post($this->sms_send_url, $params)->isSuccess() ? $curl->response : $curl->error_message);
//        $curl->close();
//
//


        $send_data['send_host'] = $_SERVER['HTTP_HOST'];
        $send_data['dest_phone'] = str_replace('-','',$this->params['dest_phone']);
        $send_data['dest_name'] = $this->params['dest_name'];
        $send_data['send_name'] = ($this->params['send_name'] ?? '');
        $send_data['send_phone'] = str_replace('-','',($this->params['send_phone'] ?? ''));
        $send_data['msg_body'] = $this->params['msg_body'];
        $send_data['send_type'] = $this->params['send_type'];
        $send_data['send_date'] = 0;
        $send_data['send_time'] = 0;
        $send_data['msg_code'] = '';
        $send_data['dest_code'] = '';
        $send_data['send_title'] = '';//
        $send_data['sms_send_type'] = "A";
        $send_data['templete_code'] = "";
        if(!empty($this->params['k_template_code'])){
            $send_data['k_template_code'] = $this->params['k_template_code'];
        }else{
            $send_data['k_template_code'] = "";
        }
        if(!empty($this->params['kakao_btn_code'])){
            $send_data['kakao_btn_code'] = $this->params['kakao_btn_code'];
        }else{
            $send_data['kakao_btn_code'] = "";
        }



        $ret = $this->sendInsert($send_data);


        return $ret;
    }

    public function sendInsert($send_data)
    {
        if (trim($send_data['msg_body']) != "") {

            $msg_body = str_replace("\r", "", $send_data['msg_body']);
            $text_encoding = mb_detect_encoding($msg_body, "EUC-KR, UTF-8, ASCII,CP949");

            if ($text_encoding) {
                $message_len = mb_strwidth($msg_body, $text_encoding);
            } else {
                $message_len = strlen($msg_body);
            }

            $dest_phone_len = strlen($send_data['dest_phone']);


            $msg_body_utf8 = iconv("CP949", "utf-8", $send_data['msg_body']);
            $dest_name_utf8 = iconv("CP949", "utf-8", $send_data['dest_name']);
            $send_name_utf8 = iconv("CP949", "utf-8", $send_data['send_name']);

            $sms_send_type_utf8 = iconv("CP949", "utf-8", $send_data['sms_send_type']);


            //LMS일떄
            if (empty($send_data['send_type'])) {
                if ($message_len > 80) {
                    //syslog(LOG_INFO,'SMS->LMS change / Greater than 80 bytes');
                    $send_type = 3;
                    $k_next_type = 5;
                } else {
                    $send_type = 1;
                    $k_next_type = 4;
                }
            } else {
                $send_type = 6;
                $k_next_type = 5;
            }

            if ($send_data['send_time'] == 0 || $send_data['send_time'] == '') {
                $send_time = date('Y-m-d H:i:s');
            } else {
                $send_time = $send_data['send_time'];
            }

            if ($send_type == 6) {
                //syslog(LOG_INFO,'send to LMS');
                //즉시발송 일때 현재날짜로 발송

                $this->qb->setDatabase('sms')
                    ->set('msg_type', 6)
                    ->set('dstaddr', $send_data['dest_phone'])
                    ->set('callback', $send_data['send_phone'])
                    ->set('stat', 0)
                    ->set('subject', $send_data['send_title'])
                    ->set('sender_key','bcb6ec71a59a43acfca91dec164103cfc7bc6ba2')
                    ->set('k_template_code', $send_data['k_template_code'])
                    ->set('k_next_type', $k_next_type)
                    ->set('k_attach', $send_data['kakao_btn_code'])
                    ->set('text', $msg_body_utf8)
                    ->set('request_time', $send_time)
                    ->set('opt_post', $send_name_utf8)
                    ->set('opt_name', $dest_name_utf8)
                    //->set('ext_col0', $sms_send_type_utf8)
                    ->set('ext_col1', $send_data['send_host'])
                    ->set('ext_col3', $send_data['msg_code'])
                    ->set('ext_col4', $send_data['dest_code'])
                    ->insert('msg_queue')
                    ->exec();

            } else if ($send_type == 3) {

                $this->qb->setDatabase('sms')
                    ->set('msg_type', 3)
                    ->set('dstaddr', $send_data['dest_phone'])
                    ->set('callback', $send_data['send_phone'])
                    ->set('stat', 0)
                    ->set('subject', $send_data['send_title'])
                    ->set('text', $msg_body_utf8)
                    ->set('request_time', $send_time)
                    ->set('opt_post', $send_name_utf8)
                    ->set('opt_name', $dest_name_utf8)
                    //->set('ext_col0', $sms_send_type_utf8)
                    ->set('ext_col1', $send_data['send_host'])
                    ->set('ext_col3', $send_data['msg_code'])
                    ->set('ext_col4', $send_data['dest_code'])
                    ->insert('msg_queue')
                    ->exec();

            } else {

                $this->qb->setDatabase('sms')
                    ->set('msg_type', 1)
                    ->set('dstaddr', $send_data['dest_phone'])
                    ->set('callback', $send_data['send_phone'])
                    ->set('stat', 0)
                    ->set('subject', $send_data['send_title'])
                    ->set('text', $msg_body_utf8)
                    ->set('request_time', $send_time)
                    ->set('opt_post', $send_name_utf8)
                    ->set('opt_name', $dest_name_utf8)
                    //->set('ext_col0', $sms_send_type_utf8)
                    ->set('ext_col1', $send_data['send_host'])
                    ->set('ext_col3', $send_data['msg_code'])
                    ->set('ext_col4', $send_data['dest_code'])
                    ->insert('msg_queue')
                    ->exec();

            }
        }
    }

    public function status()
    {
        return [
            'ableCount' => $this->getSmsAbleCount()
        ];
    }
}