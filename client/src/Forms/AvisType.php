<?php

namespace App\Forms;

use App\Entity\AvisCamera;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('commentaire', TextareaType::class)
        ->add('note', ChoiceType::class, [
            'choices' => [
                '1 start' => '1',
                '2 start' => '2',
                '3 start' => '3',
                '4 start' => '4',
                '5 start' => '5',
            ],
            'expanded' => false,  // Set to true to use radio buttons
            'multiple' => false  // Keep as false for single selection
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AvisCamera::class,
        ]);
    }
}