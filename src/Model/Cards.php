<?php


namespace App\Model;


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

  public function getFaces(): array
  {
    return $this->faces;
  }

  public function getSuits(): array
  {
    return $this->suits;
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

}
