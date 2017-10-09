<?php
declare(strict_types=1);

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

trait HasDoneFieldTypeTrait
{
    protected function addFields(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('done');
    }

}
