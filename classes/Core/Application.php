<?php
namespace Core;

use MVC\FrontController;
use MVC\Layout;
use MVC\Request;
use MVC\Response;

class Application {

    public $request;
    public $response;
    public $front;
    public $layout;

    public function __construct() {
        $this->_init();
    }

    public function run() {
        $this->front->dispatch();
    }

    protected function _init() {

        Registry::set('app', $this);

        $this->request = new Request();
        $this->response = new Response($this->request);
        $this->request->parseUri();
        $this->front = new FrontController($this->request, $this->response);

        $this->_initLayout();
    }


    protected function _initLayout() {
        $this->layout = new Layout();

        $type = $this->request->type;
        if (in_array($type, array('json', 'ajax'))) {
            return;
        }
        $this->layout->layoutPath = 'modules/' . $this->request->module . '/views/layouts/' . $type;
    }
}