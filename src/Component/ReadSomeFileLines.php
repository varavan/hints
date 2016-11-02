<?php

namespace Hints\Component;


use Hints\Exception\LineDoesNotExistsException;

class ReadSomeFileLines
{
    const DEFAULT_LINES_SURROUNDING = 3;
    /** @var \SplFileObject  */
    private $file;

    public function __construct($filePath)
    {
        $this->file = new \SplFileObject($filePath);
    }

    /**
     * @param $lineNumber
     * @param int $linesSurrounding
     * @return array
     */
    public function findLinesOn($lineNumber, $linesSurrounding = self::DEFAULT_LINES_SURROUNDING){

        $buffer = [];
        if($lineNumber <= 0){
            throw new LineDoesNotExistsException($lineNumber, $this->file->getPath());
        }elseif($lineNumber == 1){

            $start = 0;
            $end = $linesSurrounding - 1;

        }elseif(($lineNumber - $linesSurrounding) <= 1){
            $start = 0;
            $end = ($lineNumber + $linesSurrounding) - 1;
        }else{
            $start = ($lineNumber - $linesSurrounding) - 1;
            $end = ($lineNumber + $linesSurrounding) - 1;
        }

        for($i = $start; $i <= $end; $i++){
            $this->file->seek($i);
            $string = $this->file->current();
            // lets remove /n
            $string = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
            $buffer[] = $string;
        }
        return $buffer;
    }
}