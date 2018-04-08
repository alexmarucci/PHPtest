<?php
namespace AppBundle\Domain\Transaction\Event;

use SimpleBus\Message\Name\NamedMessage;
use AppBundle\Entity\Transaction;

class TransactionAdded implements NamedMessage
{
	private $transaction;

	public function __construct(Transaction $transaction)
	{
		$this->transaction = $transaction;
	}
	/**
	* Get transaction
	* @return  
	*/
	public function getTransaction()
	{
	    return $this->transaction;
	}

    public static function messageName()
    {
        return 'transaction_added_event';
    }
}