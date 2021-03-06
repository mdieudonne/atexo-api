<?php


namespace App\Controller;


use App\Core\ApiError;
use App\Core\ApiErrorException;
use App\Services\CardDealerService;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CardDealer
{


  /**
   * @Route(
   *   "/api/cards",
   *   name="get_cards",
   *   methods={"GET"}
   * )
   *
   * @OA\Parameter(
   *     name="count",
   *     in="query",
   *     description="Number of cards required",
   *     @OA\Schema(type="integer")
   * )
   *
   * @OA\Response(
   *     response=200,
   *     description="Returns the array of cards. Example: ['7 Spade', '8 Heart']",
   *     @OA\JsonContent(
   *        type="array",
   *        @OA\Items(type="string")
   *     )
   * )
   *
   * @param Request $request
   * @param CardDealerService $cardDealerService
   * @return JsonResponse
   */
  public function getHand(Request $request, CardDealerService $cardDealerService): JsonResponse
  {
    $count = $request->query->get('count');

    if ($count === null) {
      $error = new ApiError(400, ApiError::MISSING_PARAM);
      throw new ApiErrorException($error);
    }

    $hand = $cardDealerService->getCards($count);

    return new JsonResponse($hand, 200);
  }

  /**
   * @Route(
   *   "/api/cards/sort",
   *   name="sort_cards",
   *   methods={"GET"}
   * )
   * @OA\Parameter(
   *     name="cards",
   *     in="query",
   *     description="Array of cards. Example: ['7 Spade', '8 Heart']",
   *     @OA\Schema(
   *      type="array",
   *      @OA\Items(type="string")
   *     )
   * )
   *
   * @OA\Response(
   *     response=200,
   *     description="Returns the sorted array of cards. Example: ['7 Spade', '8 Heart']",
   *     @OA\JsonContent(
   *        type="array",
   *        @OA\Items(type="string")
   *     )
   * )
   *
   * @param Request $request
   * @param CardDealerService $cardDealerService
   * @return JsonResponse
   */
  public function sortHand(Request $request, CardDealerService $cardDealerService): JsonResponse
  {
    $hand = $request->query->get('hand');

    if (empty($hand)) {
      $error = new ApiError(400, ApiError::MISSING_PARAM);
      throw new ApiErrorException($error);
    }

    $sortedhand = $cardDealerService->sortHand((array)$hand);

    return new JsonResponse($sortedhand, 200);

  }

}
