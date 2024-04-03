<?php
// 도메인 변경이 필요할 때 설정함
// define('FORBIZ_BASEURL', 'localhost');

/*
 * Fobiz Framework Load
 */
require_once(__DIR__ . '/../../core/framework/ForbizCli.php');

/**
 * @property CustomMallCartModel $cartModel
 */
(new class extends ForbizCli
{
    protected $languageList = [];
    protected $templateTypeList = [];

    public function __construct()
    {
        echo "<Template_ Compile>\n";

        parent::__construct();

        //컴파일 하기위한 세팅
        $this->languageList = ['korean', 'english'];
        $this->templateTypeList = [
            ['templateType' => 'templet', 'skinList' => ['enterprise']]
            , ['templateType' => 'mobile_templet', 'skinList' => ['mobile_enterprise']]
        ];

        $this->load->helper('directory');
    }

    public function index()
    {
        echo "-------사용법-------\n";
        echo "info: 세팅되어 있는 templateTypeList(skinList 포함), languageList 확인\n";
        echo "compile: 세팅되어 있는 정보로 compile 진행\n";
    }

    public function info()
    {
        echo "-------templateTypeList-------\n";
        print_r($this->templateTypeList);
        echo "-------languageList-------\n";
        print_r($this->languageList);
    }

    public function cron()
    {
        $ip = gethostname();

        $rows = $this->qb
            ->setDatabase('master')
            ->select('config_name')
            ->select('config_value')
            ->from(TBL_SHOP_MALL_CONFIG)
            ->where('mall_ix', 'template_compile_cron')
            ->like('config_name', $ip . '_', 'after')
            ->exec()
            ->getResultArray();

        $action = false;
        if (count($rows) == 0) {
            //최초 디비 없을때는 모두 comfile 실행 및 디비 insert
            foreach ($this->languageList as $language) {
                $this->qb
                    ->set('mall_ix', 'template_compile_cron')
                    ->set('config_name', $ip . '_' . $language)
                    ->set('config_value', 'complete')
                    ->insert(TBL_SHOP_MALL_CONFIG)
                    ->exec();
            }
        } else {
            $this->languageList = [];
            foreach ($rows as $row) {
                $state = $row['config_value'];
                list($_ip, $_language) = explode('_', $row['config_name']);
                if ($state == 'ready' && !empty($_language)) {
                    $action = true;
                    $this->languageList[] = $_language;
                }
            }
        }

        if ($action == true && !empty($this->languageList)) {
            //ready -> ing, 상단에서 languageList 컨트롤함
            foreach ($this->languageList as $language) {
                $this->qb
                    ->set('config_value', 'ing')
                    ->update(TBL_SHOP_MALL_CONFIG)
                    ->where('mall_ix', 'template_compile_cron')
                    ->where('config_name', $ip . '_' . $language)
                    ->exec();
            }

            $this->compile();

            //ing -> complete
            foreach ($this->languageList as $language) {
                $this->qb
                    ->set('config_value', 'complete')
                    ->update(TBL_SHOP_MALL_CONFIG)
                    ->where('mall_ix', 'template_compile_cron')
                    ->where('config_name', $ip . '_' . $language)
                    ->exec();
            }
        }
    }

    public function compile()
    {
        echo "-------Compile Start-------\n";
        //강제로 컴파일 하기 위해 dev로 세팅
        $this->tpl->compile_check = 'dev';
        foreach ($this->templateTypeList as $list) {
            $this->tpl->template_dir = $this->getTemplateDir($this->tpl->template_dir, $list['templateType']);
            foreach ($list['skinList'] as $skin) {
                $this->tpl->skin = $skin;
                $htmList = $this->getHtmList($this->tpl->template_dir . DIRECTORY_SEPARATOR . $this->tpl->skin);
                foreach ($this->languageList as $language) {
                    echo "---------------------------------------------------------------\n";
                    echo "templateType: " . $list['templateType'] . ", skin: " . $skin . ", language: " . $language . "\n";
                    echo "---------------------------------------------------------------\n";
                    $this->tpl->prefilter = $this->getPrefilter($this->tpl->prefilter, $language);
                    $this->tpl->compile_dir = $this->getCompileDir($this->tpl->compile_dir, $language);
                    foreach ($htmList as $htmPath) {
                        $rel_path = DIRECTORY_SEPARATOR . $htmPath;
                        echo $rel_path . "\n";
                        $this->tpl->_get_compile_path($rel_path);
                    }
                }
            }
        }
        echo "-------Compile End-------\n";
    }

    protected function getPrefilter($prefilter, $language)
    {
        $tmp = explode('&', $prefilter);
        $lastKey = count($tmp) - 1;
        $tmp[$lastKey] = $language;

        return implode('&', $tmp);
    }

    protected function getCompileDir($path, $language)
    {
        $dir = explode('/', $path);
        $lastKey = count($dir) - 1;
        $dir[$lastKey] = $language;

        return implode('/', $dir);
    }

    protected function getTemplateDir($path, $templateType)
    {
        $dir = explode('/', $path);
        $lastKey = count($dir) - 1;
        $dir[$lastKey] = $templateType;

        return implode('/', $dir);
    }

    protected function getHtmList($path)
    {
        $list = directory_map($path);
        return $this->getDirHtmFile('', $list);
    }

    protected function getDirHtmFile($path, $list)
    {
        $returnLsit = [];
        if (is_array($list)) {
            foreach ($list as $dirPath => $data) {
                if (is_array($data)) {
                    $returnLsit = array_merge($returnLsit, $this->getDirHtmFile($path . $dirPath, $data));
                } else {
                    if (preg_match('/\.(htm)$/i', $data)) {
                        $returnLsit[] = $path . $data;
                    }
                }
            }
        }

        return $returnLsit;
    }
})->run();