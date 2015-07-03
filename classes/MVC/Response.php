<?php
namespace MVC;
use Core\Registry;

class Response
{
    public $request;
    
    public function __construct(Request $request) {
        $this->request = $request;
    }
	
    public function send($result) {
        if (!$result) {
            $result = array();
        }
        $type = $this->request->type;

        if ($type == 'json') {
            return $this->sendJson($result);    
        }

        if ($type == 'html' || $type == 'ajax') {
            $layout = Registry::get('app')->layout;

            $view = new View();
            $view->setData($result);
            $content = $view->render('modules/' . $this->request->module . '/views/' . $this->request->controller . '/' . $this->request->action);
            
            if ($layout->isLayout()) {
                $layout->content = $content;
                $content = $layout->render();
            }

            echo $content;

            return $content;
        }

        return null;
    }
	
    public function sendJson($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json; charset=utf-8');

        $res = json_encode($data);

        echo $res;
        return $res;
    }
}

