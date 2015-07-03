<?php
namespace MVC;

use \Core\Exception;

class View {

    public $templatePath;
	public $renderData;
	public $responseSection = 'default';

	protected $_data = array();
	
	public function __construct() {
		$this->templatePath = APPLICATION_PATH . '/views/';
	}

	public function __get($key) {
        if (!array_key_exists($key, $this->_data)) {
                return null;
        }
        return $this->_data[$key];
	}
	
	public function __set($key, $value) {
        $this->_data[$key] = $value;
	}
	
	public function setData($data = array()) {
        $this->_data = array_merge($this->_data, $data);
	}
	
	public function render($path = null, $data = null) {
        ob_start();

        $path = APPLICATION_PATH  . trim($path, '/') . '.phtml';

        if ( !file_exists($path)) {
            throw new Exception("Template '$path' not found");
        }
        $res = include $path;

        if ($res === false) {
            throw new Exception("Error including template '$path'");
        }

        return ob_get_clean();
	}
	
	public function partial($path, $data = array()) {
		$view = new View();
		$view->setData($data);

		return $view->render($path);
	}

}