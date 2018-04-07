<?php 

namespace Tests\AppBundle\Domain\Api\Handler;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Transaction;
use AppBundle\Domain\Api\Action\AddTransactionAction;

class AddTransactionActionTest extends KernelTestCase
{
	/**
    * {@inheritDoc}
    */
    protected function setUp()
    {
        self::bootKernel();
    }

    public function testHandle()
    {
        $data = array();

        $data['TRANSACTION ID'] = 123456;
        $data['STORE ID'] = '1';
        $data['TOTAL AMOUNT'] = '1';
        $data['CURRENCY'] = 'GBP';
        $data['CREATED AT'] = '07/04/2018 10:10';

        $commandBus = static::$kernel->getContainer()->get('command_bus');
        $commandBus->handle(new AddTransactionAction( $data ));

        $transactionImported = $em->getRepository(Transaction::class)->findOneByTransactionId(123456);
        $this->assertInstanceOf(Transaction::class, $transactionImported );
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}