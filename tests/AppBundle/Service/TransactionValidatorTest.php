<?php
namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Transaction;
use AppBundle\Exception\TransactionNotValidException;

class TransactionValidatorTest extends KernelTestCase
{
    /**
    * {@inheritDoc}
    */
    protected function setUp()
    {
        self::bootKernel();
    }

    public function testValidateData()
    {
    	$payload = [
    		'transaction_id' => 1,
			'store' => 1,
			'total_amount' => 1,
			'currency' => 'GBP',
			'created_at' => '2019-10-10 12:12'
        ];

        $transactionValidator = static::$kernel->getContainer()->get('transaction_validator');
        $transaction = $transactionValidator->validate( $payload );
        
        $this->assertInstanceOf(Transaction::class, $transaction );
        $this->assertEquals($payload['transaction_id'], $transaction->getTransactionId() );
		$this->assertEquals($payload['store'], $transaction->getStore()->getId() );
		$this->assertEquals($payload['total_amount'], $transaction->getTotalAmount() );
		$this->assertEquals($payload['currency'], $transaction->getCurrency() );
		$this->assertEquals($payload['created_at'], $transaction->getCreatedAt()->format($transactionValidator::DATE_TIME_FORMAT) );
    }
    public function testPayloadNotValidException()
    {
        $this->expectException(TransactionNotValidException::class);

        $payload = [
            'transaction_id' => 1,
            'store' => 7,
            'total_amount' => 1,
            'currency' => 'GBP',
            'created_at' => '2019-10-10 12:12'
        ];

        $transactionValidator = static::$kernel->getContainer()->get('transaction_validator');
        $transaction = $transactionValidator->validate( $payload );
    }

    public function testPayloadNotValidErrors()
    {

        $payload = [
            'transaction_id' => 1,
            'store' => 7,
            'total_amount' => 1,
            'currency' => 'GBP',
            'created_at' => '2019-10-10 12:12'
        ];
        $expectedErrors = [
          "store" => [ 0 => "This value is not valid." ]
        ];

        $transactionValidator = static::$kernel->getContainer()->get('transaction_validator');
        try {
            $transaction = $transactionValidator->validate( $payload );
            $this->assertTrue(false);
        } catch (TransactionNotValidException $e) {
            $errors = $e->getErrors();
            $this->assertEquals($expectedErrors, $errors);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}