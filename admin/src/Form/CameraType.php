<?php

namespace App\Form;

use App\Entity\Camera;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThan;
class CameraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom de la caméra',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la description de la caméra',
                ],
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le prix de la caméra',
                ],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Le prix doit être supérieur ou égal à {{ compared_value }}.',
                    ]),
                ],
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le stock de la caméra',
                ],
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Le stock doit être supérieur à zéro.',
                    ]),
                ],
            ])
            ->add('dateAjout', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'mt-2 form-control',
                    'placeholder' => 'Sélectionnez la date d\'ajout',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisissez le statut de la caméra',
                'choices' => [
                    'En stock' => 'en_stock',
                    'En rupture de stock' => 'rupture_de_stock',
                    'En commande' => 'en_commande',
                    'Autre' => 'autre',
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Sélectionnez une catégorie',
                ],
            ])
            ->add('visionNoctrune', ChoiceType::class, [
                'label' => 'Vision Nocturne',
                'choices' => ['Oui' => true, 'Non' => false],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Sélectionnez la disponibilité de la vision nocturne',
                ],
            ])
            ->add('materiaux', ChoiceType::class, [
                'label' => 'Matériaux',
                'choices' => [
                    'Plastique' => 'plastique',
                    'Métal' => 'métal',
                    'Autre' => 'autre',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisissez materiaux',

            ])
            ->add('resolution', ChoiceType::class, [
                'label' => 'Résolution',
                'choices' => [
                    'Haute' => 'haute',
                    'Moyenne' => 'moyenne',
                    'Basse' => 'basse',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisissez la résolution',
            ])
            ->add('angleVision', ChoiceType::class, [
                'label' => 'Angle de Vision',
                'choices' => [
                    'Large' => 'large',
                    'Moyen' => 'moyen',
                    'Étroit' => 'étroit',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisissez l\'angle de vision',
            ])
            ->add('connectivite', ChoiceType::class, [
                'label' => 'Connectivité',
                'choices' => [
                    'Wi-Fi' => 'wi-fi',
                    'Bluetooth' => 'bluetooth',
                    'USB' => 'usb',
                    'Aucune' => 'aucune',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisissez le type de connectivité',
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
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisissez le type d\'alimentation',
            ])
            ->add('stockage', TextType::class, [
                'label' => 'Stockage',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la capacité de stockage',
                ],
                'help' => 'Entrez la capacité de stockage en gigaoctets (GB)',
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Le stockage doit être supérieur à 0.',
                    ]),
                ],
            ])
            ->add('couleur', ChoiceType::class, [
                'label' => 'Couleur',
                'required' => true, // ou false selon vos besoins
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisissez ou entrez la couleur',
                'choices' => [
                    'Noir' => 'Noir',
                    'Blanc' => 'Blanc',
                    'Argent' => 'Argent',
                    'Gris' => 'Gris',
                    'Bleu' => 'Bleu',
                    'Rouge' => 'Rouge',
                    'Vert' => 'Vert',
                    'Jaune' => 'Jaune',
                    'Rose' => 'Rose',
                    'Or' => 'Or',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('poids', IntegerType::class, [
                'label' => 'Poids',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le poids',
                ],
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Le poids doit être supérieur à 0.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Camera::class,
        ]);
    }
}
