<?php

namespace App\FormValidator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserAlreadyExistConstraint extends Constraint
{
    public $message = 'This email is already registered';
}