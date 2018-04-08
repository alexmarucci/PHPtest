<?php
namespace AppBundle\Domain\Transaction\Action;

use AppBundle\Entity\Store;
use SimpleBus\Message\Name\NamedMessage;

class GetMarketingReportAction implements NamedMessage
{
	private $transactions;
	
	function __construct($transactions)
	{
		$this->transactions = $transactions;
	}
	/**
	* Get Transactions
	* @return array
	*/
	public function getTransactions()
	{
	    return $this->transactions;
	}

	public static function messageName()
    {
        return 'get_marketing_action';
    }
}