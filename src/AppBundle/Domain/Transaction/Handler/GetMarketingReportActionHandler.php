<?php 
namespace AppBundle\Domain\Transaction\Handler;

use AppBundle\Entity\Transaction;	
use AppBundle\Domain\Transaction\Action\GetMarketingReportAction;
use SimpleBus\Message\Recorder\PublicMessageRecorder as EventRecorder;
use AppBundle\Domain\CommandHandler;
use Doctrine\ORM\EntityManager;
use AppBundle\Domain\Transaction\Event\MarketingReportReady;
use AppBundle\Report\MarketingReport;

class GetMarketingReportActionHandler extends CommandHandler
{
	private $em;

	public function __construct(EventRecorder $eventRecorder, EntityManager $em)
	{
		parent::__construct($eventRecorder);
		$this->em = $em;
	}

	public function handle(GetMarketingReportAction $action)
	{
		$transactions = $action->getTransactions();
		$marketingReport = new MarketingReport();
		foreach ($transactions as $transaction) {
			$transaction->accept( $marketingReport );
		}
		
		$this->eventRecorder->record(new MarketingReportReady($marketingReport));
	}
}