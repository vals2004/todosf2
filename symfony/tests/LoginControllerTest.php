<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

/**
 * @version 0.0.1
 * @package test
 */
class LoginControllerTest extends ApiTestCase
{
    public function testUserLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/authentication_token', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'email' => 'user@user.com',
                'password' => 'user',
            ])
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(isset($data['token']));
    }

    public function testUserLoginFail()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/authentication_token', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'email' => 'user@user.com',
                'password' => 'wrongpass',
            ])
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testUserLoginEmpty()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/authentication_token', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'email' => '',
                'password' => '',
            ])
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testUserLoginNotJson()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/authentication_token', [
            'body' => json_encode([
                'email' => 'user@user.com',
                'password' => 'user',
            ])
        ]);

        $this->assertResponseStatusCodeSame(404);
    }
}
