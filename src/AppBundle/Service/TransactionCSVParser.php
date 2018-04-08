<?php
namespace AppBundle\Service;

use AppBundle\Entity\Transaction;
use AppBundle\Exception\WrongFormatException;
use Doctrine\ORM\EntityManager;
use ParseCsv\Csv as CSVParser;

class TransactionCSVParser
{
	const CSV_HEADER = ['STORE ID','TRANSACTION ID','TOTAL AMOUNT','CURRENCY','CREATED AT'];

	private $em;
	private $parser;
	private $parsedData;

	
	public function __construct(CSVParser $parser, EntityManager $em)
	{
		$this->parser = $parser;
		$this->em = $em;
		$this->parsedData = array();
	}

	public function parse($file){
		$this->parser->delimiter = ",";
        $this->parser->parse($file);
		$index = 0;

        foreach ($this->parser->data as $line) {
        	if ($index === 0) {
        		if (true !== $this->verifyKeys( $line )) {
        			throw new WrongFormatException('Error while parsing the file. ' . $file);
        		}
        	}
        	$index++;
        	$this->parseLine( $line, $index );
        }

        return $this->parsedData;
	}

	private function parseLine($line, $lineNo)
	{
		$parsedLine = [
    		'transaction_id' =>	$line['TRANSACTION ID'],
			'store' 		 =>	$line['STORE ID'],
			'total_amount'	 =>	$line['TOTAL AMOUNT'],
			'currency'		 =>	$line['CURRENCY'],
			'created_at'	 =>	$line['CREATED AT']
        ];

		$this->parsedData[] = $parsedLine;
	}

	private function verifyKeys($line)
	{
		$keys = array_keys($line);
		$missingKeys = array_diff(self::CSV_HEADER, $keys);

		return (0 === count($missingKeys));
	}
}