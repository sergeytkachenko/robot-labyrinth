<?php
namespace Labyrinth;

use Core\Exception;

class Map {

    private $coordinates = array();
    const SYMBOL = '*';

    function __construct($fileMapPath=null) {
        if(!$fileMapPath) {return;}
        $this->parseFileMap($fileMapPath);
    }

    public function getCoordinates() {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates) {
        $this->coordinates = $coordinates;
    }

    /**
     * @param $fileMapPath
     * @param bool $absolutePath
     * @return array
     * @throws Exception
     */
    private function parseFileMap ($fileMapPath, $absolutePath=false) {
        $fileMapPath = !$absolutePath ? PUBLIC_PATH . '/' . $fileMapPath : $fileMapPath;
        $handle = fopen($fileMapPath, "r");

        if ($handle) {
            $lineIndex = 1;
            while (($line = fgets($handle)) !== false) {
                $length = strlen($line);
                for($columnIndex = 0; $length > $columnIndex; $columnIndex++) {
                    $symbol = $line[$columnIndex];
                    if($symbol == Map::SYMBOL) {
                        $this->coordinates[] = array($lineIndex, $columnIndex+1);
                    }
                }
                $lineIndex++;
            }

            fclose($handle);
        } else {
            throw new Exception('Could not open file '.$fileMapPath);
        }

        return $this->coordinates;
    }

    public function isCellIsset(array $cell) {
        return in_array($cell, $this->coordinates);
    }

    /**
     * @param array $cell
     * @param array $vector
     * @return array
     */
    public static function getCellByVector (array $cell, array $vector) {
        return array(
            $cell[0] + $vector[0],
            $cell[1] + $vector[1]
        );
    }
}