<?php

namespace App\Form;

use App\Constants\PaymentProcessors;
use App\Validator\Constraint\TaxNumberConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

abstract class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', IntegerType::class, [
                'constraints' => [new NotBlank(), new Positive()]
            ])
            ->add('taxNumber', TextType::class, [
                'constraints' => [new NotBlank(), new Length(min: 11, max: 13), new TaxNumberConstraint()]
            ])
            ->add('paymentProcessor', ChoiceType::class, [
                'choices' => PaymentProcessors::getPaymentChoices(),
                'constraints' => [new NotBlank()]
            ])
            ->add('couponCode', TextType::class)
        ;
    }
}
