<?php
namespace AppBundle\Domain\Transaction\Event;

use SimpleBus\Message\Name\NamedMessage;
use AppBundle\Report\MarketingReport;

class MarketingReportReady implements NamedMessage
{

	private $marketingReport;

	public function __construct(MarketingReport $marketingReport)
	{
		$this->marketingReport = $marketingReport;
	}
	
	public function getMarketingReport()
	{
		return $this->marketingReport;
	}

    public static function messageName()
    {
        return 'marketing_report_ready_event';
    }
}