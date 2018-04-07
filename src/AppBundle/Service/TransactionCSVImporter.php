<?php
namespace AppBundle\Service;

use AppBundle\Entity\Transaction;
use Doctrine\ORM\EntityManager;
use ParseCsv\Csv as CSVParser;

class TransactionCSVImporter
{
	private $em;
	private $parser;
	
	public function __construct(CSVParser $parser, EntityManager $em)
	{
		$this->parser = $parser;
		$this->em = $em;
	}

	public function import($file){
		$this->parser->delimiter = ",";
        $this->parser->parse($file);
		$index = 0;
		$totalTransactionImported = 0;
        foreach ($this->parser->data as $line) {
        	$index++;
        	$data = $this->prepareData( $line, $index );
        	$transactionRepository = $this->em->getRepository( Transaction::class );
        	try {
        		$transactionRepository->import( $data );
        		$totalTransactionImported++;
        	} catch (\Exception $e) { }
        }

        return $totalTransactionImported;
	}

	private function prepareData($line, $lineNo)
	{
		$data = array();
		foreach ($line as $key => $value) {
			if (!empty($value)) {
				$data[$key] = $value;
			}
			else throw new \Exception("Parameter missing for ${key} at ${lineNo}", 1);
		}
		return $data;
	}
}