<?php 
namespace AppBundle\Domain\Transaction\Handler;

use AppBundle\Entity\Store;
use AppBundle\Domain\Transaction\Action\GetStoresFromLocationAction;
use SimpleBus\Message\Recorder\PublicMessageRecorder as EventRecorder;
use AppBundle\Domain\CommandHandler;
use Doctrine\ORM\EntityManager;
use AppBundle\Domain\Transaction\Event\StoresFromLocationFound;
use AppBundle\Report\MarketingReport;
use Geocoder\Plugin\PluginProvider as GoogleGeocoder;
use Geocoder\Query\GeocodeQuery;


class GetStoresFromLocationHandler extends CommandHandler
{
	private $Ggeocoder;
	private $em;

	public function __construct(EventRecorder $eventRecorder, GoogleGeocoder $Ggeocoder, EntityManager $em)
	{
		parent::__construct($eventRecorder);
		$this->Ggeocoder = $Ggeocoder;
		$this->em = $em;
	}

	public function handle(GetStoresFromLocationAction $action)
	{
		/* fetch data from google geocoding */
		$result = $this->Ggeocoder->geocodeQuery(GeocodeQuery::create( $action->getLocation() ));
		$bounds = $result->first()->getBounds()->toArray();

		/* match stores */
		$matchedStore = $this->locationContaintsStore( $bounds );
		if (false !== $matchedStore) {
			$this->eventRecorder->record(new StoresFromLocationFound($matchedStore));
		}
	}

	private function locationContaintsStore($bounds)
	{
		$stores = $this->em->getRepository(Store::class)->findAll();
		$matchedStore = false;
		foreach ($stores as $store) {
			$match = $this->coordinatesInsideBounds(
				[
					'latitude' => $store->getLatitude(),
					'longitude' => $store->getLongitude()
				],
				$bounds
			);

			if ($match) {
				$matchedStore[] = $store;
			}
		}

		return $matchedStore;
	}

	private function coordinatesInsideBounds($coordinates, $bounds)
	{
		$p = $coordinates['latitude'] + $coordinates['longitude'];
		$sw = $bounds['south'] + $bounds['west'];
		$ne = $bounds['north'] + $bounds['east'];

		return ($p > $sw and $p < $ne);
	}
}