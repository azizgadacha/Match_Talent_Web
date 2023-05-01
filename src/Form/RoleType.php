<?php

namespace App\Form;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('roles', ChoiceType::class, [
            'expanded' => true,
            'multiple' => false,
            'choices' => [
                'Offreur' => 'Offreur',
                'Demandeur' => 'Demandeur',
                // add more roles as needed
            ],        'required' => true,

        ]);
    }

}