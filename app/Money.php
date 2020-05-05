<?php
namespace App;

class Money
{
  public $active;
  public $value;
  public $quantity;

  public function __construct($isMoney, $value)
  {
    $this->active = $isMoney;
    $this->value = $value;
    $this->quantity = $value; // convenience
  }

  public static function check($id = 0)
  {
    return ($id == -1);
  }

  public static function parse($raw)
  {
    $data = explode(" ", $raw);
    $isMoney = self::check($data[0]);
    $value = 0;
    if ($isMoney)
    {
      $value = (int) $data[1];
    }

    return new self($isMoney, $value);
  }
}