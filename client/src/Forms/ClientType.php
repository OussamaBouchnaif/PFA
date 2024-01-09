<?php

namespace App\Forms;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->add('nom',TextType::class,[
                'label' => 'First Name',
                ])
            ->add('prenom',TextType::class,['label' => 'Last Name'])
            ->add('email',TextType::class,['label' => 'Email'])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'confirm Password'),
            ))
            ->add('adresse',TextType::class,['label' => 'Address'])
            ->add('phoneNumber',TextType::class,['label' => 'Phone Number'])
            ->add('ville',TextType::class,['label' => 'City'])
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ],
                'label' => 'Genre',// Allow only one selection
            ]);

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}