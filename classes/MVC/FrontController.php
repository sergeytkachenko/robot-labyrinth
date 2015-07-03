<?php

namespace MVC;

use Core\Utils;
use Exception;

class FrontController {
    public $request;
    public $response;

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function dispatch()  {
        try {
            $result = $this->executeControllerAction($this->request->module, $this->request->controller, $this->request->action);
            $page = $this->response->send($result);
            return $page;

        } catch (Exception $e) {
            header('HTTP/1.1 404');

            $this->request->module = 'public';
            $this->request->controller = 'error';
            $this->request->action = 'not-found';

            $result = $this->executeControllerAction('public', 'error', 'not-found');
            $this->response->send($result);

            return false;
        }
    }

    public function executeControllerAction($moduleName, $controllerName, $actionName, $params = array()) {
        $this->request->addParams($params);

        $controllerClass = Utils::toMixedCase($controllerName) . 'Controller';
        $path = APPLICATION_PATH . "/modules/{$moduleName}/controllers/{$controllerClass}.php";

        if (!file_exists($path)) {
            throw new Exception("Controller '{$controllerClass}' not found");
        }

        include_once($path);

        $controller = new $controllerClass($this->request);
        $action = Utils::toCamelCase($actionName) . 'Action';
        $controller->init($action);
        $result = $controller->$action();

        return $result;

    }
}