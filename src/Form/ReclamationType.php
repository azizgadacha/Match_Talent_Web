<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\Persistence\ManagerRegistry;

class ReclamationType extends AbstractType
{

    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('date')
            ->add('titre')
            ->add('type')
            ->add('description')
            //->add('statut')
            ->add('userReclamation', TextType::class, [
                'required' => true,
                'mapped' => false, // this tells Symfony to ignore this field when mapping form data to the entity
                'attr' => [
                    'placeholder' => 'Enter user name',
                ],
            ])
            //->add('reponseReclamation')
        ;
    }

   // public function configureOptions(OptionsResolver $resolver): void
    //{
        //$resolver->setDefaults([
            //'data_class' => Reclamation::class,
            //'users' => [],
        //]);
    //}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
            'users' => [],
        ]);
    }

    
}
