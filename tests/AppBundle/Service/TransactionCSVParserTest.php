<?php

namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Transaction;
use AppBundle\Exception\WrongFormatException;

class TransactionCSVParserTest extends KernelTestCase
{
    /**
    * {@inheritDoc}
    */
    protected function setUp()
    {
        self::bootKernel();
    }

    public function testParse()
    {
        $filename = 'salesData_06-04-2018' . '.csv';
        $parsedData = $this->performParsingAction( $filename );
        
        $this->assertEquals(sizeof($parsedData), 15 );
        $this->assertTrue(is_array($parsedData));
        $this->assertNotEmpty($parsedData);
    }

    public function testWrongFromatData()
    {
        $this->expectException(WrongFormatException::class);

        $filename = 'salesData_06-04-2018_bad_format' . '.csv';
        $this->performParsingAction( $filename );
    }

    private function performParsingAction($filename)
    {
        $container = static::$kernel->getContainer();

        $csvImporter = $container->get('transaction_csv_parser');
        $file = static::$kernel->getRootDir() . '/../storage/' . $filename;
        
        return $csvImporter->parse( $file );
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}