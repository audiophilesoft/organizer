<?php
declare(strict_types=1);

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

trait HasLengthFieldTypeTrait
{
    protected function addFields(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('length');
    }

}
