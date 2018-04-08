<?php
namespace AppBundle\Domain\Transaction\Action;

use AppBundle\Entity\Transaction;
use SimpleBus\Message\Name\NamedMessage;

/**
* 
*/
class RefundTransactionAction implements NamedMessage
{
	private $transactionId;
	
	function __construct($transactionId)
	{
		$this->transactionId = $transactionId;
	}
	/**
	* Get transactionId
	* @return array
	*/
	public function getTransactionId()
	{
	    return $this->transactionId;
	}

	public static function messageName()
    {
        return 'refund_transaction_action';
    }
}