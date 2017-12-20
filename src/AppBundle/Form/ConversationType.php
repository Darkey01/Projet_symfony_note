<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConversationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('titre')->add('personnes', EntityType::class, [
            'class' => 'AppBundle\Entity\Proprietaire',
            'query_builder' => function (EntityRepository $er) use($options) {
                return $er->createQueryBuilder('p')

                    ->join('p.user', 'u')
                    ->where('u.id != :id')
                    ->setParameter('id' , $options['user'] )
                    ->orderBy('u.username', 'ASC');

            },
            'label' => 'Utilisateur autorisé à voir',
            'multiple' => true
        ]);
    }



    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Conversation',
            'user'=>null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_conversation';
    }


}
