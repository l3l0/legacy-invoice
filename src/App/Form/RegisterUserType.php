<?php

declare(strict_types = 1);

namespace App\Form;

use App\FormValidator\UserAlreadyExistConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'E-mail: '],
                'label' => false,
                'required' => true,
                'constraints' => [new UserAlreadyExistConstraint()]
            ])
            ->add('password', RepeatedType::class, [
                'attr' => ['placeholder' => 'Password'],
                'type' => PasswordType::class,
                'first_name' => 'password',
                'second_name' => 'repeatPassword',
                'first_options' => ['label' => false ,
                    'attr' => ['placeholder' => 'Password']
                    ],
                'second_options' => ['label' => false,
                    'attr' => ['placeholder' => 'Repeat Password']
                    ],
                'invalid_message' => "Your password doesn't match",
                'required' => true,
            ])
            ->add('vatIdNumber', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Vat Number'],
                'required' => true,

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Register',
            ])
        ;
    }
}