<?php 

namespace Tests\AppBundle\Domain\Transaction\Handler;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Store;
use AppBundle\Report\MarketingReport;
use AppBundle\Domain\Transaction\Action\GetMarketingReportAction;
use AppBundle\Domain\Transaction\Responder\SimpleResponder;

class GetMarketingReportActionHandler extends KernelTestCase
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

        $store = $this->getFakeStore();

        $commandBus = static::$kernel->getContainer()->get('command_bus');
        $commandBus->handle(new GetMarketingReportAction( $store ));
        
        $responder = new SimpleResponder();
        $expectedData = array(
            'store_id' => 1,
            'store_name' => 'Test Store',
            'report' => [
                'total_transactions' => 3,
                'revenue' => 30
            ]
        );
        $report = $responder->respond();
        $this->assertInstanceOf(MarketingReport::class, $report);
        $this->assertEquals($report->toArray(), $expectedData);
    }

    private function getFakeStore()
    {
        $store = new Store();
        $store->setId(1);
        $store->setName('Test Store');
        for ($i=0; $i < 3; $i++) { 
            $transaction = new Transaction();
            $transaction->setTotalAmount(10);
            $transaction->setStore($store);
            $store->addTransaction( $transaction );
        }

        return $store;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}