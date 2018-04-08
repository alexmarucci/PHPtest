<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\ImportCSVCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportCSVCommandTest extends KernelTestCase
{
    /**
    * {@inheritDoc}
    */
    protected function setUp()
    {
        self::bootKernel();
    }

    public function testExecute()
    {
        $filename = 'salesData_06-04-2018.csv';
        $output = $this->executeCommand( $filename );
        
        $this->assertContains('15 transactions has been successfully imported.', $output);
    }
    public function testFileNotExist()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No data available. The file could not be found.');

        $filename = 'salesData_06-04-2018__XX' . '.csv';
        $output = $this->executeCommand( $filename );
    }

    public function testInvalidFile()
    {
        $filename = 'salesData_06-04-2018_bad_format' . '.csv';
        $filePath = static::$kernel->getRootDir() . '/../storage/';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error while parsing the file. ' . $filePath . $filename);

        $output = $this->executeCommand( $filename );
    }

    private function executeCommand($filename)
    {   
        $application = new Application(static::$kernel);
        $application->add(new ImportCSVCommand());
        $command = $application->find('transactions:import-csv');
        
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            'filename' => $filename,
        ));

        return $commandTester->getDisplay();
    }

    private function clearTransactionData()
    {
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $query = $em->createQuery('DELETE FROM AppBundle:Transaction');
        $query->execute(); 
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        $this->clearTransactionData();
        parent::tearDown();
    }
}