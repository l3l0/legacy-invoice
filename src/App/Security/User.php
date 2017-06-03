<?php

declare (strict_types = 1);

namespace App\Security;

use L3l0Labs\Accounting\Invoice\VatIdNumber;
use L3l0Labs\SystemAccess\User as SystemAccessUser;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    /**
     * @var SystemAccessUser
     */
    private $user;

    /**
     * @param SystemAccessUser $user
     */
    public function __construct(SystemAccessUser $user)
    {
        $this->user = $user;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles() : array
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword() : string
    {
        return (string) $this->user->passwordHash();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() : string
    {
        return (string) $this->user->email();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    public function vatIdNumber() : VatIdNumber
    {
        return $this->user->vatIdNumber();
    }
}