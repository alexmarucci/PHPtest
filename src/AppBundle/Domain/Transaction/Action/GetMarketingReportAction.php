<?php
namespace AppBundle\Domain\Transaction\Action;

use AppBundle\Entity\Store;
use SimpleBus\Message\Name\NamedMessage;

class GetMarketingReportAction implements NamedMessage
{
	private $store;
	
	function __construct(Store $store)
	{
		$this->store = $store;
	}
	/**
	* Get store
	* @return array
	*/
	public function getStore() :Store
	{
	    return $this->store;
	}

	public static function messageName()
    {
        return 'get_marketing_action';
    }
}