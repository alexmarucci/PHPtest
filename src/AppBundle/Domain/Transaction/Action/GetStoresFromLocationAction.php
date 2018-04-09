<?php
namespace AppBundle\Domain\Transaction\Action;

use AppBundle\Entity\Transaction;
use SimpleBus\Message\Name\NamedMessage;

/**
* 
*/
class GetStoresFromLocationAction implements NamedMessage
{
	private $location;
	
	function __construct($location)
	{
		$this->location = $location;
	}
	/**
	* Get location
	* @return string
	*/
	public function getLocation()
	{
	    return $this->location;
	}

	public static function messageName()
    {
        return 'get_stores_from_location_action';
    }
}