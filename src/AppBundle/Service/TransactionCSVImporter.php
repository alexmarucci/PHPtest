<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use \Doctrine\DBAL\Types\Type as DataType;
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
        	$stmt = $this->prepareQuery( $data );
        	try {
        		$stmt->execute();
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
				if ($key === 'CREATED AT') {
					$value = new \DateTime( $value );
					$data[$key] = $value;
				}
			}
			else throw new \Exception("Parameter missing for ${key} at ${lineNo}", 1);
		}
		return $data;
	}

	private function prepareQuery($data)
	{
		// Use pure SQL as is much more faster
        $sql = "INSERT INTO Transaction(transaction_id, store_id, total_amount, currency, created_at)
                VALUES (:transactionId, :storeId, :totalAmount, :currency, :createdAt)";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue( "transactionId", $data['TRANSACTION ID'] );
        $stmt->bindValue( "storeId", $data['STORE ID'] );
        $stmt->bindValue( "totalAmount", $data['TOTAL AMOUNT'] );
        $stmt->bindValue( "currency", $data['CURRENCY'] );
        $stmt->bindValue( "createdAt", $data['CREATED AT'], DataType::DATETIME );

        return $stmt;
	}
}