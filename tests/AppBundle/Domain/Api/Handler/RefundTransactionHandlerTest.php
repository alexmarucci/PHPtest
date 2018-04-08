<?php 

namespace Tests\AppBundle\Domain\Transaction\Handler;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Refund;
use AppBundle\Domain\Transaction\Action\RefundTransactionAction;

class RefundTransactionHandlerTest extends KernelTestCase
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
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        
        $commandBus = static::$kernel->getContainer()->get('command_bus');
        $fakeTransaction = $this->persistFakeTransaction();
        $commandBus->handle(new RefundTransactionAction( $fakeTransaction->getId() ));

        $refund = $em->getRepository(Refund::class)->findOneById( $fakeTransaction->getRefund()->getId() );

        $this->assertInstanceOf(Refund::class, $refund );
    }

    public function testNotFoundTransaction()
    {
        $commandBus = static::$kernel->getContainer()->get('command_bus');

        try {
            $commandBus->handle(new RefundTransactionAction(999));
            $this->assertTrue( false );
        } catch (\Exception $e) {
            $this->assertEquals(404, $e->getCode());
        }
    }

    private function persistFakeTransaction()
    {
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        
        $transaction = new Transaction();
        $transaction->setTotalAmount(1);
        $transaction->setCurrency('GBP');
        
        $em->persist( $transaction );
        $em->flush();

        return $transaction;
    }

    private function clearTransactionData()
    {
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $query = $em->createQuery('DELETE FROM AppBundle:Refund');
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