<?php
namespace Labyrinth;

abstract class Robot {

    private $map;

    private $currentCell = array();
    private $destinationCell = array();

    private $historyCells = array();
    private $absoluteHistoryCells = array();

    private $moveVectors = array(
        'up' => array(0, 1),
        'left' => array(-1, 0),
        'right' => array(1, 0),
        'down' => array(0, -1)
    );

    function __construct (Map $map, array $currentCell=array(), array $destinationCell=array()) {
        $this->map = $map;
        $this->currentCell = $currentCell;
        $this->destinationCell = $destinationCell;
    }

    /**
     * return to the prev move
     */
    private function back () {
        $cell = array_pop($this->historyCells);
        if(!$cell) {
            //throw new MoveException('robot nowhere to go, has reached the end');
            return;
        }
        $this->currentCell = $cell;
        $this->absoluteHistoryCells[] = $this->currentCell;

        return $this->currentCell;
    }

    private function setCurrentCell (array $cell) {
        $this->currentCell = $cell;

        $this->historyCells[] = $cell;
        $this->absoluteHistoryCells[] = $cell;

        return $this->currentCell;
    }

    function getNextMove () {
        foreach($this->moveVectors as $direction => $vector) {
            $cell = $this->map->getCellByVector($this->currentCell, $vector);

            // whether there is a field on the map
            if(!$this->map->isCellIsset($cell)) {continue;}

            // check whether we were here
            if($this->in_array($cell, $this->absoluteHistoryCells)) {continue;}

            return $cell;
        }
        return false; // deadlock
    }

    static function in_array($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    public function isNeedMove () {
        return array_diff($this->destinationCell, $this->currentCell) !== array();
    }

    public function move () {
        if($this->currentCell[0] == $this->destinationCell[0] and $this->currentCell[1] == $this->destinationCell[1]) {
            return $this->currentCell;
        }
        $cell = $this->getNextMove();
        if($cell) {
            return $this->setCurrentCell($cell);
        }
        return $this->back();
    }

    public function getCurrentCell () {
        return $this->currentCell;
    }

    public function setHistory(array $cells) {
        $this->historyCells = $cells;
    }

    public function setAbsoluteHistory(array $cells) {
        $this->absoluteHistoryCells = $cells;
    }

    private function addHistory(array $cell) {
        $this->historyCells[] = $cell;
    }

    private function addAbsoluteHistory(array $cell) {
        $this->absoluteHistoryCells[] = $cell;
    }

    public function getAbsoluteHistory() {
        return $this->absoluteHistoryCells;
    }

    public function getHistory() {
        return $this->historyCells;
    }


}