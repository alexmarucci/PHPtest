<?php
namespace AppBundle\Report;

use AppBundle\Report\AbstractReport as Report;
use AppBundle\Entity\Transaction;

class MarketingReport extends Report
{
	private $totalNumberOfTransactions;
	private $dailyRevenue;
	private $store;

	public function __construct()
	{
		$this->totalNumberOfTransactions = 0;
		$this->dailyRevenue = 0;
	}

	public function reportTransaction(Transaction $transaction){
		if ($this->store === null) {
			$this->store = $transaction->getStore();
		}
		$this->totalNumberOfTransactions++;
		$this->dailyRevenue += $transaction->getTotalAmount();
	}

	public function toArray()
	{
		return array(
			'store_id' => $this->store->getId(),
            'store_name' => $this->store->getName(),
            'report' => [
                'total_transactions' => $this->totalNumberOfTransactions,
                'revenue' => $this->dailyRevenue
            ]
		);
	}
}