<?php
namespace MVC;

class Layout {

    public $layoutPath;
    public $view = null;
    public $breadcrumbList = array();
	
    protected $_parts = array();

    public function __construct() {
        $this->view = new View();
    }

    public function __get($key) {
		return $this->view->__get($key);
	}
	
	public function __set($key, $val) {
		$this->view->__set($key, $val);
	}
	
	public function render() {
        $result = $this->view->render($this->layoutPath);
        return $result;
	}
	
	public function isLayout() {
		if (is_null($this->layoutPath)) {
			return false;
		}
		return true;
	}
}