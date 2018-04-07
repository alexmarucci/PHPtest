<?php

namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Transaction;

class TransactionCSVImporterTest extends KernelTestCase
{
    /**
    * {@inheritDoc}
    */
    protected function setUp()
    {
        self::bootKernel();
    }

    public function testImport()
    {
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $filename = 'salesData_06-04-2018' . '.csv';

        $NumOfDataImportes = $this->performImportAction( $filename );
        $transactionImported = $em->getRepository(Transaction::class)->findAll();
        
        $this->assertEquals($NumOfDataImportes, sizeof($transactionImported) );
    }

    public function testInvalidData()
    {   
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $filename = 'salesData_06-04-2018_invalid' . '.csv';

        $NumOfDataImportes = $this->performImportAction( $filename );
        $transactionImported = $em->getRepository(Transaction::class)->findAll();
        
        $this->assertEmpty($NumOfDataImportes);
        $this->assertEmpty($transactionImported);
    }

    public function testNotExistingData()
    {   
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $filename = 'salesData_06-04-2018_XX' . '.csv';

        $NumOfDataImportes = $this->performImportAction( $filename );
        $transactionImported = $em->getRepository(Transaction::class)->findAll();
        
        $this->assertEmpty($NumOfDataImportes);
        $this->assertEmpty($transactionImported);
    }

    private function performImportAction($filename)
    {
        $container = static::$kernel->getContainer();
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();

        $csvImporter = $container->get('transaction_csv_importer');
        $file = static::$kernel->getRootDir() . '/../storage/' . $filename;
        
        return $csvImporter->import( $file );
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