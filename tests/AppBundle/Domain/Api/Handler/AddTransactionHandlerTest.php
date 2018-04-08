<?php 

namespace Tests\AppBundle\Domain\Api\Handler;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Transaction;
use AppBundle\Domain\Api\Action\AddTransactionAction;
use AppBundle\Domain\Api\Responder\SimpleResponder;

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

        $data['transaction_id'] = 123456;
        $data['store'] = '1';
        $data['total_amount'] = '1';
        $data['currency'] = 'GBP';
        $data['created_at'] = '07/04/2018 10:10';

        $transactionValidator = static::$kernel->getContainer()->get('transaction_validator');
        $transaction = $transactionValidator->validate( $data );

        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        
        $commandBus = static::$kernel->getContainer()->get('command_bus');
        $commandBus->handle(new AddTransactionAction( $transaction ));
        $transactionImported = (new SimpleResponder())->respond();

        $this->assertInstanceOf(Transaction::class, $transactionImported );
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