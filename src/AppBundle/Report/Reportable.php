<?php
namespace AppBundle\Report;

use AppBundle\Report\AbstractReport as Report;

abstract class Reportable
{
	abstract function accept(Report $report);
}