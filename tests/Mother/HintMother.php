<?php

namespace Tests\Hints\Mother;


use Hints\Model\Dto\FileComment;
use Hints\Model\Dto\Hint;
use Hints\Model\Dto\Tag;

class HintMother
{
    const ANY_TAG_NAME = 'tag';
    const ANY_AUTHOR = 'author';
    const ANY_FILE_PATH = 'file_name';
    const ANY_FILE_LINE = 13;
    const ANY_CONTENT = 'content';

    public function makeHint(
        $content = self::ANY_CONTENT,
        $author = self::ANY_AUTHOR,
        $tagName = self::ANY_TAG_NAME,
        $fileCommentPath = self::ANY_FILE_PATH,
        $fileCommentLine = self::ANY_FILE_LINE
    ){
        $hint = new Hint();

        $tag = new Tag();
        $tag->name = $tagName;

        $fileComment = new FileComment();
        $fileComment->path = $fileCommentPath;
        $fileComment->line = $fileCommentLine;

        $hint->tags = [$tag];
        $hint->author = $author;
        $hint->content = $content;
        $hint->fileComment = $fileComment;


        return $hint;
    }
}