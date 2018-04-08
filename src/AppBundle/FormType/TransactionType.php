<?php
namespace AppBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Transaction;

class TransactionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => Transaction::class
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transaction_id', Type\IntegerType::class)
			->add('store', EntityType::class, array(
			    'class' => 'AppBundle:Store',
			    'choice_label' => 'id'
			))
			->add('total_amount', Type\NumberType::class)
			->add('currency', Type\TextType::class)
			->add('created_at',  Type\DateTimeType::class, array(
                'widget' => 'single_text',
                'input' => 'datetime'
            ))
		;
    }

    /**
     * This will remove formTypeName from the form
     * @return null
     */
    public function getBlockPrefix() {
        return null;
    }
}