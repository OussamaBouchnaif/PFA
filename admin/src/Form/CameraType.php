<?php
namespace App\Form;

use App\Entity\Camera;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
                    'placeholder' => 'Sélectionner une date', 
                ],
                'widget' => 'single_text', 
                'html5' => false, 
                'format' => 'yyyy-MM-dd', 
            ])
            ->add('status', TextType::class, ['label' => 'Statut', 'required' => false, 'attr' => ['class' => 'form-control']])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class, 
                'choice_label' => 'nom',
                'label' => 'Catégorie', 
                'attr' => ['class' => 'form-control'], 
            ])
            ->add('couleur', TextType::class, ['label' => 'Couleur', 'attr' => ['class' => 'form-control']])
            ->add('visionNoctrune', ChoiceType::class, ['label' => 'Vision Nocturne', 'choices' => ['Oui' => true, 'Non' => false], 'attr' => ['class' => 'form-control']])
            ->add('poids', TextType::class, ['label' => 'Poids', 'attr' => ['class' => 'form-control']])
            ->add('materiaux', TextType::class, ['label' => 'Matériaux', 'attr' => ['class' => 'form-control']])
            ->add('resolution', TextType::class, ['label' => 'Résolution', 'attr' => ['class' => 'form-control']])
            ->add('angleVision', TextType::class, ['label' => 'Angle de Vision', 'attr' => ['class' => 'form-control']])
            ->add('connectivite', ChoiceType::class, ['label' => 'Connectivité', 'choices' => ['Oui' => true, 'Non' => false], 'attr' => ['class' => 'form-control']])
            ->add('stockage', TextType::class, ['label' => 'Stockage', 'attr' => ['class' => 'form-control']])
            ->add('alimentation', TextType::class, ['label' => 'Alimentation', 'attr' => ['class' => 'form-control']])
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Camera::class,
        ]);
    }
}
