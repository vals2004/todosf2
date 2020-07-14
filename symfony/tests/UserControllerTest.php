<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @version 0.0.1
 * @package test
 */
class UserControllerTest extends WebTestCase
{
    use AuthenticatedClient;

    public function testMeUser()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/api/users/me');

        $this->assertResponseIsSuccessful();
    }

    public function testUserById()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/api/users/2');

        $this->assertResponseIsSuccessful();
    }

    public function testUserByIdUnauthirized()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/api/users/1');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testUserMeNotAllowed()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/users/me');

        $this->assertResponseStatusCodeSame(405);
    }
}
