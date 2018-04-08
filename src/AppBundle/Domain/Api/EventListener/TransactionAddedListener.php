<?php
namespace AppBundle\Domain\Api\EventListener;

use AppBundle\Domain\Api\Event\TransactionAdded;
use	AppBundle\Domain\Api\Responder\SimpleResponder;

class TransactionAddedListener
{
	public function __construct(SimpleResponder $responder)
	{
		$this->responder = $responder;
	}
	public function onTransactionAdded(TransactionAdded $event)
	{
		$this->responder->setData( $event->getTransaction() );
	}
}