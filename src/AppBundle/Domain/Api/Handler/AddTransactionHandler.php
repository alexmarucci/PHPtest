<?php 
namespace AppBundle\Domain\Api\Handler;

use AppBundle\Entity\Transaction;	
use AppBundle\Domain\Api\Action\AddTransactionAction;
use SimpleBus\Message\Recorder\PublicMessageRecorder as EventRecorder;
use AppBundle\Domain\CommandHandler;
use Doctrine\ORM\EntityManager;
use AppBundle\Domain\Api\Event\TransactionAdded;

class AddTransactionHandler extends CommandHandler
{
	private $em;

	public function __construct(EventRecorder $eventRecorder, EntityManager $em)
	{
		parent::__construct($eventRecorder);
		$this->em = $em;
	}

	public function handle(AddTransactionAction $action)
	{
		$transactionRepository = $this->em->getRepository( Transaction::class );

    	try {
    		$transaction = $transactionRepository->import( $action->getTransactionData() );
    		$transaction = $this->em->getRepository(Transaction::class)->findOneById($transaction);
			$this->eventRecorder->record(new TransactionAdded($transaction));
    	} catch (\Exception $e) { }
	}
}