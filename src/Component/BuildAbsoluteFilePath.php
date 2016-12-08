<?php

namespace Hints\Component;


use Hints\Exception\FileNotFoundException;

class BuildAbsoluteFilePath
{

    private $relativeProjectPath;

    public function __construct($relativeProjectPath)
    {

        $this->relativeProjectPath = trim($relativeProjectPath,'/');
        if(!empty($this->relativeProjectPath)){
            $this->relativeProjectPath = '/'.$this->relativeProjectPath;
        }
    }

    public function build($filePath){

        if(!file_exists($this->buildFileAbsoluteFilePath($filePath))){
            throw new FileNotFoundException($this->buildFileAbsoluteFilePath($filePath));
        }

        return $this->buildFileAbsoluteFilePath($filePath);
    }

    /**
     * @param $filePath
     * @return string
     */
    private function buildFileAbsoluteFilePath($filePath)
    {
        return __DIR__ . '/../../' . $this->relativeProjectPath . "/" .ltrim($filePath, '/');
    }
}