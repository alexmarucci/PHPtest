<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Store;
use AppBundle\Entity\Refund;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="transaction_id", type="integer", nullable=true)
     */
    private $transactionId;

    /**
     * @var float
     *
     * @ORM\Column(name="total_amount", type="float")
     */
    private $totalAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=5)
     */
    private $currency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var Store
     *
     * @ORM\ManyToOne(targetEntity="Store", inversedBy="transactions")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     */
    private $store;

    /**
     * @var Refund
     *
     * @ORM\OneToOne(targetEntity="Refund", inversedBy="transaction")
     * @ORM\JoinColumn(name="refund_id", referencedColumnName="id", nullable=true)
     */
    private $refund;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set totalAmount
     *
     * @param float $totalAmount
     *
     * @return Transaction
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Transaction
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Transaction
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
    * Get store
    * @return Store 
    */
    public function getStore()
    {
        return $this->store;
    }
    
    /**
    * Set store
    *
    * @param Store $store
    *
    * @return $this
    */
    public function setStore(Store $store)
    {
        $this->store = $store;
        return $this;
    }

    /**
    * Get refund
    * @return Refund
    */
    public function getRefund()
    {
        return $this->refund;
    }
    
    /**
    * Set refund
    *
    * @param Refund $refund
    *
    * @return $this
    */
    public function setRefund(Refund $refund)
    {
        $this->refund = $refund;
        return $this;
    }

    /**
    * Get transactionId
    * @return  integer | null
    */
    public function getTransactionId()
    {
        return $this->transactionId;
    }
    
    /**
    * Set transactionId
    * @return $this
    */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
        return $this;
    }
}

