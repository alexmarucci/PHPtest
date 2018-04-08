<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RestApiControllerTest extends WebTestCase
{
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
}
