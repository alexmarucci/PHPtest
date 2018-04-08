<?php
namespace AppBundle\Domain\Api\Action;

use AppBundle\Entity\Transaction;
use SimpleBus\Message\Name\NamedMessage;

/**
* 
*/
class AddTransactionAction implements NamedMessage
{
	private $transaction;
	
	function __construct(Transaction $transaction)
	{
		$this->transaction = $transaction;
	}
	/**
	* Get transaction
	* @return array
	*/
	public function getTransaction() :Transaction
	{
	    return $this->transaction;
	}

	public static function messageName()
    {
        return 'add_transaction_action';
    }
}