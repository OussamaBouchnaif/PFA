<?php

// src/Form/UserType.php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'attr' => ['placeholder' => 'Entrez votre nom'],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer votre nom.']),
            ],
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Prénom',
            'attr' => ['placeholder' => 'Entrez votre prénom'],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer votre prénom.']),
            ],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'attr' => ['placeholder' => 'Entrez votre email'],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer votre email.']),
                new Email(['message' => 'Veuillez entrer une adresse email valide.']),
            ],
        ])
        ->add('ville', TextType::class, [
            'label' => 'Ville',
            'attr' => ['placeholder' => 'Entrez votre ville'],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer votre ville.']),
            ],
        ])
        ->add('imageFile', VichImageType::class, [
            'required' => false,
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe doivent correspondre.',
            'required' => true,
            'first_options' => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmer le mot de passe'],
        ])
        ->add('phoneNumber', TextType::class, [
            'label' => 'Téléphone',
            'attr' => ['placeholder' => 'Entrez votre numéro de téléphone'],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer votre numéro de téléphone.']),
            ],
        ])
        ->add('genre', ChoiceType::class, [
            'label' => 'Genre',
            'choices' => [
                'Femme' => 'Femme',
                'Homme' => 'Homme',
            ],
            'placeholder' => 'Sélectionnez votre genre',
            'constraints' => [
                new NotBlank(['message' => 'Veuillez sélectionner votre genre.']),
            ],
        ])
        // ->add('save', SubmitType::class, ['label' => 'Ajouter'])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
