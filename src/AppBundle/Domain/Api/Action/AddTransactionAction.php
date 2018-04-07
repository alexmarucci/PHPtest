<?php
namespace AppBundle\Domain\Api\Action;

use AppBundle\Entity\Transaction;

/**
* 
*/
class AddTransactionAction
{
	private $transactionData;
	
	function __construct(array $transactionData)
	{
		$this->transactionData = $transactionData;
	}
	/**
	* Get transactionData
	* @return Transaction
	*/
	public function getTransaction() :Transaction
	{
	    return $this->transactionData;
	}
}