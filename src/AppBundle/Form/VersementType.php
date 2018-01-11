<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VersementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('montant', IntegerType::class, [
            'attr' => array(
                'min'=>0.01,
                'max'=> $options['max'],
                'step' => 0.01
            ) ,
            'label' => "Montant ( max : ".$options['max']."€ )"

        ])->add('date')->add('type', ChoiceType::class, array(
            'choices'  => array(
                'Chèque' => 'Cheque',
                'Virement bancaire' => 'Virement bancaire',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Versement',
            'max' => 1
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_versement';
    }


}
