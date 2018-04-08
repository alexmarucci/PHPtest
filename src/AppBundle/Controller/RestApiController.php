<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use SimpleBus\SymfonyBridge\Bus\CommandBus;

use AppBundle\Entity\Transaction;
use AppBundle\Domain\Transaction\Action\AddTransactionAction;
use AppBundle\Domain\Transaction\Action\RefundTransactionAction;
use AppBundle\Domain\Transaction\Responder\SimpleResponder;
use AppBundle\Service\TransactionValidator;
Use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Exception\TransactionNotValidException;
use AppBundle\Exception\NotFoundException;

class RestApiController extends FOSRestController
{
    private $commandBus;

	public function __construct(CommandBus $commandBus)
	{
        $this->commandBus = $commandBus;
    }

    // [POST] /api/v1/transactions
    public function postTransactionAction(Request $request)
    {
        $validator = $this->get('transaction_validator');
        $payload = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        try {
            $transaction = $validator->validate($payload);
        } catch (TransactionNotValidException $e) {
            return new JsonResponse( $e->getErrors() , $e->getCode());
        }

        $this->commandBus->handle(new AddTransactionAction( $transaction ));
        $transaction = (new SimpleResponder())->respond();

        $response = new RedirectResponse($this->generateUrl('api_get_transactions', 
                ['id' => $transaction->getId()
            ]), 201);
        
        return $response;
    }

    // [GET] /api/v1/transactions/{id}
    public function getTransactionsAction($id){}
    
    // [PATCH] /api/v1/transactions/{id}/refund
    public function refundTransactionsAction($id)
    {
        $id = abs((int) $id);
        try {
            $this->commandBus->handle(new RefundTransactionAction($id));
        } catch (NotFoundException $e) {
            return new JsonResponse($e->getMessage(), $e->getCode());
        }

        return new JsonResponse();
    }
}
	