<?php 
namespace App;

class Quality
{
  public $value;
  public $name;

  const kQualityNameNormal = 'Normal';
  const kQualityValueNormal = 0;

  const kQualityNameSilver = 'Silver';
  const kQualityValueSilver = 1;

  const kQualityNameGold = 'Gold';
  const kQualityValueGold = 2;

  const kQualityNameIridium = 'Iridium';
  const kQualityValueIridium = 3;

  public function __construct($name, $value)
  {
    $this->name = $name;
    $this->value = $value;
  }

  public static function qualities()
  {
      return [
        self::kQualityValueNormal => self::kQualityNameNormal,
        self::kQualityValueSilver => self::kQualityNameSilver,
        self::kQualityValueGold => self::kQualityNameGold,
        self::kQualityValueIridium => self::kQualityNameIridium
      ];
  }

  public static function all()
  {
    $normal = self::new();
    $silver = self::new(self::kQualityValueSilver);
    $gold = self::new(self::kQualityValueGold);
    $iridium = self::new(self::kQualityValueIridium);

    return [$normal, $silver, $gold, $iridium];
  }

  public static function new($value = self::kQualityValueNormal)
  {
    if (is_null($value) || $value < self::kQualityValueNormal) 
    {
      $value = self::kQualityValueNormal;
    }

    if ($value > self::kQualityValueIridium) 
    {
      $value = self::kQualityValueIridium;
    }

    $qualities = self::qualities();

    if (!in_array($value, array_keys($qualities))) 
    {
      $value = self::kQualityValueNormal;
    }

    $name = $qualities[$value];
    $quality = new self($name, $value);

    return $quality;
  }
}