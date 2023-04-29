<?php

namespace App\Form;

use App\Entity\Postulation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostulationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etat')
          //  ->add('date')
       //     ->add('annoncePostulation')
        //    ->add('userPostulation')
           // ->add('fileAssocier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Postulation::class,
        ]);
    }
}
