<?php

namespace Hints\Component;


use Hints\Model\Dto\Hint;

class HintWriter
{
    const ANONYMOUS_NAME = 'Anonymous';

    /**
     * @var HintsFileStore
     */
    private $hintsFileStore;

    public function __construct(
        HintsFileStore $hintsFileStore
    )
    {
        $this->hintsFileStore = $hintsFileStore;
    }

    public function write(Hint $hint){

        if(is_null($hint->author)){
            $hint->author = self::ANONYMOUS_NAME;
        }

        if(!is_array($hint->tags)){
            $hint->tags = [];
        }

        $this->hintsFileStore->addArrayToFile((array) $hint);

    }
}