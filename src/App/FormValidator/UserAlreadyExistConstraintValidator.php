<?php

namespace App\FormValidator;

use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\Exception\UserNotFoundException;
use L3l0Labs\SystemAccess\Users;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UserAlreadyExistConstraintValidator extends ConstraintValidator
{
    /**
     * @var Users
     */
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $email The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($email, Constraint $constraint)
    {
        try {
            $this->users->get(new Email($email));

            $this->context->buildViolation($constraint->message)->addViolation();
        } catch (UserNotFoundException $e) {
            return;
        }
    }
}