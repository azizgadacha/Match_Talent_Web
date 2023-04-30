<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AnnonceType extends AbstractType
{
    private $utilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', null, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire'
                ])
            ]
        ])
        ->add('Societe', null, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire'
                ])
            ]
        ])
        ->add('description', null, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire'
                ])
            ]
        ])
        ->add('typeContrat', null, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est obligatoire'
                ])
            ]
        ])
           // ->add('Societe')
       //     ->add('datedebut')
        //    ->add('datefin')

           ->add('datedebut', DateType::class, [
               'widget' => 'single_text',
               'constraints' => [
                   new NotBlank([
                       'message' => 'Ce champ est obligatoire'
                   ]),
                 //  new FutureDate()
               ]
           ])

            ->add('datefin', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire'
                    ]),
                 //   new FutureDate()
                ]
            ])

            ->add('quiz',EntityType::class,[

                'class'=>Quiz::class,
                'choice_label'=>"sujetQuiz",
                "multiple"=>false,
                "expanded"=>false


            ])
            ->add('categorieAnnonce',EntityType::class,[

                'class'=>Categorie::class,
                'choice_label'=>"nomCategorie",
                "multiple"=>false,
                "expanded"=>false


            ])
          //  ->add('quiz')
           // ->add('categorieAnnonce')


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
