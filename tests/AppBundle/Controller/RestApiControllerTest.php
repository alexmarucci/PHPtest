<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RestApiControllerTest extends WebTestCase
{
	/**
    * {@inheritDoc}
    */
    protected function setUp()
    {
        self::bootKernel();
    }

	public function testPostNewTransactionAction()
	{
		$payload = [
			'transaction_id' => '123456',
			'store' => '1',
			'total_amount' => '1',
			'currency' => 'GBP',
			'created_at' => '07/04/2018 16:16',
			'apiKey' => 'xxxxx_good_api_key_xxxxxxx'
		];

		$client = static::createClient();

        $client->request(
        	'POST',
        	'/api/v1/transactions',
        	$payload,
        	array(),
            array('CONTENT_TYPE' => 'application/json')
        );
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        //$this->assertContains('api/v1/transactions/1', $client->getResponse()->getHeaders('location'));
	}
	public function testRefundNewTransactionAction()
	{
		$transaction = $this->persistFakeTransaction();

		$client = static::createClient();
        $client->request(
        	'PATCH',
        	'/api/v1/transactions/' . $transaction->getId() . '/refund'
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //$this->assertContains('api/v1/transactions/1', $client->getResponse()->getHeaders('location'));
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
