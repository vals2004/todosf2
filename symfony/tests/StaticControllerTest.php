<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @version 0.0.1
 * @package test
 */
class StaticControllerTest extends WebTestCase
{
    use AuthenticatedClient;

    public function testHomeAnonymous()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello DefaultController');
    }

    public function testHomeUser()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello DefaultController');
    }

    public function testHomeAdmin()
    {
        $client = $this->createAuthenticatedAdmin();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello DefaultController');
    }
    
    public function testApiDocsAnonymous()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/docs');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('API Platform');
    }

    public function testApiDocsUser()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/api/docs');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('API Platform');
    }
    
    public function testApiDocsAdmin()
    {
        $client = $this->createAuthenticatedAdmin();
        $crawler = $client->request('GET', '/api/docs');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('API Platform');
    }
}
