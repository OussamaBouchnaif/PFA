<?php

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('voucher', TextType::class, ['required' => false,])
            ->add('paiment', ChoiceType::class, [
                'choices' => [
                    'paypal' => 'paypal',
                    'Cartcredit' => 'Cart credit',
                    'Cashondelivery' => 'Cash on delivery',
                ],
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