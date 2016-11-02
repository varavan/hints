<?php

namespace Hints\Exception;


class LineDoesNotExistsException extends \Exception
{
    public function __construct($line, $filepath, $code = 0, \Exception $previous = null)
    {
        parent::__construct('Line '.$line.' not found on file not found: '.$filepath, 404, $previous);
    }
}