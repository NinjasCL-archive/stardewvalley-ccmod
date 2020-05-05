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
	$prize = (object)[
		"quantity" => 0, 
		"item" => (object)[
			"uid" => 0,
			"id" => 0
		],
		"type" => 0
	];
			
	if(isset($data) && count($data) > 1){
		$item = Item::getByType($data[1], $data[0]);


		if($item)
		{
		  $prize = new self($item, $data[2], $data[0], $raw);
		}
	}

    return $prize;
  }
}