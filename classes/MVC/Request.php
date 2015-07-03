<?php
namespace MVC;

class Request {
    public $requestUri;
    public $baseUri = '';
    public $modules = array();

    public $module = 'public';
    public $controller = 'index';
    public $action = 'index';
    public $type = 'html';

    public $params = array();

    public function __construct() {

        $uri = $_SERVER['REQUEST_URI'];
        $uri = explode('?', $uri);

        $this->requestUri = $uri[0];
        $this->referer = (isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : "/";

        $this->params = array_merge($_POST, $_GET);
        $this->modules = array('public', 'admin');
    }

    public function getParam($name, $default = null)  {
        if (!array_key_exists($name, $this->params)) {
            return $default;
        }
        return $this->params[$name];
    }

    public function addParams(array $params) {
        $this->params = array_merge($this->params, $params);
    }

    public function parseUri() {
        $path = $this->requestUri;
        if (!empty($this->baseUri)) {
            if (strpos($path, $this->baseUri) === 0) {
                $path = preg_replace('/^' . str_replace('/', '\/', $this->baseUri) . '/', '', $path, 1);
            }
        }

        $path = trim($path, '/');
        if (empty($path)) {
            return;
        }

        $m = array();
        preg_match('/^((\/[A-Za-z0-9\+\(\)_-]+)+)\.(html|json|ajax)$/', '/' . $path, $m);

        if (empty($m)) {
            $this->module = 'public';
            $this->controller = 'error';
            $this->action = 'not-found';

            return;
        }

        $parts = explode('/', trim($m[1], '/'));
        $this->type = $m[3];

        if (in_array($parts[0], $this->modules)) {
            $this->module = array_shift($parts);
        }

        if (!empty($parts)) {
            $this->controller = array_shift($parts);
        }

        if (!empty($parts)) {
            $this->action = array_shift($parts);
        }
    }
}