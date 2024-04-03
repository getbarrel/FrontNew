<?php

/**
 * Description of ForbizMsg
 *
 * @author hoksi
 */
class MsgForbiz implements MsgForbizInterface
{
    protected $protocol     = false;
    protected $msgModule    = [];
    protected $protocolType = ['email', 'sms', 'alimtalk'];

    public function __construct($protocol = 'email', $charset = 'UTF-8')
    {
        $this->protocol($protocol, $charset);
    }

    public function protocol($protocol, $charset = 'UTF-8')
    {
        if (in_array($protocol, $this->protocolType) === true) {
            $this->protocol = $protocol;

            if (!isset($this->msgModule[$protocol])) {
                $class                      = 'MsgForbiz'.ucfirst($protocol);
                $this->msgModule[$protocol] = new $class;
            }

            return $this;
        } else {
            return false;
        }
    }

    public function initialize($config)
    {
        if ($this->protocol !== false) {
            $this->msgModule[$this->protocol]->initialize($config);
            return $this;
        } else {
            throw new Exception('No protocol');
        }
    }

    public function from($from, $name = false)
    {
        if ($this->protocol !== false) {
            $this->msgModule[$this->protocol]->from($from, $name);
            return $this;
        } else {
            throw new Exception('No protocol');
        }
    }

    public function to($to, $name = false)
    {
        if ($this->protocol !== false) {

            $this->msgModule[$this->protocol]->to($to, $name);
            return $this;
        } else {
            throw new Exception('No protocol');
        }
    }

    public function subject($subject)
    {
        if ($this->protocol !== false) {
            $this->msgModule[$this->protocol]->subject($subject);
            return $this;
        } else {
            throw new Exception('No protocol');
        }
    }

    public function message($body, $type = 'text')
    {
        if ($this->protocol !== false) {
            $this->msgModule[$this->protocol]->message($body, $type);
            return $this;
        } else {
            throw new Exception('No protocol');
        }
    }

    public function template($template_name, $data, $type = 'html')
    {
        if ($this->protocol == 'email') {
            $tpl = new Template_();

            $tpl->template_dir = FORBIZ_TPL_MSGDIR;
            $tpl->compile_dir  = FORBIZ_TPL_CPLDIR;

            $tpl->define($template_name, 'ms_'.$this->protocol.'_'.$template_name.'.htm');
            $tpl->assign($data);

            $this->msgModule[$this->protocol]->message($tpl->fetch($template_name), $type);

            return $this;
        } elseif ($this->protocol == 'sms') {
            $tpl = ForbizConfig::getSmsTpl($template_name);

            $message = ForbizConfig::getParser()->parse_string($tpl['mc_sms_text'], $data, true);

            $this->msgModule[$this->protocol]->message($message, $type);

            return $this;

        } elseif ($this->protocol == 'alimtalk') {

            $tpl = ForbizConfig::getSmsTpl($template_name);

            $message = ForbizConfig::getParser()->parse_string($tpl['mc_sms_text'], $data, true);


            // log_message('error', 'alimtalk tpl : '.json_encode($tpl));
            // log_message('error', 'alimtalk message : '.json_encode($message));


            $this->msgModule[$this->protocol]->kakaoCode($tpl['kakao_code'],$tpl['kakao_btn_code'])->message($message, $type);

            return $this;
        } else {
            throw new Exception('No protocol');
        }
    }

    public function send()
    {
        if ($this->protocol !== false) {
            return $this->msgModule[$this->protocol]->send();
        } else {
            throw new Exception('No protocol');
        }
    }

    public function status()
    {
        if ($this->protocol !== false) {
            return $this->msgModule[$this->protocol]->status();
        } else {
            throw new Exception('No protocol');
        }
    }

    public function clear()
    {
        if ($this->protocol !== false) {
            return $this->msgModule[$this->protocol]->clear();
        } else {
            throw new Exception('No protocol');
        }
    }
}