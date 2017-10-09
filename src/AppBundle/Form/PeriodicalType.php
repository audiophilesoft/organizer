<?php

namespace AppBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodicalType extends TaskAbstractType
{
    use HasLastDoneFieldTypeTrait;
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::{__FUNCTION__}(...func_get_args());
        $builder->add('period')->add('last_done');
        $this->addFields(...func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Periodical'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_periodical';
    }


}
