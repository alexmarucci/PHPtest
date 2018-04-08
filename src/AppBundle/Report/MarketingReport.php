<?php
namespace AppBundle\Report;

use AppBundle\Report\AbstractReport as Report;
use AppBundle\Entity\Transaction;

class MarketingReport extends Report
{
	private $totalNumberOfTransactions;
	private $dailyRevenue;

	public function __construct()
	{
		$this->totalNumberOfTransactions = 0;
		$this->dailyRevenue = 0;
	}

	public function reportTransaction(Transaction $transaction){
		$this->totalNumberOfTransactions++;
		$this->dailyRevenue += $transaction->getTotalAmount();
	}
}