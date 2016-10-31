<?php

namespace Hints\Component;

use Hints\Model\Dto\Hint;
use Hints\Model\Dto\Tag;

class HintReader
{
    /**
     * @var HintsFileStore
     */
    private $hintsFileStore;

    public function __construct(HintsFileStore $hintsFileStore)
    {
        $this->hintsFileStore = $hintsFileStore;
    }

    /**
     * @return Hint[]
     */
    public function getAll()
    {

        $datas = $this->hintsFileStore->getAllHints();

        $dtos = [];

        foreach ($datas as $data) {
            $object = new Hint();
            $object->content = $data['content'];
            $object->author = $data['author'];

            if (!empty($data['tags'])) {
                foreach ($data['tags'] as $tag) {

                    $tagObject = new Tag();
                    $tagObject->name = $tag['name'];
                    $object->tags[] = $tagObject;
                }
            }

            $dtos[] = $object;
        }

        return $dtos;
    }
}