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

  public function getCards(?int $count): array
  {
    $deck = $this->cards->buildDeck();
    shuffle($deck);

    if ($count !== null) {
      if ($count === 0 || $count > count($deck)) {
        $error = new ApiError(400, ApiError::INVALID_COUNT_PARAM);
        throw new ApiErrorException($error);
      }

      return array_slice($deck, 0, $count);
    }

    return $deck;
  }

  public function validateAndSortHand(string $hand): array
  {
    $results = [];

    $hand = json_decode($hand);
    foreach ($hand as $card) {
      [$face, $suit] = explode( ' ', $card);

      if (!in_array($suit, $this->cards->getSuits())
      || !in_array($face, $this->cards->getFaces())) {
        $error = new ApiError(400, ApiError::INVALID_CARD);
        throw new ApiErrorException($error);
      }

      $results[$suit][array_search($face, $this->cards->getFaces())] = $face . ' ' . $suit;
    }

    $sortedHand = [];
    foreach ($results as $face => $suits) {
      ksort($suits);
      $sortedHand = array_merge($sortedHand, $suits);
    }

    return $sortedHand;
  }
}
