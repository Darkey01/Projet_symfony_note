<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ProjetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('description')
            ->add('dateOuverture')->add('dateCloture')
           ->add('personnesConcernees', EntityType::class, [
               'class' => 'AppBundle\Entity\Proprietaire',
               'query_builder' => function (EntityRepository $er) use($options) {
                   return $er->createQueryBuilder('p')

                       ->join('p.user', 'u')
                       ->where('u.id != :id')
                       ->setParameter('id' , $options['user'] )
                       ->orderBy('u.username', 'ASC');
               },
               'label' => 'Utilisateurs liés au projet',
               'multiple' => true
           ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Projet',
            'user'=>null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_projet';
    }


}
