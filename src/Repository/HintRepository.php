<?php

namespace Hints\Repository;

use Hints\Component\HintReader;
use Hints\Component\HintWriter;
use Hints\Model\Dto\Hint;

class HintRepository
{
    const FILE_PATH_CONDITION_NAME = 'file';
    const AUTHOR_CONDITION_NAME = 'author';
    const TAG_CONDITION_NAME = 'tag';

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

    public function byFilePath($filePath){
        return array_filter(
            $this->hintReader->getAll(),
            function(Hint $hint) use ($filePath){
                return (is_null($hint->fileComment)
                    ? false
                    :  ($hint->fileComment->path == $filePath)
                );
            }
        );
    }

    public function findBy($conditions){

        $calls = array_map(function($condition) use ($conditions){
            return function(Hint $hint) use ($condition, $conditions){
                if($condition == self::AUTHOR_CONDITION_NAME){
                    return ($hint->author == $conditions[self::AUTHOR_CONDITION_NAME]);
                }elseif($condition == self::TAG_CONDITION_NAME){
                    $val = false;
                    foreach ($hint->tags as $tagObject){
                        if($tagObject->name == $conditions[self::TAG_CONDITION_NAME]){
                            $val = true;
                            break;
                        }
                    }
                    return $val;
                }elseif($condition == self::FILE_PATH_CONDITION_NAME){
                    return (is_null($hint->fileComment)
                        ? false
                        :  ($hint->fileComment->path == $conditions[self::FILE_PATH_CONDITION_NAME])
                    );
                }

                return true;
            };
        }, array_keys($conditions));


        return array_filter(
            $this->hintReader->getAll(),
            function(Hint $hint) use ($calls){
                $val = true;

                foreach($calls as $call){
                    if(false == $call($hint)){
                        $val = false;
                    }
                }

                return $val;
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
