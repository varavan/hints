<?php

namespace Hints\Component;


use Hints\Model\Dto\Hint;
use Symfony\Component\Console\Output\OutputInterface;

interface HintPrinterInterface
{

    public function addHint(Hint $hint);

    public function addHints($hints, $limit);

    public function finish();

    public function setOutput(OutputInterface $output);
}