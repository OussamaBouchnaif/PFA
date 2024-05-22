<?php

namespace App\Form;

use App\Entity\Reduction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('description', TextType::class, [
            'label' => 'Description',
            'attr' => ['placeholder' => 'Entrez la description'],
        ])
        ->add('poucentage', IntegerType::class, [
            'label' => 'Pourcentage',
            'attr' => ['placeholder' => 'Entrez le pourcentage'],
        ])
        ->add('dateDebut', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'mt-2', 'placeholder' => 'Sélectionnez la date de début'],
            'label' => 'Date de début',
        ])
        ->add('dateFin', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'mt-2', 'placeholder' => 'Sélectionnez la date de fin'],
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
