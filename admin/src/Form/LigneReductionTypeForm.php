<?php

// src/Form/LigneReductionType.php

namespace App\Form;

use App\Entity\Camera;
use App\Entity\LigneReduction;
use App\Entity\Reduction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneReductionTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('camera', EntityType::class, [
                'class' => Camera::class,
                'choice_label' => 'nom', // Choisir le champ à afficher comme label
                'placeholder' => 'Choisir une caméra', // Texte par défaut du champ select
            ])
            ->add('reduction', EntityType::class, [
                'class' => Reduction::class,
                'choice_label' => 'description', // Choisir le champ à afficher comme label
                'placeholder' => 'Choisir une réduction', // Texte par défaut du champ select
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LigneReduction::class,
        ]);
    }
}
