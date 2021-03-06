<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Transaction;
use \Doctrine\DBAL\Types\Type as DataType;

/**
 * TransactionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TransactionRepository extends \Doctrine\ORM\EntityRepository
{
	public function import(Transaction $transaction)
	{
		// Use pure SQL as is much more faster
        $sql = "INSERT INTO Transaction(transaction_id, store_id, total_amount, currency, created_at)
                VALUES (:transactionId, :storeId, :totalAmount, :currency, :createdAt)";
        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        
        $stmt->bindValue( "transactionId", $transaction->getTransactionId() );
        $stmt->bindValue( "storeId", $transaction->getStore()->getId() );
        $stmt->bindValue( "totalAmount", $transaction->getTotalAmount() );
        $stmt->bindValue( "currency", $transaction->getCurrency() );
        $stmt->bindValue( "createdAt", $transaction->getCreatedAt(), DataType::DATETIME );

        $stmt->execute();
        return $connection->lastInsertId();
	}
}
