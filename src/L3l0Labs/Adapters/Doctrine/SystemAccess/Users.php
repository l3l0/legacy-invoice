<?php

declare (strict_types = 1);

namespace L3l0Labs\Adapters\Doctrine\SystemAccess;

use Doctrine\Common\Persistence\ObjectManager;
use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\Exception\UserNotFoundException;
use L3l0Labs\SystemAccess\User;
use L3l0Labs\SystemAccess\Users as UsersInterface;

final class Users implements UsersInterface
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param Email $email
     * @throws UserNotFoundException
     * @return User
     */
    public function get(Email $email) : User
    {
        $user = $this
            ->objectManager
            ->getRepository(User::class)
            ->findOneBy(['email.email' => (string) $email])
        ;

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function find(Email $email) : bool
    {
        $user = $this
            ->objectManager
            ->getRepository(User::class)
            ->findOneBy(['email.email' => (string) $email])
        ;

        return isset($user) ? true : false;
    }

    public function add(User $user) : void
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}