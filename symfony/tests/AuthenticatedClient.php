<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Trait AuthenticatedClient
 *
 */
trait AuthenticatedClient
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param User $user
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient(?User $user = null)
    {
        $client = static::createClient();

        /** @var $jwtManager JWTTokenManagerInterface */
        $jwtManager = self::$container->get(JWTTokenManagerInterface::class);

        if (!$user) {
            /** @var $em EntityManagerInterface */
            $em = self::$container->get(EntityManagerInterface::class);
            $user = $em->getRepository(User::class)
                ->findOneBy([
                    'email' => 'user@user.com'
                ]);
        }

        $client->setServerParameter(
            'HTTP_Authorization', 
            sprintf('Bearer %s', $jwtManager->create($user))
        );

        return $client;
    }

    /**
     * Create a client with Admin's Authorization header.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedAdmin()
    {
        $client = static::createClient();

        /** @var $jwtManager JWTTokenManagerInterface */
        $jwtManager = self::$container->get(JWTTokenManagerInterface::class);

        /** @var $em EntityManagerInterface */
        $em = self::$container->get(EntityManagerInterface::class);
        $user = $em->getRepository(User::class)
            ->findOneBy([
                'email' => 'admin@admin.com'
            ]);

        $client->setServerParameter(
            'HTTP_Authorization', 
            sprintf('Bearer %s', $jwtManager->create($user))
        );

        return $client;
    }
}
