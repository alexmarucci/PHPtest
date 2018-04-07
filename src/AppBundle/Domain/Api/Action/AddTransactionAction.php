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
	* @return array
	*/
	public function getTransactionData() :array
	{
	    return $this->transactionData;
	}
}