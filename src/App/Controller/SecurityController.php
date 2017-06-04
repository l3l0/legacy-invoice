<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Security\User;
use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\UseCase\RegisterUser\Command as RegisterUserCommand;
use App\Form\RegisterUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function login(Request $request, AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    public function logout()
    {
    }

    public function register(Request $request)
    {
        $form = $this->createForm(RegisterUserType::class);
        $form->handleRequest($request);



        if($form->isValid()) {
            var_dump($form->getErrors()->current());die;
            $formData = $form->getData();
            $registerUserCommand = new RegisterUserCommand(
                $formData['email'],
                $formData['password'],
                $formData['vatIdNumber']
            );

            $this->registerUsers()->execute($registerUserCommand);

            $this->authenticateUser(new Email($formData['email']));

            return $this->redirectToRoute('index');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function registerUsers()
    {
        return $this->get('l3l0labs.app.security.user_case.register_user');
    }

    private function security()
    {
        return $this->get('security.token_storage');
    }

    private function users()
    {
        return $this->get('l3l0labs.system_access.repository.user');
    }

    private function authenticateUser(Email $email)
    {
        $user = $this->users()->getByEmail($email);

        $securityUser = new User($user);
        $token = new UserNamePasswordToken($securityUser, null, 'main', $securityUser->getRoles());

        $this->security()->setToken($token);
    }
}