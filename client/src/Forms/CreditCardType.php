<?php

namespace App\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class)
            ->add('cardNumber', TextType::class)  
            ->add('expirationMonth', NumberType::class)  
            ->add('expirationYear', NumberType::class)  
            ->add('cvv', TextType::class);
    }
}
