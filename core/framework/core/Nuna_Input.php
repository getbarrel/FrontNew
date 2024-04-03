<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nuna_Input extends CI_Input
{
    protected $xssRemove = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function get($index = NULL, $xss_clean = TRUE)
    {
        if($this->xssRemove === false) {
            $this->xssRemove = true;
            
            // xss 삭제 필터링
            foreach($_GET as $key => $val) {
                $_GET[$key] = $this->remove_xss($val);
            }
        }

        return $this->_fetch_from_array($_GET, $index, $xss_clean);
    }
    
    public function filter($v)
    {
        return str_replace(["'", '"'], '', strip_tags(urldecode($v)));
    }

    public function remove_xss($val)
    {
        if(is_array($val)) {
            foreach($val as $k => $v) {
                $val[$k] = $this->filter($v);
            }
        } else {
            $val = $this->filter($val);
        }

        return $val;
    }
}