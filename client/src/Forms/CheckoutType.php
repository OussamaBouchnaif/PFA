<?php

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('voucher', TextType::class, ['required' => false,])
            ->add('payment', ChoiceType::class, [
                'choices' => [
                    'PayPal' => 'paypal',
                    'Credit Card' => 'credit_card'
                ],
                'expanded' => true,  // Set to true to use radio buttons
                'multiple' => false  // Keep as false for single selection
            ])
            ->add('placeOrder', SubmitType::class, ['label' => 'Place order'])
            ->add('applyVoucher', SubmitType::class, ['label' => 'Apply coupon']);

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}