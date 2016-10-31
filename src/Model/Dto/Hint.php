<?php

namespace Hints\Model\Dto;

class Hint
{

    public $content;

    public $author;

    /**
     * @var Tag[]
     */
    public $tags = [];
}