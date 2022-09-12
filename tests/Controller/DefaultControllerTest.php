<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function provideUriAndStatusCode(): array
    {
        return [
            'home' => ['/', 200],
            'contact' => ['/contact', 200],
            'book_index' => ['/book', 301],
            'book_details' => ['/book/1', 200],
            'toto' => ['/toto', 404],
        ];
    }

    /**
     * @dataProvider provideUriAndStatusCode
     * @group smoke
     */
    public function testPublicUris(string $uri, int $statusCode): void
    {
        $client = static::createClient();
        $client->request('GET', $uri);
        //$response = $client->getResponse();

        //$this->assertResponseIsSuccessful();
        //$this->assertEquals(200, $response->getStatusCode());
        $this->assertResponseStatusCodeSame($statusCode);
    }
}
