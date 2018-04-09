<?php
namespace AppBundle\Domain\Transaction\Event;

use SimpleBus\Message\Name\NamedMessage;

class StoresFromLocationFound implements NamedMessage
{
	private $stores;

	public function __construct($stores)
	{
		$this->stores = $stores;
	}
	/**
	* Get stores
	* @return  
	*/
	public function getStores()
	{
	    return $this->stores;
	}

    public static function messageName()
    {
        return 'stores_from_location_found_event';
    }
}