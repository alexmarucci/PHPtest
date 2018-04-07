<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCSVCommand extends ContainerAwareCommand
{
    protected function configure()
    {
    	$this
        // the name of the command (the part after "bin/console")
        ->setName('transactions:import-csv')

        // the short description shown while running "php bin/console list"
        ->setDescription('Import transactions from a CSV file.')
        ->addArgument('filename', InputArgument::OPTIONAL, 'Name of the CSV file to be imported.')
        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allow you to import CSV file to the database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        if (null === $filename) {
            $filename = $this->getTodaysFile();
        }
        
        $file = $this->getContainer()->get('kernel')->getRootDir() . '/../storage/' . $filename;
        if (file_exists($file)) {
            if (is_file($file)) {
                $csvImporter = $this->getContainer()->get('transaction_csv_importer');
                $result = $csvImporter->import( $file );
                if ($result > 0 ){
                    $output->writeln($result . ' transactions has been successfully imported.');
                }
                else throw new \Exception('Error while parsing the file. ' . $file);
            }
        }
        else throw new \Exception("No data available. The file could not be found.");
    }

    private function getTodaysFile()
    {
        $today = new \Datetime();
        $filename = 'salesData_' . $today->format('d-m-Y') . '.csv';

        return $filename;
    }
}