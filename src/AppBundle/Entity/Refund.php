<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;

/**
 * Refund
 *
 * @ORM\Table(name="refund")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RefundRepository")
 */
class Refund
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Transaction
     *
     * @ORM\OneToOne(targetEntity="Transaction", mappedBy="refund")
     */
    private $transaction;



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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Refund
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
    * Get transaction
    *
    * @return Transaction 
    */
    public function getTransaction()
    {
        return $this->transaction;
    }
    
    /**
    * Set transaction
    * 
    * @param Transaction $transaction
    *
    * @return $this
    */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
    * Get user
    * @return User 
    */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
    * Set user
    *
    * @param User $user
    *
    * @return $this
    */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
}

