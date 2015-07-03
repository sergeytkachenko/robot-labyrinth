<?php
namespace Core;

class Registry {
	static protected $_registry = array();

	static public function get($index) {
		if (!self::isRegistered($index)) {
			throw new Exception("No entry is registered for key '$index'");
		}

		return self::$_registry[$index];	
	}
	
	static public function set($index, $value) {
		self::$_registry[$index] = $value;
	}
	
	static public function isRegistered($index) {
		return array_key_exists($index, self::$_registry);
	}
}