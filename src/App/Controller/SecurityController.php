<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Security\User;
use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\UseCase\RegisterUser;
use L3l0Labs\SystemAccess\UseCase\RegisterUser\Command as RegisterUserCommand;
use App\Form\RegisterUserType;
use L3l0Labs\SystemAccess\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
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

    public function register(Request $request) : Response
    {
        $form = $this->createForm(RegisterUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $registerUserCommand = new RegisterUserCommand(
                $formData['email'],
                $formData['password'],
                $formData['vatIdNumber']
            );

            $this->registerUser()->execute($registerUserCommand);

            $this->authenticateUser(new Email($formData['email']));

            return $this->redirectToRoute('index');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function registerUser() : RegisterUser
    {
        return $this->get('l3l0labs.app.security.use_case.register_user');
    }

    private function security() : TokenStorage
    {
        return $this->get('security.token_storage');
    }

    private function users() : Users
    {
        return $this->get('l3l0labs.system_access.repository.user');
    }

    private function authenticateUser(Email $email)
    {
        $user = $this->users()->get($email);

        $securityUser = new User($user);
        $token = new UserNamePasswordToken($securityUser, null, 'main', $securityUser->getRoles());

        $this->security()->setToken($token);
    }
}