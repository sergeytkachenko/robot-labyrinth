<?php
namespace Core;
use Exception;

abstract class Utils {

    public static function toMixedCase($string) {
        if (preg_match('/^[a-zA-Z-]+$/', $string)) {
            if (preg_match('/-/', $string)) {
                $name = explode('-', $string);
                $string = '';
                foreach ($name as $value) {
                    $string .= ucfirst(strtolower($value));
                }
                return $string;
            }
            else {
                return ucfirst(strtolower($string));
            }
        }
        else{
            throw new Exception('Unavailable symbols in controller name');
        }
    }

    public static function toCamelCase($string) {
        if (preg_match('/^[a-zA-Z-]+$/', $string)) {
            if (preg_match('/-/', $string)) {
                $name = explode('-', $string);
                $string = '';
                for ($i = 0; $i < count($name); $i++) {
                    if ($i == 0) {
                        $string .= strtolower($name[$i]);
                    }
                    else {
                        $string .= ucfirst(strtolower($name[$i]));
                    }
                }
                return $string;
            }
            else {
                return strtolower($string);
            }
        }
        else{
            throw new Exception('Unavailable symbols in action name');
        }
    }
}