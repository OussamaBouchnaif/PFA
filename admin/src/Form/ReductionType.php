<?php
// src/Form/ReductionType.php

namespace App\Form;

use App\Entity\Reduction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ReductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('poucentage', IntegerType::class, [
               
                'label' => 'Pourcentage',
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text', // Utiliser un champ de texte avec icône de calendrier
                'attr' => ['class' => 'mt-2'],
                'label' => 'Date de début',
            ])
            ->add('dateFin', DateType::class, [ 
                'widget' => 'single_text', // Utiliser un champ de texte avec icône de calendrier
                'attr' => ['class' => 'mt-2'],
                'label' => 'Date de fin',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reduction::class,
        ]);
    }
}
