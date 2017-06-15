<?php

declare (strict_types = 1);
 
namespace L3l0Labs\SystemAccess;

use L3l0Labs\SystemAccess\Exception\UserNotFoundException;

interface Users
{
    /**
     * @param Email $email
     * @throws UserNotFoundException
     * @return User
     */
    public function get(Email $email) : User;
    public function find(Email $email) : bool;
    public function add(User $user) : void;
}
