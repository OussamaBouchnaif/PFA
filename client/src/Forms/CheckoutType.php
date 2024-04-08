<?php

namespace App\Forms;

use App\Entity\Cart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            
        ->add('paiment', ChoiceType::class, [
            'choices'  => [
                'paypal' => 'paypal',
                'Cartcredit' => 'Cart credit',
                'Cashondelivery' => 'Cash on delivery',
            ],
           
        ]);

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}