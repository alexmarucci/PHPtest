<?php 
namespace AppBundle\Domain\Api\Handler;

use AppBundle\Entity\Transaction;	
use AppBundle\Entity\Refund;	
use AppBundle\Domain\Api\Action\RefundTransactionAction;
use SimpleBus\Message\Recorder\PublicMessageRecorder as EventRecorder;
use AppBundle\Domain\CommandHandler;
use Doctrine\ORM\EntityManager;
use AppBundle\Domain\Api\Event\TransactionAdded;
use AppBundle\Exception\NotFoundException;

class RefundTransactionHandler extends CommandHandler
{
	private $em;

	public function __construct(EventRecorder $eventRecorder, EntityManager $em)
	{
		parent::__construct($eventRecorder);
		$this->em = $em;
	}

	public function handle(RefundTransactionAction $action)
	{
		$transactionId = $action->getTransactionId();
		$transaction = $this->em->getRepository(Transaction::class)->findOneById( $transactionId );

		if ($transaction instanceof Transaction) {
			$transaction->setRefund(new Refund());
			$this->em->persist($transaction);
			$this->em->flush();
		}
		else throw new NotFoundException("Transaction could not be found", 404);
		
		
	}
}