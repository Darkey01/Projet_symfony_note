<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, ['label' => 'Username'])->add('email', EmailType::class)->add('password', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('roles', ChoiceType::class, array(
                    'choices' => array(
                        'Proprietaire' => 'ROLE_PROPRIETAIRE',
                        'Admin' => 'ROLE_ADMIN',
                    ),
                )
            );
    }

    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
