<?php

namespace Hints\Component;

use Hints\Factory\HintDtoFactory;
use Hints\Model\Dto\Hint;
use Hints\Model\Dto\Tag;

class HintReader
{
    /**
     * @var HintsFileStore
     */
    private $hintsFileStore;
    /**
     * @var HintDtoFactory
     */
    private $hintDtoFactory;

    public function __construct(
        HintsFileStore $hintsFileStore,
        HintDtoFactory $hintDtoFactory)
    {
        $this->hintsFileStore = $hintsFileStore;
        $this->hintDtoFactory = $hintDtoFactory;
    }

    /**
     * @return Hint[]
     */
    public function getAll()
    {

        $datas = $this->hintsFileStore->getAllHints();

        $dtos = [];

        foreach ($datas as $data) {

            $tagsName = [];
            if (!empty($data['tags'])) {
                foreach ($data['tags'] as $tag) {
                    $tagsName[] = $tag['name'];
                }
            }

            $dtos[] = $this->hintDtoFactory->make(
                $data['content'],
                $data['author'],
                (empty($tagsName)) ? null : $tagsName,
                (array_key_exists('fileComment', $data) ? $data['fileComment']['path'] : null),
                (array_key_exists('fileComment', $data) ? $data['fileComment']['line'] : null)
            );

        }

        return $dtos;
    }
}