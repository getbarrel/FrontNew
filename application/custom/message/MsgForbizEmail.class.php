<?php

/**
 * Description of ForbizMsgEmail
 *
 * @author hoksi
 */
class MsgForbizEmail implements MsgForbizInterface
{
    protected $email;

    public function __construct()
    {
        $app         = &get_instance();
        $app->load->library('email');
        $this->email = $app->email;

        if (defined('DB_CONNECTION_DIV') && DB_CONNECTION_DIV == 'development') {
            $this->initialize([
                'protocol' => 'smtp'
                , 'smtp_host' => '106.10.56.19'
                , 'smtp_user' => 'root'
                , 'charset' => 'UTF-8'
            ]);
        } elseif (defined('DB_CONNECTION_DIV') && DB_CONNECTION_DIV == 'testing') {
            $this->initialize([
                'protocol' => 'smtp'
                , 'smtp_host' => '127.0.0.1'
                , 'smtp_user' => 'root'
                , 'charset' => 'UTF-8'
            ]);
        } else {
            $this->initialize([
                'protocol' => 'smtp'
                , 'smtp_host' => '127.0.0.1'
                , 'smtp_user' => 'root'
                , 'charset' => 'UTF-8'
            ]);
        }
    }

    public function initialize($config)
    {
        $this->email->initialize($config);
        return $this;
    }

    public function clear()
    {
        $this->email->clear();
        return $this;
    }

    public function from($from, $name = false)
    {
        $this->email->from($from, $name);
        return $this;
    }

    public function to($to, $name = false)
    {
        $this->email->to($to, $name);
        return $this;
    }

    public function subject($subject)
    {
        $this->email->subject($subject);
        return $this;
    }

    public function message($body, $type = 'text')
    {
        $this->email->set_mailtype($type);
        $this->email->message($body);
        return $this;
    }

    public function send()
    {
        return $this->email->send();
    }

    public function status()
    {
        return [
            'debug' => $this->email->print_debugger()
        ];
    }
}