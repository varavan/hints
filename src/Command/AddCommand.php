<?php
namespace Hints\Command;

use Hints\Component\HintFormattedPrinter;
use Hints\Factory\HintDtoFactory;
use Hints\Model\Dto\Hint;
use Hints\Model\Dto\Tag;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AddCommand extends Command implements ContainerAwareInterface
{
    /** @var  ContainerInterface */
    private $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('add')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a hint and add it to the store')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to create users...")

            ->addArgument('content', InputArgument::REQUIRED, 'Set the content for the content')
            ->addOption('tags', 't', InputOption::VALUE_OPTIONAL, 'Set tags for clasifying this image, please separate it by a comma ","', null)
            ->addOption('author', 'a', InputOption::VALUE_OPTIONAL, 'Set the author for the hint', null)
            ->addOption('file-path', 'f', InputOption::VALUE_OPTIONAL, 'Set a file path for the hint', null)
            ->addOption('file-line', 'fl', InputOption::VALUE_OPTIONAL, 'Set a file path for the hint', null)
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var HintDtoFactory $hintDtoFactory */
        $hintDtoFactory = $this->container->get('app.factory.hint_dto');
        $hint = $hintDtoFactory->make(
            $input->getArgument('content'),
            $input->getOption('author'),
            (is_null($input->getOption('tags')) ? null : explode(',', $input->getOption('tags'))),
            $input->getOption('file-path'),
            $input->getOption('file-line')
        );

        $hint = $this->container->get('app.repository.hint')->add($hint);

        $hintPrinter = $this->container->get('app.component.hint_printer');
        $hintPrinter->setOutput($output);
        $hintPrinter->addHint($hint);
        $hintPrinter->finish();

    }


}
