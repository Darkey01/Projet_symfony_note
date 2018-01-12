<?php

namespace AppBundle\Form;

use AppBundle\Form\FilePathToFileTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PieceJointeType extends AbstractType
{
    private $transformer;

    /**
     * PieceJointeType constructor.
     * @param \AppBundle\Form\FilePathToFileTransformer $transformer
     */
    public function __construct(FilePathToFileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isEdit = $options['isEdit'];

        $builder
            ->add('nom')
            ->add('type')
            ->add('chemin', FileType::class, ["label" => "Fichier"]);

        if ($isEdit) {
            $builder->get('filepath')->addModelTransformer($this->transformer);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('isEdit');
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PieceJointe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_piecejointe';
    }


}
