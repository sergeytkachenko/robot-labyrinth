<?php
namespace Core;

class Exception extends \Exception{
    public $reason;

    public function __construct($message, Exception $reason = null)
    {
        if ($reason) {
            $message .= ' --> ' . $reason->getMessage();
        }
        parent::__construct($message);

        $this->reason = $reason;
    }
}