<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * UserMe constructor.
     *
     * @param TokenStorage   $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route(
     *      path="/api/users/me",
     *      name="api_users_get_me_item",
     *      methods={"GET"},
     *      defaults={
     *          "_api_resource_class"=User::class,
     *          "_api_item_operation_name"="get_me",
     *          "_api_receive"=false
     *      }
     * )
     */
    public function getMeAction(): User
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}