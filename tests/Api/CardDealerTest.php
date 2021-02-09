<?php


namespace App\Tests\Api;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CardDealerTest extends WebTestCase
{
  public function testGetHand()
  {
    $client = self::createClient();

    $count = 10;

    $client->request('GET', 'api/cards', [
      'count' => $count
    ]);

    $response = $client->getResponse();

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    $this->assertJson($response->getContent());

    $data = json_decode($response->getContent(), true);
    $this->assertEquals($count, count($data));
  }

  public function testSortHand()
  {
    $client = self::createClient();

    $hand = [
      '10 Heart',
      '3 Heart',
      '7 Heart',
    ];

    $client->request('GET', 'api/cards/sort', ['hand' => $hand]);

    $response = $client->getResponse();

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    $this->assertJson($response->getContent());

    $data = json_decode($response->getContent(), true);
    $this->assertEquals(count($hand), count($data));
    $this->assertTrue($data[0] === $hand[1]);
    $this->assertTrue($data[1] === $hand[2]);
    $this->assertTrue($data[2] === $hand[0]);
  }
}
