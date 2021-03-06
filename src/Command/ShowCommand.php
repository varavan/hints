<?php

namespace Hints\Command;

use Hints\Component\HintFormattedPrinter;
use Hints\Repository\HintRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ShowCommand extends Command implements ContainerAwareInterface
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
            ->setName('show')
            // the short description shown while running "php bin/console list"
            ->setDescription('List random hints')
            ->setHelp("This command allows you to create users...")
            ->addOption('tags', 't', InputOption::VALUE_OPTIONAL, 'Filter by tag', null)
            ->addOption('author', 'a', InputOption::VALUE_OPTIONAL, 'Filter by author' . null)
            ->addOption('file-path', 'f', InputOption::VALUE_OPTIONAL, 'Filter by file', null)
            ->addOption('limit', 'l', InputOption::VALUE_OPTIONAL, 'Set the limit of messages', 1);
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conditions = [];

        if (!is_null($input->getOption('tags'))) {
            $conditions[HintRepository::TAG_CONDITION_NAME] = $input->getOption('tags');
        }
        if(!is_null($input->getOption('file-path'))) {
            $conditions[HintRepository::FILE_PATH_CONDITION_NAME] = $input->getOption('file-path');
        }

        if(!is_null($input->getOption('author'))) {
            $conditions[HintRepository::AUTHOR_CONDITION_NAME] = $input->getOption('author');
        }


        $hints = $hints = $this->container->get('app.repository.hint')->findBy($conditions);

        if (empty($hints)) {
            $output->writeln('There are no hints! Start writing some with <info>hints add</info> command');
            return;
        }

        $hintPrinter = $this->container->get('app.component.hint_printer');
        $hintPrinter->setOutput($output);
        $hintPrinter->addHints($hints, $input->getOption('limit'));
        $hintPrinter->finish();
    }


}