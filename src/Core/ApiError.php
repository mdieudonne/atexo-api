<?php

namespace App\Core;

use InvalidArgumentException;

class ApiError
{
  const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';
  const INVALID_COUNT_PARAM = 'invalid_count_param';
  const INVALID_CARD = 'invalid_card';
  const MISSING_PARAM = 'missing_params';
  static private array $titles = [
    self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent',
    self::INVALID_COUNT_PARAM => 'Invalid count param',
    self::INVALID_CARD => 'Invalid card',
    self::MISSING_PARAM => 'Missing mandatory parameter',
  ];
  private string $statusCode;
  private string $type;
  private string $title;

  public function __construct($statusCode, $type)
  {
    $this->statusCode = $statusCode;
    $this->type = $type;

    if (isset(self::$titles[$type])) {
      $this->title = self::$titles[$type];
    } elseif (!empty($type)) {
      $this->title = $type;
    } else {
      throw new InvalidArgumentException('No title for type '.$type);
    }

  }

  public function getStatusCode(): string
  {
    return $this->statusCode;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function toArray(): array
  {
    return [
      'status' => $this->statusCode,
      'type' => $this->type,
      'title' => $this->title,
    ];
  }

}
