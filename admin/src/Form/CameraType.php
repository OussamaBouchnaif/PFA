<?php

namespace App\Form;
// src/Form/CameraType.php

namespace App\Form;

use App\Entity\Camera;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CameraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom', 'attr' => ['class' => 'form-control']])
            ->add('description', TextareaType::class, ['label' => 'Description', 'attr' => ['class' => 'form-control']])
            ->add('prix', MoneyType::class, ['label' => 'Prix', 'attr' => ['class' => 'form-control']])
            ->add('stock', IntegerType::class, ['label' => 'Stock', 'attr' => ['class' => 'form-control']])
->add('dateAjout', DateType::class, [
    'label' => 'Date Ajout',
    'attr' => [
        'class' => 'form-control',
        'placeholder' => 'Sélectionner une date', // Ajouter un placeholder
        'min' => '2022-01-01', // Définir une date minimale autorisée
        'max' => '2024-12-31', // Définir une date maximale autorisée
    ],
    'widget' => 'single_text', // Utiliser le widget de sélection de date unique
    'html5' => false, // Désactiver le rendu HTML5 natif
    'format' => 'yyyy-MM-dd', // Format de la date affichée
])            ->add('status', TextType::class, ['label' => 'Statut', 'required' => false, 'attr' => ['class' => 'form-control']])
            ->add('categorie', null, ['label' => 'Catégorie', 'attr' => ['class' => 'form-control']]) // Assuming that you have a Category entity
            ->add('valider', SubmitType::class, ['label' => 'Valider', 'attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Camera::class,
        ]);
    }
}
