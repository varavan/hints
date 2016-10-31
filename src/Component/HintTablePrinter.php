<?php

namespace Hints\Component;


use Hints\Model\Dto\Hint;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class HintTablePrinter
{
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;

        $this->table = new Table($output);
        $this->table->setColumnWidths([70, 10, 20]);
        $this->table->setStyle('borderless');
        $this->table->setHeaders(
            ['Content', 'Author', 'Tags']
        );
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
                $hint->content,
                $hint->author,
                (empty($hint->tags)) ? 'No tag' : implode(',', array_map(function ($tag) {
                    return $tag->name;
                }, $hint->tags))
            ]
        );
    }
}