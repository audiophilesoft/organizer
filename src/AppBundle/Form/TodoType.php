<?php

namespace AppBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends TaskAbstractType
{
    use HasDoneFieldTypeTrait;


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::{__FUNCTION__}(...func_get_args());
        $builder->add('date', DateType::class, ['data' => new \DateTime('tomorrow')]);
        $this->addFields(...func_get_args());
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Todo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_todo';
    }


}
