<?php

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
        ->add('delete', SubmitType::class, ['label' => 'delete'])
        ->add('update', SubmitType::class, ['label' => 'update']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}