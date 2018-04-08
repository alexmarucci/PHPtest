<?php
namespace AppBundle\Service;

use Symfony\Component\Form\Form;
use AppBundle\Entity\Transaction;
use AppBundle\FormType\TransactionType;
use AppBundle\Exception\TransactionNotValidException;
use Doctrine\ORM\EntityManager;
use ParseCsv\Csv as CSVParser;
use Symfony\Component\Form\FormFactory;

class TransactionValidator
{
	const DATE_TIME_FORMAT = 'Y-m-d h:i';
	private $formFactory;

	public function __construct(FormFactory $formFactory)
	{
		$this->formFactory = $formFactory;
	}
	public function validate($data)
	{
		if (array_key_exists('created_at', $data)) {
			$data['created_at'] = (new \DateTime($data['created_at']))->format(self::DATE_TIME_FORMAT);
		}
        $form = $this->formFactory->create(TransactionType::class, new Transaction());
        $form->submit( $data );

        if($form->isValid()){
			return $form->getData();
        } else {
        	$errors = $this->getFormErrors($form);
        	throw new TransactionNotValidException("Error Validating Data." . json_encode($form->getErrors()), 500, null, $errors);
        }
	}

	/** List all errors of a given bound form.
	 *
	 * @param Form $form
	 *
	 * @return array
	 */
	protected function getFormErrors(Form $form)
	{
	    $errors = array();

	    // Global
	    foreach ($form->getErrors() as $error) {
	        $errors[$form->getName()][] = $error->getMessage();
	    }

	    // Fields
	    foreach ($form as $child /** @var Form $child */) {
	        if (!$child->isValid()) {
	            foreach ($child->getErrors() as $error) {
	                $errors[$child->getName()][] = $error->getMessage();
	            }
	        }
	    }

	    return $errors;
	}
}