<?php

namespace Hints\Repository;

use Hints\Component\HintReader;
use Hints\Component\HintWriter;
use Hints\Model\Dto\Hint;

class HintRepository
{

    /**
     * @var HintWriter
     */
    private $hintWriter;
    /**
     * @var HintReader
     */
    private $hintReader;

    public function __construct(
        HintWriter $hintWriter,
        HintReader $hintReader
    )
    {
        $this->hintWriter = $hintWriter;
        $this->hintReader = $hintReader;
    }

    /**
     * @return Hint[]
     */
    public function all(){
        return $this->hintReader->getAll();
    }

    /**
     * @return Hint[]
     */
    public function byTag($tag){

        return array_filter(
            $this->hintReader->getAll(),
            function(Hint $hint) use ($tag){

                $val = false;

                foreach ($hint->tags as $tagObject){
                    if($tagObject->name == $tag){
                        $val = true;
                    }
                }

                return $val;
            }
        );


    }

    /**
     * @return Hint[]
     */
    public function byAuthor($author){

        return array_filter(
            $this->hintReader->getAll(),
            function(Hint $hint) use ($author){
                return ($hint->author == $author);
            }
        );
    }

    /**
     * @param Hint $hint
     * @return Hint
     */
    public function add(Hint $hint){
        $this->hintWriter->write($hint);
        return $hint;
    }
}
