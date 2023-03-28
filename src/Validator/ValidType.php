<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidType extends Constraint
{

        public $message = 'Le type doit être Security ou Content.';


    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}