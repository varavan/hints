<?php

namespace Hints\Factory;

use Hints\Component\BuildAbsoluteFilePath;
use Hints\Exception\FileNotFoundException;
use Hints\Model\Dto\FileComment;

class FileCommentDtoFactory
{

    /**
     * @var BuildAbsoluteFilePath
     */
    private $buildAbsoluteFilePath;

    public function __construct(BuildAbsoluteFilePath $buildAbsoluteFilePath)
    {
        $this->buildAbsoluteFilePath = $buildAbsoluteFilePath;
    }

    /**
     * @param $filePath
     * @param null $fileLine
     * @return FileComment
     * @throws FileNotFoundException
     */
    public function make(
        $filePath,
        $fileLine = null
    ){
        $this->buildAbsoluteFilePath->build($filePath);

        $fileComment = new FileComment();
        $fileComment->path = $filePath;
        $fileComment->line = $fileLine;

        return $fileComment;

    }
}