<?php 

namespace Tests\AppBundle\Domain\Transaction\Handler;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Store;
use AppBundle\Report\MarketingReport;
use AppBundle\Domain\Transaction\Action\GetStoresFromLocationAction;
use AppBundle\Domain\Transaction\Responder\SimpleResponder;

class GetStoresFromLocationHandlerTest extends KernelTestCase
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
    	$result = $this->executeGetStoreFromLocationAction( 'London' );
        $this->assertEquals(6, count($result) );
        $result = $this->executeGetStoreFromLocationAction( 'Richmond' );
        $this->assertEquals(3, count($result) );
        $result = $this->executeGetStoreFromLocationAction( 'W1F 8ZA' );
        $this->assertEquals(1, count($result) );
    }

    private function executeGetStoreFromLocationAction($location)
    {
    	$commandBus = static::$kernel->getContainer()->get('command_bus');
        $commandBus->handle(new GetStoresFromLocationAction( $location ));

        return (new SimpleResponder())->respond();   
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}