<?php
declare(strict_types=1);

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DailyTaskType extends TaskAbstractType
{
    use HasLengthFieldTypeTrait, HasLastDoneFieldTypeTrait {
        HasLengthFieldTypeTrait::addFields insteadof HasLastDoneFieldTypeTrait;
        HasLengthFieldTypeTrait::addFields as addLengthField;
        HasLastDoneFieldTypeTrait::addFields as addDoneField;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::{__FUNCTION__}(...func_get_args());
        $builder->add('weekday', ChoiceType::class, [
            //'strict' => true,
            'choices' => [
                'Sunday' => 'Sunday',
                'Monday' => 'Monday',
                'Tuesday' => 'Tuesday',
                'Wednesday' => 'Wednesday',
                'Thursday' => 'Thursday',
                'Friday' => 'Friday',
                'Saturday' => 'Saturday',
                'all' => 'all',
                'workday' => 'workday',
                'day_off' => 'day_off'
            ]
        ])->add('time');
        $this->addLengthField(...func_get_args());
        $this->addDoneField(...func_get_args());
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DailyTask'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_dailytask';
    }


}
