<?php

/**
 * Description of Nuna_Router
 *
 * @author hoksi
 * @property CI_URI $uri Description
 */
class Nuna_Router
{
    public $class;
    public $method;
    public $params;
    public $routeUri;
    public $uri;
    protected $routeType = 'Generic';

    public function __construct()
    {
        $this->uri = & load_class('URI', 'core');

        $this->setRouter();
    }

    public function setRouter()
    {
        $this->routeType == 'Forbiz' ? $this->forbizRouter() : $this->genericRouter();
    }

    public function getRoutePath()
    {
        $path       = is_cli() ? implode('/', $_SERVER['argv']) : parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $basename   = basename($scriptName);

        if (strpos($path, $scriptName) !== false) {
            if (strpos($path, $basename) === false) {
                $path = (rtrim($path, '/')).'/'.$basename;
            }
        } else {
            $path = str_replace(str_replace(('/'.$basename), '', $scriptName), '', $path);
        }

        return trim(str_replace($_SERVER['SCRIPT_NAME'], '', $path), '/');
    }

    public function forbizRouter()
    {
        $this->genericRouter();
    }

    public function genericRouter()
    {
        $path = $this->getRoutePath();

        $params = explode('/', $path);
        for ($i = 0; $i < count($params); $i++) {
            $this->uri->filter_uri($params[$i]);
        }

        $this->method = array_shift($params);
        $this->method = $this->method ? $this->method : 'index';
        $this->params = $params;
    }

    public function fetch_class()
    {
        return $this->class;
    }

    public function fetch_method()
    {
        return $this->method;
    }

    public function fetch_params()
    {
        return empty($this->params) ? array() : $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function setRouteUri($routeUri)
    {
        $this->routeUri = $routeUri;

        return $this;
    }

    public function getRoutingApp($package, $className, $params)
    {
        return $this->routeType == 'Forbiz' ? $this->forbizRoutingApp($package, $className, $params) : $this->genericRoutingApp($package, $className,
                $params);
    }

    public function forbizRoutingApp($package, $className, $params)
    {
        $className = sprintf('controller.%s.%s', $package, $className);

        $app = getForbiz()->import($className);
        if (is_object($app)) {
            $method       = !empty($params) ? array_shift($params) : 'index';
            $this->params = $params;

            return $app->setRunMethod($method);
        } else {
            log_message('error', 'Packege or Class is empty!');
        }
    }

    public function genericRoutingApp($package, $className, $params)
    {
        if (defined('FORBIZ_SCM_VERSION')) {
            $class = [$package, $className];
        } else {
            $class = [$package, $className, array_shift($params)];
        }

        if ($package != '' && $className != '') {
            $cLen = count($class) - 1;

            for ($i = 0; $i < $cLen; $i++) {
                $className = implode('.', $class);
                $app       = getForbiz()->import('controller.'.$className);
                if (is_object($app)) {
                    $method = !empty($params) ? array_shift($params) : 'index';

                    $this->params = $params;

                    return $app->setRunMethod($method);

                    break;
                }

                $params = array_merge((array) array_pop($class), $params);
            }
        } else {
            log_message('error', 'Packege or Class is empty!');
        }
    }

    public function set_class_name($class_name)
    {
        $this->class = $class_name;
        return $this;
    }

    public function getClean($data)
    {
        $data = $data ? trim($data, " \t\n\r\0\x0B/") : '';
        $this->uri->filter_uri($data);

        return $data;
    }
}

class CI_Router extends Nuna_Router
{

}