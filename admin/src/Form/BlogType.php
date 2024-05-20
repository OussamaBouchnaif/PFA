<?php

// src/Form/BlogType.php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Camera;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le title de blog',
                ],
                ])
            ->add('contenu', TextareaType::class, ['label' => 'Contenu'])
           
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
                'label' => 'Utilisateur',
                'placeholder' => 'Sélectionnez un utilisateur', // Ajoutez cette ligne
            ])
            
            ->add('Camera', EntityType::class, [
                'class' => Camera::class,
                'choice_label' => 'nom',
                'label' => 'Cameras',
                'multiple' => true, // Permettre la sélection de plusieurs caméras
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
