<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

class SetUser
{
    private Security $security;

    public function __counstruct(Security $security)
    {
        $this->security = $security;
    }

    public function doSomething(User $user)
    {
        $this->security->login($user);

    }

}