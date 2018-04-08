<?php 
namespace AppBundle\Domain\Transaction\Handler;

use AppBundle\Entity\Transaction;	
use AppBundle\Domain\Transaction\Action\AddTransactionAction;
use SimpleBus\Message\Recorder\PublicMessageRecorder as EventRecorder;
use AppBundle\Domain\CommandHandler;
use Doctrine\ORM\EntityManager;
use AppBundle\Domain\Transaction\Event\TransactionAdded;

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
    		$transaction = $transactionRepository->import( $action->getTransaction() );
    		$transaction = $this->em->getRepository(Transaction::class)->findOneById($transaction);
			$this->eventRecorder->record(new TransactionAdded($transaction));
    	} catch (\Exception $e) { }
	}
}