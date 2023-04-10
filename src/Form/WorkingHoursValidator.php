<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Validator\ConstraintValidator;

class WorkingHoursValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $hour = (int) substr($value, 0, 2);
        if ($hour < 8 || $hour >= 18) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}

