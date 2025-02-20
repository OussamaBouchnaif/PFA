<?php

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
        ->add('id', HiddenType::class, [
            
        ])
        ->add('delete', SubmitType::class, [
            'label' => '<i class="ion-android-close"></i>',
            'attr' => ['class' => 'btn btn-danger'],
            'label_html' => true,  
        ])
        ->add('update', SubmitType::class, [
            'label' => '<i class="icon-refresh"></i>',
            'attr' => ['class' => 'btn btn-warning']  ,
            'label_html' => true,
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}