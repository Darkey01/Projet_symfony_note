<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class ChargeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('montant')->add('dateEcheance',DateType::class,['label' => 'Date d\'échéance'])->add('proprietaires', EntityType::class, [
            'class' => 'AppBundle\Entity\Proprietaire',
            'query_builder' => function (EntityRepository $er) use($options) {
                return $er->createQueryBuilder('p')
                    ->join('p.user', 'u')
                    ->orderBy('u.username', 'ASC');
            },
            'label' => 'Utilisateur autorisé à voir',
            'multiple' => true
        ])->add('pieceJointe', FileType::class,[
            'required' => false
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Charge'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_charge';
    }


}
