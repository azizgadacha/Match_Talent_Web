<?php

namespace App\Form;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filemtivation', null, [
        'constraints' => [
            new NotBlank([
                'message' => 'Ce champ est obligatoire'
            ])
        ]
    ])
            ->add('filecv', null, [
        'constraints' => [
            new NotBlank([
                'message' => 'Ce champ est obligatoire'
            ])
        ]
    ])
            ->add('filedeplome', null, [
        'constraints' => [
            new NotBlank([
                'message' => 'Ce champ est obligatoire'
            ])
        ]
    ])
          //  ->add('userFile')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => File::class,
        ]);
    }
}
