<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class BuyProductType extends ProductType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('amount', IntegerType::class, [
            'constraints' => [new NotBlank(), new Positive()]
        ]);
    }
}
