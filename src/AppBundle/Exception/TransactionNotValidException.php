<?php
namespace AppBundle\Exception;

class TransactionNotValidException extends \Exception
{
	protected $errors;

    public function __construct($message, $code = 0, Exception $previous = null, $errors) {
    	$this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    public function setErrors($errors)
    {
    	$this->errors = $errors; 
    }
    public function getErrors() {
        return $this->errors;
    }
}