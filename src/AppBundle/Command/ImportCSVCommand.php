<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCSVCommand extends Command
{
    protected function configure()
    {
    	$this
        // the name of the command (the part after "bin/console")
        ->setName('transactions:import-csv')

        // the short description shown while running "php bin/console list"
        ->setDescription('Import transactions from a CSV file.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allow you to import CSV file to the database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('success');
    }
}