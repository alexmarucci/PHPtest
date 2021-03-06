<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Transaction;

/**
 * Store
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StoreRepository")
 * @ORM\Table(name="store")
 */
class Store
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=30)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=30)
     */
    private $longitude;

     /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="store")
     */
     private $transactions;

     public function __construct()
     {
         $this->transactions = new ArrayCollection();
     }

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
     * Get id
     *
     * @return int
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Store
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Store
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Store
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
    * Get transactions
    * @return ArrayCollection
    */
    public function getTransactions()
    {
        return $this->transactions;
    }
    
    /**
    * Set transactions
    *
    * @param Transaction $transaction
    *
    * @return $this
    */
    public function addTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }
    /**
    * Get latitude
    * @return  
    */
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    /**
    * Set latitude
    * @return $this
    */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
    * Get longitude
    * @return  
    */
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    /**
    * Set longitude
    * @return $this
    */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }
}

