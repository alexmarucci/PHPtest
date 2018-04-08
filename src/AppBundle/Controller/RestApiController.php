<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use SimpleBus\SymfonyBridge\Bus\CommandBus;

use AppBundle\Entity\Transaction;
use AppBundle\Domain\Api\Action\AddTransactionAction;
use AppBundle\Domain\Api\Responder\SimpleResponder;
use AppBundle\Service\TransactionValidator;

class RestApiController extends FOSRestController
{
    private $commandBus;

	public function __construct(CommandBus $commandBus)
	{
        $this->commandBus = $commandBus;
    }

    public function postTransactionAction(Request $request)
    {
        $validator = $this->get('transaction_validator');
        $payload = $request->request->all();

        $em = $this->getDoctrine()->getManager();
        $content = $request->getContent();
        try {
            $transaction = $validator->validate($payload);
        } catch (TransactionNotValidException $e) {
            $errors = $e->getErrors();
        }

        $this->commandBus->handle(new AddTransactionAction( $transaction ));
        $transaction = (new SimpleResponder())->respond();

        $response = new RedirectResponse($this->generateUrl('api_get_transactions', 
                ['id' => $transaction->getId()
            ]), 201);
        
        return $response;
    }

    public function getTransactionsAction($id){}
}
	