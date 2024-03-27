<?php

namespace App\Forms;

use App\Entity\CartItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CartItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('quantity', NumberType::class, [
            'label' => 'Montant',
            'scale' => 2,
            'html5' => true,
            'required' => true,
        ])
        ->add('stockage', ChoiceType::class, [

            'choices' => [
                '100G' => '100G',
                '200G' => '200G',
                '500G' => '500G',
                '1000G' => '1000G',
            ],
            'label' => 'Genre',// Allow only one selection
        ]);;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CartItem::class,
        ]);
    }
}