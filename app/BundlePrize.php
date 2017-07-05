<?php
namespace App;

use App\Item;

class BundlePrize
{
  public $item;
  public $quantity;
  public $type;
  public $raw;

  public function __construct(Item $item, $quantity, $type, $raw)
  {
    $this->item = $item;
    $this->quantity = (int) $quantity;
    $this->type = $type;
    $this->raw  = $raw;
  }

  public static function parse($raw)
  {
    
    $data = explode(" ", $raw);
    $item = Item::getByType($data[1], $data[0]);
    $prize = null;

    if($item)
    {
      $prize = new self($item, $data[2], $data[0], $raw);
    }

    return $prize;
  }
}