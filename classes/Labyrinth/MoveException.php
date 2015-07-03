<?php
namespace Labyrinth;
use Core\Exception;

class MoveException extends Exception{
    public $reason;

    public function __construct($message, Exception $reason = null) {

        if ($reason) {
            $message .= ' --> ' . $reason->getMessage();
        }
        parent::__construct($message);

        $this->reason = $reason;
    }
}