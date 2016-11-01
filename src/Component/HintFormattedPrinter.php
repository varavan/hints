<?php

namespace Hints\Component;


use Hints\Model\Dto\Hint;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Output\OutputInterface;

class HintFormattedPrinter implements HintPrinterInterface
{
    /**
     * @var OutputInterface
     */
    private $output;
    /**
     * @var FormatterHelper
     */
    private $formatter;

    public function __construct(OutputInterface $output)
    {

        $this->output = $output;
        $this->formatter = new FormatterHelper();
    }

    public function addHint(Hint $hint){
        $formattedLine = $this->formatter->formatSection(
            $hint->author,
            $hint->content
        );
        $this->output->writeln($formattedLine);

        $tags = [];
        foreach($hint->tags as $tag){
            $tags[] = $tag->name;
        }

        $formattedBlock = $this->formatter->formatBlock($tags, 'question');

        $this->output->writeln($formattedBlock);
    }


    public function addHints($hints, $limit)
    {
        if(count($hints) > $limit){
            $hintsPositions = array_rand($hints, $limit);

            foreach($hintsPositions as $hintPosition){
                $this->addHint($hints[$hintPosition]);
            }
        }else{
            foreach($hints as $hint){
                $this->addHint($hint);
            }
        }

    }

    public function finish()
    {
    }
}