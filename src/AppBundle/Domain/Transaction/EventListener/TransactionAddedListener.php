<?php
namespace AppBundle\Domain\Transaction\EventListener;

use AppBundle\Domain\Transaction\Event\TransactionAdded;
use	AppBundle\Domain\Transaction\Responder\SimpleResponder;

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