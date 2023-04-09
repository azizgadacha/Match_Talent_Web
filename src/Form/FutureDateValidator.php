<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Validator\ConstraintValidator;

class FutureDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof \DateTime) {
            return;
        }

        $currentDate = new \DateTime();
        if ($value < $currentDate) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}

