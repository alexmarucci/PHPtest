<?php
namespace AppBundle\Report;

use \AppBundle\Entity\Transaction;

abstract class AbstractReport {
    abstract function reportTransaction(Transaction $transaction);
}