<?php
namespace MVC;

abstract class Controller {
    public $request;

    public function __construct($request) {
        $this->request = $request;
        $this->init();
    }

    public function getParam($name, $default = null) {
        return $this->request->getParam($name, $default);
    }

    public function init() { }
}