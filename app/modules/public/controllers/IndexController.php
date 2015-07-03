<?php

class IndexController extends \MVC\Controller{

    public function indexAction() {
        try {
            $fileMapPath = $this->getParam('fileMapPath');
            $map = new \Labyrinth\Map($fileMapPath);

        } catch (Exception $e) {
            debug($e->getMessage());
        }

        return array(
            'coordinates' => $map->getCoordinates()
        );
    }

    public function mapAction () {
        $fileMapPath = $this->getParam('fileMapPath');
        $map = new \Labyrinth\Map($fileMapPath);

        return array(
            'coordinates' => $map->getCoordinates()
        );
    }
}