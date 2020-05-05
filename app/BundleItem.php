<?php
namespace App;

use App\Item;
use App\Quality;

class BundleItem
{

  public $item;
  public $quantity;
  public $quality;
  public $sort;
  public $raw;

  public function __construct(Item $item, $quantity, Quality $quality, $raw, $sort = 0)
  {
    $this->item = $item;
    $this->quantity = $quantity;
    $this->quality = $quality;
    $this->raw = $raw;
    $this->sort = $sort;
  }

  public static function parse($raw)
  {
    $data = explode(" ", trim($raw));
    $items = [];

    for($i = 0; $i < count($data); $i += 3)
    {
      
      $item = Item::getById($data[$i]);

      $quantity = (int) $data[$i + 1];
      $quality = (int) $data[$i + 2];
      $quality = Quality::new($quality);
      $sort = $i;

      if ($item)
      {
        $item = new self($item, $quantity, $quality, $raw, $sort);
        $items[] = $item;
      }

    }

    return $items;
  }
}