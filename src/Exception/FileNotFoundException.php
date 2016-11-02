<?php

namespace Hints\Exception;


class FileNotFoundException extends \Exception
{
    public function __construct($path = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct('File not found: '.$path, 404, $previous);
    }
}