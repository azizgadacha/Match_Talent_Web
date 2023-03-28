<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReclamationType extends AbstractType
{

    //private ManagerRegistry $doctrine;

    //public function __construct(ManagerRegistry $doctrine)
    //{
        //$this->doctrine = $doctrine;
    //}

    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('titre', TextType::class, [
            'attr' => [
                'placeholder' => 'Titre',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire'
                ])
            ]
        ])
        ->add('type', ChoiceType::class, [
            'choices' => [
                'Security' => 'Security',
                'Accessibility' => 'Accessibility',
                'Content' => 'Content',
            ],
            'placeholder' => 'Séléctionner type',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire'
                ])
            ]
        ])
        ->add('description', TextType::class, [
            'attr' => [
                'placeholder' => 'Description',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire'
                ])
            ]
        ])
        ->add('userReclamation', TextType::class, [
            'required' => true,
            'mapped' => false, // this tells Symfony to ignore this field when mapping form data to the entity
            'attr' => [
                'placeholder' => 'Enter Votre Nom',
            ],
        ]);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
            'users' => [],
        ]);
    }

    
}
