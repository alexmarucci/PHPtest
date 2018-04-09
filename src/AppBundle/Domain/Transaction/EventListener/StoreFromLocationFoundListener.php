<?php
namespace AppBundle\Domain\Transaction\EventListener;

use AppBundle\Domain\Transaction\Event\StoresFromLocationFound;
use	AppBundle\Domain\Transaction\Responder\SimpleResponder;

class StoreFromLocationFoundListener
{
	public function __construct(SimpleResponder $responder)
	{
		$this->responder = $responder;
	}
	public function onStoresForLocationFound(StoresFromLocationFound $event)
	{
		$this->responder->setData( $event->getStores() );
	}
}