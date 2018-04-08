<?php
namespace AppBundle\Domain\Transaction\EventListener;

use AppBundle\Domain\Transaction\Event\MarketingReportReady;
use	AppBundle\Domain\Transaction\Responder\SimpleResponder;

class MarketingReportReadyListener
{
	public function __construct(SimpleResponder $responder)
	{
		$this->responder = $responder;
	}
	public function onReportReady(MarketingReportReady $event)
	{
		$this->responder->setData( $event->getMarketingReport() );
	}
}