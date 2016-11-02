<?php

namespace Hints\Factory;


use Hints\Exception\FileNotFoundException;
use Hints\Model\Dto\Hint;
use Hints\Model\Dto\Tag;

class HintDtoFactory
{

    /**
     * @var FileCommentDtoFactory
     */
    private $fileCommentFactory;

    public function __construct(FileCommentDtoFactory $fileCommentFactory)
    {
        $this->fileCommentFactory = $fileCommentFactory;
    }

    /**
     * @param $content
     * @param null $author
     * @param null | null $tagsNames
     * @param null $filePath
     * @param null $fileLine
     * @return Hint
     * @throws FileNotFoundException
     */
    public function make(
        $content,
        $author = null,
        $tagsNames = null,
        $filePath = null,
        $fileLine = null
    ){
        $hint = new Hint();
        $hint->content = $content;
        $hint->author = $author;

        if(!is_null($tagsNames)){

            foreach ($tagsNames as $tagString){
                if(is_string($tagString)){
                    $tagObject = new Tag();
                    $tagObject->name = $tagString;
                    $hint->tags[] = $tagObject;
                }
            }
        }

        if(!is_null($filePath)){
            $hint->fileComment = $this->fileCommentFactory->make($filePath, $fileLine);
        }


        return $hint;
    }
}