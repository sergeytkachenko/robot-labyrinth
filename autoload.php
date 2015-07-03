<?php

class Autoloader {
    static public function loader($className) {
        $filename = PUBLIC_PATH . "/classes/" . str_replace('\\', '/', $className) . ".php";
        if (file_exists($filename)) {
            require_once $filename;
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
spl_autoload_register('Autoloader::loader');