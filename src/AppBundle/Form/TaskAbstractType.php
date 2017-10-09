<?php
declare(strict_types=1);

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class TaskAbstractType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name')->add('description', TextareaType::class,
            ['attr' => ['maxlength' => '65535'], 'required' => false])->add('priority', IntegerType::class,
            ['attr' => ['min' => '-3', 'max' => '3']]);
    }



}
