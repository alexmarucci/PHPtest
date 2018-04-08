<?php
namespace AppBundle\Domain\Api\Action;

use AppBundle\Entity\Transaction;
use SimpleBus\Message\Name\NamedMessage;

/**
* 
*/
class AddTransactionAction implements NamedMessage
{
	private $transactionData;
	
	function __construct(array $transactionData)
	{
		$this->transactionData = $transactionData;
	}
	/**
	* Get transactionData
	* @return array
	*/
	public function getTransactionData() :array
	{
	    return $this->transactionData;
	}

	public static function messageName()
    {
        return 'add_transaction_action';
    }
}