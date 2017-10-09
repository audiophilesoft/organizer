<?php
declare(strict_types=1);

namespace AppBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends TaskAbstractType
{
    use HasLengthFieldTypeTrait, HasDoneFieldTypeTrait {
        HasLengthFieldTypeTrait::addFields insteadof HasDoneFieldTypeTrait;
        HasLengthFieldTypeTrait::addFields as addLengthedFields;
        HasDoneFieldTypeTrait::addFields as addDoneFields;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::{__FUNCTION__}(...func_get_args());
        $builder->add('datetime', DateTimeType::class, ['data' => new \DateTime('tomorrows noon')]);
        $this->addLengthedFields(...func_get_args());
        $this->addDoneFields(...func_get_args());
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_event';
    }


}
