<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicService extends AbstractController
{
    public function identifyRole() {
        switch ($this->getUser()->getRoles()[0]) {
            case "ROLE_USER": {
                return 'Пользователь';
            }
            case "ROLE_PREMIUM": {
                return 'Поддержал рублём';
            }
            case "ROLE_EDITOR": {
                return 'Редактор';
            }
            case "ROLE_ADMIN": {
                return 'Админ';
            }
        }
    }
}