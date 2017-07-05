<?php
namespace App;

use App\Item;
use App\Money;
use App\BundleItem;
use App\BundlePrize;
use App\XNBString;
use App\Yaml;

class Bundle
{
  public const kLangEnglish = 'en';
  public const kLangSpanish = 'es-ES';
  public const kLangGerman = 'de-DE';
  public const kLangPortuguese = 'pt-BR';
  public const kLangRussian = 'ru-RU';
  public const kLangJapanese = 'ja-JP';
  public const kLangChinese = 'zh-CN';

  public $uid;
  public $raw;
  public $id;
  public $title;
  public $xnb;
  public $lang;
  public $name;
  public $filename;
  public $translation;
  public $requirements;
  public $money;
  public $prize;

  private static $items;

  public function __construct($id, $raw, $lang, $filename)
  {
    
    $rawId = new XNBString($id);
    
    $this->id = (int) $rawId->components()[1];
    $this->name = $rawId->components()[0];
    $this->uid = md5($id . $lang . $filename);
    $this->raw = $id;

    $this->xnb = new XNBString($raw);

    $data = $this->xnb->components();

    $this->lang = $lang;
    $this->filename = $filename;
    $this->title = $data[0];
    $this->translation = $this->title;

    if ($lang != self::kLangEnglish) 
    {
      $translationPos = count($data) - 1;
      $this->translation = (isset($data[$translationPos]) ? $data[$translationPos] : "");
    }

    $this->money = Money::parse($data[2]);
    
    $this->requirements = BundleItem::parse($data[2]);

    $this->prize = BundlePrize::parse($data[1]);
  }

  public static function langs()
  {
    return [self::kLangEnglish, self::kLangSpanish, self::kLangGerman, 
            self::kLangPortuguese, self::kLangRussian, self::kLangJapanese,
            self::kLangChinese];
  }

  public static function identifiers()
  {
    return [
      0 => 'Pantry/0',
      1 => 'Pantry/1',
      2 => 'Pantry/2',
      3 => 'Pantry/3',
      4 => 'Pantry/4',
      5 => 'Pantry/5',
      13 => 'Crafts Room/13',
      14 => 'Crafts Room/14',
      15 => 'Crafts Room/15',
      16 => 'Crafts Room/16',
      17 => 'Crafts Room/17',
      18 => 'Crafts Room/19',
      6 => 'Fish Tank/6',
      7 => 'Fish Tank/7',
      8 => 'Fish Tank/8',
      9 => 'Fish Tank/9',
      10 => 'Fish Tank/10',
      11 => 'Fish Tank/11',
      20 => 'Boiler Room/20',
      21 => 'Boiler Room/21',
      22 => 'Boiler Room/22',
      23 => 'Vault/23',
      24 => 'Vault/24',
      25 => 'Vault/25',
      26 => 'Vault/26',
      31 => 'Bulletin Board/31',
      32 => 'Bulletin Board/32',
      33 => 'Bulletin Board/33',
      34 => 'Bulletin Board/34',
      35 => 'Bulletin Board/35'
    ];
  }

  private static function sort()
  {
    usort(self::$items, function($item1, $item2)
        {
          if ($item1->id == $item2->id) 
          {
            return 0;
          }

          return ($item1->id > $item2->id) ? 1 : -1;
        });
  }

  public static function getFileNameByLang($lang, $extension = '')
  {
      $filename = 'Bundles';
        
      if ($lang != self::kLangEnglish) 
      {
        $filename .= ".{$lang}";
      }

      if($extension != '')
      {
        $filename = "{$filename}.{$extension}";
      }

      return $filename;
  }

  public static function all()
  {
    if (is_null(self::$items) || count(self::$items) < 0) 
    {
      
      $langs = self::langs();
      $items = [];
      
      foreach ($langs as $lang) 
      {
        $filename = self::getFileNameByLang($lang);
        $file  = Yaml::get($filename);
        $data = $file['content'];
        
        foreach ($data as $key => $value) 
        {
          $items[] = new Bundle($key, $value, $lang, $filename);
        }
      }

      self::$items = $items;
      self::sort();
    }

    return self::$items;
  }

  public static function getByLang($lang = self::kLangEnglish)
  {
    $items = self::all();

    $bundles = [];

    foreach ($items as $key => $bundle) 
    {
      if ($bundle->lang == $lang) 
      {
        $bundles[] = $bundle;
      }
    }

    return $bundles;
  }

  public static function getById($id = 0, $lang = self::kLangEnglish)
  {
    $bundles = self::getByLang($lang);
    foreach($bundles as $key => $bundle)
    {
      if ($bundle->id == $id) 
      {
        return $bundle;
      }
    }

    return null;
  }
}