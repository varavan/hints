<?php

namespace Hints\Component;

use Hints\Model\Dto\Hint;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Output\OutputInterface;

class HintTablePrinter implements  HintPrinterInterface
{
    /**
     * @var OutputInterface
     */
    private $output;
    /**
     * @var Table
     */
    private $table;

    public function setOutput(OutputInterface $output){
        $this->output = $output;
        $this->initTable($this->output);
    }

    public function addHint(Hint $hint)
    {
        $this->printRow($hint);
    }

    public function addHints($hints, $limit)
    {
        if (count($hints) > 1) {


            if (count($hints) > $limit) {

                $positions = array_rand($hints, $limit);
                if ($limit == 1) {
                    $positions = [$positions];
                }

            } else {
                $positions = array_keys($hints);
            }


            foreach ($positions as $hintPosition) {

                $hint = $hints[$hintPosition];

                $this->addHint($hint);
            }
        } else {
            $this->addHint(end($hint));
        }
    }


    public function finish()
    {
        $this->table->render();
    }

    /**
     * @param $table
     * @param $hint
     */
    protected function printRow(Hint $hint)
    {
        $this->table->addRow(
            [
                new TableCell($hint->content, array('rowspan' => 2)),
                $hint->author,
                (empty($hint->tags)) ? 'No tag' : implode(',', array_map(function ($tag) {
                    return $tag->name;
                }, $hint->tags))
            ]
        );
    }

    /**
     * @param $output
     */
    private function initTable($output)
    {
        $this->table = new Table($output);
        $this->table->setStyle('borderless');
        $this->table->setHeaders(
            ['Content', 'Author', 'Tags']
        );
    }
}