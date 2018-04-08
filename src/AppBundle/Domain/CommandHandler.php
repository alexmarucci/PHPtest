<?php
namespace AppBundle\Domain;

use SimpleBus\Message\Recorder\PublicMessageRecorder as EventRecorder;
use AppBundle\Domain\Command;

abstract class CommandHandler
{
	protected $eventRecorder;

	function __construct(EventRecorder $eventRecorder){
		$this->eventRecorder = $eventRecorder;
	}
}