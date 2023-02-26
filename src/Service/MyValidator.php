<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MyValidator
{
    public ValidatorInterface $validator;
    public function user(User $user) {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return (string) $errors;
        }
        return true;
    }

}