<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Tpl extends Template_
{
    protected $orgTemplateDir = false;

    public function __construct()
    {
        $cfg = load_class('Config', 'core');
        $cfg->load('tpl', true);

        foreach ($cfg->item('tpl') as $key => $val) {
            if (isset($this->{$key})) {
                $this->{$key} = $val;
            }
        }

        // Template Source DIR
        if (defined('FORBIZ_TPL_TPLDIR')) {
            $this->template_dir = FORBIZ_TPL_TPLDIR;
        }
        // Template Skin
        if (defined('FORBIZ_TPL_SKIN')) {
            $this->skin = FORBIZ_TPL_SKIN;
        }
        // Template Compile DIR
        if (defined('FORBIZ_TPL_CPLDIR')) {
            $this->compile_dir = FORBIZ_TPL_CPLDIR;
            if (!is_dir(FORBIZ_TPL_CPLDIR)) {
                mkdir(FORBIZ_TPL_CPLDIR, $this->permission);
                chmod(FORBIZ_TPL_CPLDIR, $this->permission);
            }
        }
        // Template Cache DIR
        if (defined('FORBIZ_TPL_CACHEDIR')) {
            $this->cache_dir = FORBIZ_TPL_CACHEDIR;
            if (!is_dir(FORBIZ_TPL_CACHEDIR)) {
                mkdir(FORBIZ_TPL_CACHEDIR, $this->permission);
                chmod(FORBIZ_TPL_CACHEDIR, $this->permission);
            }
        }
    }

    public function fatch($fid)
    {
        $fatchData = parant::fatch($fid);

        $this->unsetCustomTemplateDir();

        return $fatchData;
    }

    public function print_($fid, $scope = '', $sub = false)
    {
        parent::print_($fid, $scope, $sub);

        $this->unsetCustomTemplateDir();
    }

    public function setCustomTemplateDir($customTemplateDir)
    {
        $this->orgTemplateDir = $this->template_dir;
        $this->template_dir   = $customTemplateDir;

        return $this;
    }

    protected function unsetCustomTemplateDir()
    {
        if ($this->orgTemplateDir !== false) {
            $this->template_dir      = $this->orgTemplateDir;
            $this->customTemplateDir = false;
        }

        return $this;
    }
}