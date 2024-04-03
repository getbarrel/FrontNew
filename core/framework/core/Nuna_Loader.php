<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nuna_Loader extends CI_Loader
{
    protected $Nuna;
    protected $NunaDB;

    public function __construct()
    {
        parent::__construct();

        $this->Nuna   = & get_instance();
        $this->NunaDB = [];
    }

    public function tpl($tpl, $vars = array(), $return = FALSE)
    {
        $tplParse = explode('.', $tpl);
        $tplId    = $tplParse[0];

        // make template id
        $tplId = str_replace('/', '_', $tplId);

        $this->Nuna->tpl->setScope($tplId);
        $this->Nuna->tpl->define($tplId, $tpl);

        if (!empty($vars)) {
            $this->Nuna->tpl->assign($vars);
        }

        $ret = $this->Nuna->tpl->fetch($tplId);
        $this->Nuna->tpl->setScope();

        if ($return) {
            return $ret;
        } else {
            $this->Nuna->output->append_output($ret);
        }
    }

    public function import($resource, $params = false, $opt = false)
    {
        $res_parse = explode('.', $resource);
        if (!empty($res_parse) && ($res_parse[0] == 'db' || count($res_parse) >= 2)) {
            $res_type = array_shift($res_parse);

            return $this->getResource($res_type, $res_parse, $params, $opt);
        } else {
            show_error('Resource is Empty!');
        }
    }

    public function closeAllDB()
    {
        if (!empty($this->NunaDB)) {
            foreach ($this->NunaDB as $key => $db) {
                if ($db) {
                    $db->close();
                }
            }
        }
    }


    protected function getResource($type, $res_params, $params, $opt)
    {
        switch ($type) {
            case 'model':
                return $this->getModel($res_params);
                break;
            case 'tpl':
                return $this->getTpl($res_params, $params, $opt);
                break;
            case 'controller':
                return $this->getController($res_params, $params);
                break;
            case 'db':
                return $this->getDb($res_params);
                break;
            case 'view':
                return $this->getView($res_params, $params, $opt);
                break;
            case 'lib':
                return $this->getLib($res_params);
            default:
                return false;
                break;
        }
    }

    protected function getDb($dbConfig)
    {
        // DB 환경
        static $config = false;

        // DB 관리
        $db = &$this->NunaDB;

        $dbConfig = implode('', $dbConfig);

        if ($config === false) {
            if (defined('FORBIZ_SCM_VERSION')) {
                $dbConfigFile = realpath(MODULE_CONFIG_PATH.'/database.php');
            } else {
                $dbConfigFile = realpath(CUSTOM_ROOT.'/config/database.php');
            }

            if ($dbConfigFile && file_exists($dbConfigFile)) {
                //$config = require($dbConfigFile);
            } else {
                exit("DB Config file not found! [{$dbConfigFile}]");
            }
        }

        if (isset($db[$dbConfig])) {
            $dbObj = $db[$dbConfig];
        } else {
            switch ($dbConfig) {
                case 'slave':
                    $db['slave']  = $this->database([
                        /*'hostname' => $config[DB_CONNECTION_DIV]['slave']['host'],
                        'username' => $config[DB_CONNECTION_DIV]['slave']['user'],
                        'password' => $config[DB_CONNECTION_DIV]['slave']['pass'],
                        'database' => $config[DB_CONNECTION_DIV]['slave']['name'],
                        'port' => $config[DB_CONNECTION_DIV]['slave']['port'],
                        'dbdriver' => FORBIZ_MALL_DB_DRIVER,
                        'hostname' => '10.33.183.53',*/

                        //'hostname' => '10.33.180.104',
                        'hostname' => '10.33.182.234', //version up
                        'username' => 'barrel_prod',
                        'password' => 'barrel!#@$prod',
                        'database' => 'barrel_mall',
                        'port' => '3306',
                        'dbdriver' => 'mysqli',
                        'dbprefix' => '',
                        'pconnect' => FALSE,
                        'db_debug' => (DB_CONNECTION_DIV !== 'production'),
                        'cache_on' => FALSE,
                        'cachedir' => '',

                        /*'char_set' => $config[DB_CONNECTION_DIV]['slave']['char_set'] ?? 'utf8',
                        'dbcollat' => $config[DB_CONNECTION_DIV]['slave']['dbcollat'] ?? 'utf8_general_ci',*/

                        'char_set' => 'utf8mb4' ?? 'utf8',
                        'dbcollat' => 'utf8_general_ci' ?? 'utf8_general_ci',
                        'swap_pre' => '',
                        'encrypt' => FALSE,
                        'compress' => FALSE,
                        'stricton' => FALSE,
                        'failover' => array(),
                        'save_queries' => FALSE
                    ], true);
                    $dbObj        = $db['slave'];
                    break;
                case 'db':
                case 'master':
                    $db['master'] = $this->database([

                        /*'hostname' => $config[DB_CONNECTION_DIV]['master']['host'],
                        'username' => $config[DB_CONNECTION_DIV]['master']['user'],
                        'password' => $config[DB_CONNECTION_DIV]['master']['pass'],
                        'database' => $config[DB_CONNECTION_DIV]['master']['name'],
                        'port' => $config[DB_CONNECTION_DIV]['master']['port'],
                        'dbdriver' => FORBIZ_MALL_DB_DRIVER,
                        'hostname' => '10.33.183.53',*/

                        //'hostname' => '10.33.180.104',
                        'hostname' => '10.33.182.234', //version up
                        'username' => 'barrel_prod',
                        'password' => 'barrel!#@$prod',
                        'database' => 'barrel_mall',
                        'port' => '3306',
                        'dbdriver' => 'mysqli',
                        'dbprefix' => '',
                        'pconnect' => FALSE,
                        'db_debug' => (DB_CONNECTION_DIV !== 'production'),
                        'cache_on' => FALSE,
                        'cachedir' => '',

                        'char_set' => $config[DB_CONNECTION_DIV]['master']['char_set'] ?? 'utf8',
                        'dbcollat' => $config[DB_CONNECTION_DIV]['master']['dbcollat'] ?? 'utf8_general_ci',

                        /*'char_set' => 'utf8mb4' ?? 'utf8',
                        'dbcollat' => 'utf8_general_ci' ?? 'utf8_general_ci',*/
                        'swap_pre' => '',
                        'encrypt' => FALSE,
                        'compress' => FALSE,
                        'stricton' => FALSE,
                        'failover' => array(),
                        'save_queries' => FALSE
                    ], true);

                    $dbObj = $db['master'];
                    break;
                default:
                    //if (isset($config[DB_CONNECTION_DIV][$dbConfig])) {
                    $db[$dbConfig] = $this->database([

                        'hostname' => $config[DB_CONNECTION_DIV][$dbConfig]['host'],
                        'username' => $config[DB_CONNECTION_DIV][$dbConfig]['user'],
                        'password' => $config[DB_CONNECTION_DIV][$dbConfig]['pass'],
                        'database' => $config[DB_CONNECTION_DIV][$dbConfig]['name'],
                        'port' => $config[DB_CONNECTION_DIV][$dbConfig]['port'],
                        'dbdriver' => FORBIZ_MALL_DB_DRIVER,

                        //'hostname' => '10.33.180.104',
                        /*'hostname' => '10.33.182.234', //version up
                        'username' => 'barrel_prod',
                        'password' => 'barrel!#@$prod',
                        'database' => 'barrel_mall',
                        'port' => '3306',
                        'dbdriver' => 'mysqli',*/

                        'dbprefix' => '',
                        'pconnect' => FALSE,
                        'db_debug' => (DB_CONNECTION_DIV !== 'production'),
                        'cache_on' => FALSE,
                        'cachedir' => '',

                        'char_set' => $config[DB_CONNECTION_DIV][$dbConfig]['char_set'] ?? 'utf8',
                        'dbcollat' => $config[DB_CONNECTION_DIV][$dbConfig]['dbcollat'] ?? 'utf8_general_ci',

                        /*
                                                    'char_set' => 'utf8mb4' ?? 'utf8',
                                                    'dbcollat' => 'utf8_general_ci' ?? 'utf8_general_ci',
                        */
                        'swap_pre' => '',
                        'encrypt' => FALSE,
                        'compress' => FALSE,
                        'stricton' => FALSE,
                        'failover' => array(),
                        'save_queries' => FALSE
                    ], true);

                    $dbObj = $db[$dbConfig];
                    //} else {
                    //    show_error("Databse {$dbConfig} not exists!");
                    //}
                    break;
            }
            /*switch ($dbConfig) {
                case 'slave':
                    $db['slave']  = $this->database([
                        'hostname' => $config[DB_CONNECTION_DIV]['slave']['host'],
                        'username' => $config[DB_CONNECTION_DIV]['slave']['user'],
                        'password' => $config[DB_CONNECTION_DIV]['slave']['pass'],
                        'database' => $config[DB_CONNECTION_DIV]['slave']['name'],
                        'port' => $config[DB_CONNECTION_DIV]['slave']['port'],
                        'dbdriver' => FORBIZ_MALL_DB_DRIVER,
                        'dbprefix' => '',
                        'pconnect' => FALSE,
                        'db_debug' => (DB_CONNECTION_DIV !== 'production'),
                        'cache_on' => FALSE,
                        'cachedir' => '',
                        'char_set' => $config[DB_CONNECTION_DIV]['slave']['char_set'] ?? 'utf8',
                        'dbcollat' => $config[DB_CONNECTION_DIV]['slave']['dbcollat'] ?? 'utf8_general_ci',
                        'swap_pre' => '',
                        'encrypt' => FALSE,
                        'compress' => FALSE,
                        'stricton' => FALSE,
                        'failover' => array(),
                        'save_queries' => FALSE
                    ], true);
                    $dbObj        = $db['slave'];
                    break;
                case 'db':
                case 'master':
                    $db['master'] = $this->database([
                        'hostname' => $config[DB_CONNECTION_DIV]['master']['host'],
                        'username' => $config[DB_CONNECTION_DIV]['master']['user'],
                        'password' => $config[DB_CONNECTION_DIV]['master']['pass'],
                        'database' => $config[DB_CONNECTION_DIV]['master']['name'],
                        'port' => $config[DB_CONNECTION_DIV]['master']['port'],
                        'dbdriver' => FORBIZ_MALL_DB_DRIVER,
                        'dbprefix' => '',
                        'pconnect' => FALSE,
                        'db_debug' => (DB_CONNECTION_DIV !== 'production'),
                        'cache_on' => FALSE,
                        'cachedir' => '',
                        'char_set' => $config[DB_CONNECTION_DIV]['master']['char_set'] ?? 'utf8',
                        'dbcollat' => $config[DB_CONNECTION_DIV]['master']['dbcollat'] ?? 'utf8_general_ci',
                        'swap_pre' => '',
                        'encrypt' => FALSE,
                        'compress' => FALSE,
                        'stricton' => FALSE,
                        'failover' => array(),
                        'save_queries' => FALSE
                    ], true);

                    $dbObj = $db['master'];
                    break;
                default:
                    //if (isset($config[DB_CONNECTION_DIV][$dbConfig])) {
                    $db[$dbConfig] = $this->database([
                        'hostname' => $config[DB_CONNECTION_DIV][$dbConfig]['host'],
                        'username' => $config[DB_CONNECTION_DIV][$dbConfig]['user'],
                        'password' => $config[DB_CONNECTION_DIV][$dbConfig]['pass'],
                        'database' => $config[DB_CONNECTION_DIV][$dbConfig]['name'],
                        'port' => $config[DB_CONNECTION_DIV][$dbConfig]['port'],
                        'dbdriver' => FORBIZ_MALL_DB_DRIVER,
                        'dbprefix' => '',
                        'pconnect' => FALSE,
                        'db_debug' => (DB_CONNECTION_DIV !== 'production'),
                        'cache_on' => FALSE,
                        'cachedir' => '',
                        'char_set' => $config[DB_CONNECTION_DIV][$dbConfig]['char_set'] ?? 'utf8',
                        'dbcollat' => $config[DB_CONNECTION_DIV][$dbConfig]['dbcollat'] ?? 'utf8_general_ci',
                        'swap_pre' => '',
                        'encrypt' => FALSE,
                        'compress' => FALSE,
                        'stricton' => FALSE,
                        'failover' => array(),
                        'save_queries' => FALSE
                    ], true);

                    $dbObj = $db[$dbConfig];
                    break;
            }*/
        }

        return $dbObj;
    }

    protected function getTpl($res_params, $params, $return)
    {
        $ext               = array_pop($res_params);
        $tplFileName       = implode('/', $res_params).'.'.$ext;
        $customTplFileName = 'template/'.$tplFileName;

        if (file_exists($customTplFileName)) {
            $this->Nuna->tpl->setCustomTemplateDir(realpath('template'));
        }

        return $this->tpl($tplFileName, $params, $return);
    }

    protected function getModel($model)
    {
        if (defined('FORBIZ_SCM_VERSION')) {
            if (isset($model[2])) {
                $model[1] = $model[1].'\\'.ucfirst($model[2]);
            }
        }

        return $this->getObj($model, 'model');
    }

    protected function getController($controller, $params)
    {
        return $this->getObj($controller, 'controller', $params);
    }

    protected function getView($view)
    {
        return $this->getObj($view, 'view');
    }

    protected function getObj($class, $postfix, $params = null)
    {
        if (defined('FORBIZ_SCM_VERSION')) {
            // 관리자 클래스 로드
            $customClass = '\\CustomScm\\'.ucfirst($postfix).'\\'.ucfirst($class[1]);
            $coreClass   = '\\ForbizScm\\'.ucfirst($postfix).'\\'.ucfirst($class[1]);

            if (class_exists($customClass)) {
                return new $customClass($params);
            } elseif (class_exists($coreClass)) {
                return new $coreClass($params);
            }

            return false;
        } else {
            $className = implode('', array_map(function($v) {
                        return ucfirst($v);
                    }, $class)).ucfirst($postfix);

            $customClass = 'Custom'.$className;
            $coreClass   = 'Forbiz'.$className;

            if (class_exists($customClass)) {
                return new $customClass($params);
            } elseif (class_exists($coreClass)) {
                return new $coreClass($params);
            }

            return false;
        }
    }

    protected function getLib($class, $params = null)
    {
        $className = implode('', array_map(function($v) {
                return ucfirst($v);
            }, $class));

        $customClass = 'Custom'.$className;
        $coreClass   = 'Forbiz'.$className;

        if (class_exists($customClass)) {
            return new $customClass($params);
        } elseif (class_exists($coreClass)) {
            return new $coreClass($params);
        }

        return false;
    }
}