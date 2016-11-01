<?php

namespace Hints\Component;


use Hints\Model\Dto\Hint;

interface HintPrinterInterface
{

    public function addHint(Hint $hint);

    public function addHints($hints, $limit);

    public function finish();
}