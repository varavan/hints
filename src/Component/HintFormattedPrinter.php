<?php

namespace Hints\Component;


use Hints\Model\Dto\Hint;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Output\OutputInterface;

class HintFormattedPrinter implements HintPrinterInterface
{
    const NUMBER_OF_LINES_OF_CODE_SORROUDING = 4;

    /**
     * @var OutputInterface
     */
    private $output;
    /**
     * @var FormatterHelper
     */
    private $formatter;
    /**
     * @var BuildAbsoluteFilePath
     */
    private $buildAbsoluteFilePath;

    public function __construct(
        BuildAbsoluteFilePath $buildAbsoluteFilePath)
    {
        $this->formatter = new FormatterHelper();
        $this->buildAbsoluteFilePath = $buildAbsoluteFilePath;


    }

    public function setOutput(OutputInterface $output){
        $this->output = $output;
        $style = new OutputFormatterStyle('white', 'black', array('bold', 'blink'));
        $this->output->getFormatter()->setStyle('code',$style);
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

        if(!is_null($hint->fileComment)){

            $readSomeFileLines = new ReadSomeFileLines($this->buildAbsoluteFilePath->build($hint->fileComment->path));
            $formattedFileCommentBlock = $this->formatter
                ->formatBlock(
                    sprintf('File Path: %s , File Line: %s', $hint->fileComment->path, $hint->fileComment->line),
                    'info',
                    true
                );
            $this->output->writeln($formattedFileCommentBlock);
            if(!is_null($hint->fileComment->line)){
                $formattedCodeBlock = $this->formatter
                    ->formatBlock(
                        $readSomeFileLines->findLinesOn($hint->fileComment->line, self::NUMBER_OF_LINES_OF_CODE_SORROUDING),
                        'code',
                        true
                    );
                $this->output->writeln($formattedCodeBlock);
            }
        }

        $formattedBlock = $this->formatter->formatBlock($tags, 'question');

        $this->output->writeln($formattedBlock);
    }


    public function addHints($hints, $limit)
    {
        if(count($hints) > $limit){
            $hintsPositions = array_rand($hints, $limit);
            if(!is_array($hintsPositions)){
                $hintsPositions = [$hintsPositions];
            }

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