<?php
defined('FORBIZ_BASEURL') OR exit('No direct script access allowed');

if (!function_exists('encrypt_user_password')) {

    /**
     * 비밀번호를 암호화 합니다.
     * @param string $pw
     * @return string
     */
    function encrypt_user_password($pw)
    {
        return hash("sha256", $pw);
    }
}

if (!function_exists('form_validation')) {

    /**
     * 필수 데이타 점검
     * @param array $formFieldList
     * @param array $data
     * @return bool
     */
    function form_validation(array $formFieldList, array $data = []): bool
    {
        if (is_array($formFieldList) && !empty($formFieldList)) {
            getForbiz()->load->library('form_validation');

            /* @var $validater CI_Form_validation */
            $validater = getForbiz()->form_validation;

            $validater->reset_validation();

            if (!empty($data)) {
                $validater->set_data($data);
            }

            foreach ($formFieldList as $field) {
                $validater->set_rules($field, ucfirst($field), 'required');
            }

            return $validater->run();
        }

        return true;
    }
}

if (!function_exists('form_file_upload')) {

    /**
     * 파일 업로더
     * @param stirng $fildName
     * @param stirng $uploadPath
     * @param stirng $fileName
     * @param int $maxSize
     * @param string $allowedTypes
     * @return array
     */
    function form_file_upload($fildName, $uploadPath, $fileName = false, $maxSize = 5120, $allowedTypes = '*')
    {
        // 업로드 시간 설정 (2시간)
        set_time_limit(6400);

        // Upload 폴더 확인
        if (is_dir($uploadPath) === false) {
            mkdir($uploadPath, 0777, true);
            chmod($uploadPath, 0777);
        }

        getForbiz()->load->library('upload');
        /* @var $uploader CI_Upload */
        $uploader = getForbiz()->upload;

        $config = [
            'upload_path' => $uploadPath,
            'allowed_types' => $allowedTypes,
            'max_size' => $maxSize,
            'overwrite' => true,
            'encrypt_name' => false
        ];

        if ($fileName) {
            $config['file_name'] = $fileName;
        }

        $uploader->initialize($config);

        return $uploader->do_upload($fildName) ? $uploader->data() : ['error' => $uploader->display_errors()];
    }
}

if (!function_exists('getAppType')) {

    function getAppType()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : false;
    }
}

if (!function_exists('show_400')) {

    function show_400()
    {
        show_error('Bed request!', 400);
    }
}


if (!function_exists('make_member_code')) {

    function make_member_code()
    {
        srand(time());
        return md5(uniqid(rand()));
    }
}

if (!function_exists('make_company_id')) {

    function make_company_id()
    {
        return md5(uniqid(rand()));
    }
}

if (!function_exists('is_windows')) {

    function is_windows()
    {
        return DIRECTORY_SEPARATOR === '\\';
    }
}

if (!function_exists('f_decimal')) {

    /**
     * 비밀번호를 암호화 합니다.
     * @param string $value
     * @return int $scale
     */
    function f_decimal($value, $scale = false)
    {
        if (is_null($value)) {
            $value = '0';
        } else {
            $value = (string) $value;
        }
        if ($scale !== false) {
            return new \Decimal\Decimal($value, $scale);
        } else {
            return new \Decimal\Decimal($value);
        }
    }
}

if (!function_exists('fbcache')) {

    function fbcache()
    {
        static $fbcache = false;

        if ($fbcache === false) {
            $cacheType = (defined('CACHE_TYPE') ? CACHE_TYPE : 'file');

            switch($cacheType) {
                case 'redis':
                    $fbcache = new NunaCacheRedis();
                    break;
                case 'memcached':
                    $fbcache = new NunaCacheMemcached();
                    break;
                default:
                    $fbcache = new NunaCacheFile();
                    break;
            }
        }

        return $fbcache;
    }
}

if (!function_exists('fb_set')) {

    function fb_set($key, $value, $ttl = 60)
    {
        return fbcache()->save($key, $value, $ttl);
    }
}

if (!function_exists('fb_get')) {

    function fb_get($key)
    {
        return fbcache()->get($key);
    }
}

if (!function_exists('fb_del')) {

    function fb_del($key)
    {
        return fbcache()->delete($key);
    }
}

if(!function_exists('sharedToCashe')) {
    function sharedToCashe() {
        getForbiz()->load->helper('file');

        $shared = get_filenames(MALL_DATA_PATH."/_shared/");
        foreach($shared as $name) {
            $data = ForbizConfig::getSharedMemory($name);
            fb_set($name, $data, null);
        }

        return $shared;
    }
}

if(!function_exists('sharedList')) {
    function sharedList() {
        getForbiz()->load->helper('file');

        $shared = get_filenames(MALL_DATA_PATH."/_shared/");
        $list = [];
        foreach($shared as $name) {
            $list[$name] = fb_get($name);
        }

        return $list;
    }

}