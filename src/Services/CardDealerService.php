<?php


namespace App\Services;


use App\Core\ApiError;
use App\Core\ApiErrorException;
use App\Model\Cards;

class CardDealerService
{

  private Cards $cards;

  function __construct()
  {
    $this->cards = new Cards();
  }

  public function getCards(string $count): array
  {
    $this->cards->buildDeck();
    $this->cards->shuffleDeck();

    if (intval($count)) {
      if ($count === 0 || $count > count($this->cards->getDeck())) {
        $error = new ApiError(400, ApiError::INVALID_COUNT_PARAM);
        throw new ApiErrorException($error);
      }

      return array_slice($this->cards->getDeck(), 0, $count);
    }

    return $this->cards->getDeck();
  }

  public function sortHand(array $hand): array
  {
    $this->cards->setDeck($hand);
    $this->cards->sortDeck();

    return $this->cards->getDeck();
  }
}
