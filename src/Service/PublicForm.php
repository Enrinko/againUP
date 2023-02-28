<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicForm extends AbstractController
{
    public function create($classType) {
        $user = new User();
        $form = $this->createForm($classType, $user);
        return $form;
    }

    public function save($class, $form, $doctrine) {
        $repository = $doctrine->getRepository($class);
        $user = $form->getData();
        $repository->save($user);
    }
}