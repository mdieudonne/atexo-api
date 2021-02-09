<?php


namespace App\Model;


use App\Core\ApiError;
use App\Core\ApiErrorException;

class Cards
{
  private array $faces;
  private array $suits;
  private array $deck;

  function __construct()
  {
    $this->faces = [
      'Ace',
      '2',
      '3',
      '4',
      '5',
      '6',
      '7',
      '8',
      '9',
      '10',
      'Jack',
      'Queen',
      'King',
    ];

    $this->suits = [
      'Spade',
      'Heart',
      'Club',
      'Diamond',
    ];
  }

  public function getDeck(): array
  {
    return $this->deck;
  }

  public function setDeck(array $deck): void
  {
    $this->deck = $deck;
  }

  public function buildDeck(): array
  {
    foreach ($this->suits as $suit) {
      foreach ($this->faces as $face) {
        $this->deck[] = $face.' '.$suit;
      }
    }

    return $this->deck;
  }

  public function validateCard(string $face, string $suit): bool
  {
    if (!in_array($suit, $this->suits) || !in_array($face, $this->faces)) {
      $error = new ApiError(400, ApiError::INVALID_CARD);
      throw new ApiErrorException($error);
    }
    return true;
  }

  public function shuffleDeck(): void
  {
    shuffle($this->deck);
  }

  public function sortDeck(): void
  {
    $results = [];
    foreach ($this->deck as $card) {
      [$face, $suit] = explode( ' ', $card);
      $this->validateCard($face, $suit);
      $results[$suit][array_search($face, $this->faces)] = $face . ' ' . $suit;
    }

    $this->deck = [];
    ksort($results);
    foreach ($results as $face => $suits) {
      ksort($suits);
      $this->deck = array_merge( $this->deck, $suits);
    }
  }

}
