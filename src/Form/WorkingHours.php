<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;

class WorkingHours  extends Constraint
{
    public string $message = 'Le rendez-vous doit être pris entre 8h et 18h';

    public function validatedBy()
    {
        return static::class.'Validator';
    }}
