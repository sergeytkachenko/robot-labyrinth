<?php

class RobotController extends \MVC\Controller{

    public function moveAction() {

        $mapCoordinates = json_decode($this->getParam('map'));
        $history = json_decode($this->getParam('history'));
        $absoluteHistory = json_decode($this->getParam('absoluteHistory'));
        $currentCell = json_decode($this->getParam('currentCell'));
        $finishCell = json_decode($this->getParam('finishCell'));

        $map = new Labyrinth\Map();
        $map->setCoordinates($mapCoordinates);

        try {

            $robot = new Labyrinth\Alex($map, $currentCell, $finishCell);
            $robot->setHistory($history);
            $robot->setAbsoluteHistory($absoluteHistory);
            $move =  $robot->move();

        } catch (Exception $e) {
            return array(
                'success' => false,
                'msg' => $e->getMessage()
            );
        }

        return array(
            'move' => $move,
            'history' => $robot->getHistory(),
            'success' => true
        );
    }

}