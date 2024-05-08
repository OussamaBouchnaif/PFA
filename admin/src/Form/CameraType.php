<?php

namespace App\Form;

use App\Entity\Camera;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CameraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom de la caméra'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la description de la caméra'
                ]
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le prix de la caméra'
                ]
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le stock de la caméra'
                ]
            ])
            ->add('dateAjout', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'mt-2']
            ])
            ->add('status', TextType::class, [
                'label' => 'Statut',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le statut de la caméra'
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Sélectionnez une catégorie'
                ]
            ])
            ->add('visionNoctrune', ChoiceType::class, [
                'label' => 'Vision Nocturne',
                'choices' => ['Oui' => true, 'Non' => false],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Sélectionnez la disponibilité de la vision nocturne'
                ]
            ])
            ->add('materiaux', ChoiceType::class, [
                'label' => 'Matériaux',
                'choices' =>  [
                    'Plastique' => 'plastique',
                    'Métal' => 'métal',
                    'Autre' => 'autre',
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('resolution', ChoiceType::class, [
                'label' => 'Résolution',
                'choices' =>  [
                    'Haute' => 'haute',
                    'Moyenne' => 'moyenne',
                    'Basse' => 'basse',
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('angleVision', ChoiceType::class, [
                'label' => 'Angle de Vision',
                'choices' =>  [
                    'Large' => 'large',
                    'Moyen' => 'moyen',
                    'Étroit' => 'étroit',
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('connectivite', ChoiceType::class, [
                'label' => 'Connectivité',
                'choices' =>  [
                    'Wi-Fi' => 'wi-fi',
                    'Bluetooth' => 'bluetooth',
                    'USB' => 'usb',
                    'Aucune' => 'aucune',
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('alimentation', ChoiceType::class, [
                'label' => 'Alimentation',
                'choices' => [
                    'Piles' => 'piles',
                    'Batterie' => 'batterie',
                    'Solaire' => 'solaire',
                    'Prise électrique' => 'prise',
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('stockage', IntegerType::class, [
                'label' => 'Stockage',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la capacité de stockage'
                ]
            ])
            ->add('couleur', TextType::class, [
                'label' => 'Couleur',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la couleur'
                ]
            ])
            ->add('poids', IntegerType::class, [
                'label' => 'Poids',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le poids'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Camera::class,
        ]);
    }
}
