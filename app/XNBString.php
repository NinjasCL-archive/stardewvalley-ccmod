<?php
namespace App;

class XNBString
{
  public $raw;
  private $components;

  public function __construct($raw)
  {
    $this->raw = $raw;
    $this->components = [];
  }

  public function components()
  {
    if (count($this->components) <= 0) 
    {
      $this->components = explode('/', $this->raw);
    }
    
    return $this->components;
  }

  public static function getComponents($string)
  {
      $xnb = new XNBString($string);
      return $xnb->components();
  }
}