<?php

namespace Hints\Command;

use Hints\Component\HintTablePrinter;
use Hints\Model\Dto\Hint;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
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
            ->addOption('limit', 'l', InputOption::VALUE_OPTIONAL, 'Set the limit of messages', 1);
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        if (!is_null($input->getOption('tags'))) {
            $hints = $this->container->get('app.repository.hint')->byTag($input->getOption('tags'));
        } elseif (!is_null($input->getOption('author'))) {
            $hints = $this->container->get('app.repository.hint')->byAuthor($input->getOption('author'));
        } else {
            $hints = $this->container->get('app.repository.hint')->all();
        }

        if (empty($hints)) {
            $output->writeln('There are no hints! Start writing some with <info>hints add</info> command');
            return;
        }

        $tableHelper = new HintTablePrinter($output);
        $tableHelper->addHints($hints, $input->getOption('limit'));
        $tableHelper->finish();
    }


}