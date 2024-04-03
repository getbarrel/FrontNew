<?php

/**
 * Description of ForbizMallBbsController
 *
 * @author hoksi
 */
class ForbizMallBbsController extends ForbizMallController
{
    protected $msb = null;

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $this->lists();
    }

    public function lists()
    {


    }

    protected function getMsBoard($bbs_table_name)
    {
        if ($this->msb === null) {
            $this->msb = new MsBoard2($bbs_table_name);
            $this->msb->MsBoardConfigration();
            $this->msb->bbs_admin_mode = $admin_mode;
            $this->msb->bbs_template_dir = $bbs_template_dir;
            $this->msb->bbs_compile_dir = $bbs_compile_dir;
            $this->msb->bbs_data_dir = $bbs_data_dir;
            $this->msb->bbs_file_dir = $bbs_file_dir;
            $this->msb->site_template_src = $site_template_src;
            $this->msb->edit_data_dir = $edit_data_dir;
            $this->msb->site_product_src = $site_product_src; //추가 kbk 13/07/05
        }

        return $this->msb;
    }

    public function modList()
    {

    }

    public function modRead()
    {

    }

}
