<?php 
namespace AppBundle\Domain\Api\Handler;

use AppBundle\Entity\Transaction;	
use AppBundle\Domain\Api\Action\AddTransactionAction;
use Doctrine\ORM\EntityManager;

class AddTransactionHandler
{
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function handle(AddTransactionAction $action)
	{
		$transactionRepository = $this->em->getRepository( Transaction::class );
    	try {
    		$transactionRepository->import( $action->getTransactionData() );
    	} catch (\Exception $e) { }
	}
}