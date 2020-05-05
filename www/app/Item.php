<?php

namespace App;
use App\Yaml;
use App\XNBString;

class Item
{
    public $uid;
    public $id;
    public $xnb;
    public $name;
    public $description;
    public $type;
    public $category;
    public $prizeType;

    const kCategoryObject = 'Object';
    const kCategoryFurniture = 'Furniture';
    const kCategoryBigCraftable = 'BigCraftable';
    const kCategoryRing = 'Ring';
    const kCategoryChair = 'Chair';
    
    const kTypeObject = 'O';
    const kTypeBigCraftable = 'BO';
    const kTypeFurniture = 'F';
    const kTypeRing = 'R';
    const kTypeChair = 'C';

    private static $items;
    private static $objects;
    private static $furniture;
    private static $craftables;

    public function __construct($id, $raw, $category, $namePos = 0, $descriptionPos = 5, $typePos = 3)
    {
      $this->id = $id;
      $this->xnb = new XNBString($raw);
      $this->category = $category;
      
      $this->name = trim(ucwords($this->xnb->components()[$namePos]));
      $this->title = $this->name; // convenience property
      
      $this->description = trim($this->xnb->components()[$descriptionPos]);
      $this->type = trim(ucwords(explode(' ', $this->xnb->components()[$typePos])[0]));

      $this->uid = md5(trim($this->id .
                          $this->category .
                          $this->type .
                          $this->name .
                          $this->description)
                      );

      switch ($this->category) 
      {
         case self::kCategoryBigCraftable:
            $this->prizeType = self::kTypeBigCraftable;
           break;
         
         case self::kCategoryObject:
         
            $this->prizeType = self::kTypeObject;

            if ($this->type == self::kCategoryRing) 
            {
              $this->prizeType = self::kTypeRing;
            }

            if ($this->type == self::kCategoryChair) 
            {
              $this->prizeType = self::kTypeChair;
            }

            break;
         default:
           $this->prizeType = self::kTypeObject;
           break;
       } 
    } 

    public static function get($pos = 0)
    {
      return self::all()[$pos];
    }

    public static function getByIdAndCategory($id = 0, $category = null)
    {
      $items = [];

      switch($category)
      {
        case self::kCategoryObject:
          $items = self::objects();
        break;
        case self::kCategoryBigCraftable:
          $items = self::craftables();
        break;
        case self::kCategoryFurniture:
          $items = self::furniture();
        break;
        default:
          $items = self::all();
        break;
      }


      // O(n)
      if($items)
      {
        foreach ($items as $key => $item) 
        {
          if ($item->id == $id) 
          {
            return $item;
          }
        }
      }
      
      return null;
    }

    public static function getById($id = 0)
    {
      
      $item = self::getObjectById($id);
      if(is_null($item))
      {
        $item = self::getCraftableById($id);
        if(is_null($item))
        {
          $item = self::getFurnitureById($id);
        }
      }

      return $item;
    }

    public static function getObjectById($id = 0)
    {
      return self::getByIdAndCategory($id, self::kCategoryObject);
    }

    public static function getCraftableById($id = 0)
    {
      return self::getByIdAndCategory($id, self::kCategoryBigCraftable);
    }

    public static function getFurnitureById($id = 0)
    {
      return self::getByIdAndCategory($id, self::kCategoryFurniture);
    }

    public static function getByType($id = 0, $type = self::kTypeObject)
    {
        switch ($type) 
        {
          case self::kTypeBigCraftable:
            return self::getCraftableById($id);
            break;
          case self::kTypeFurniture:
            return self::getFurnitureById($id);
            break;
          case self::kTypeObject:
            return self::getObjectById($id);
            break;
          default:
            return self::getById($id);
            break;
        }
    }

    public static function objects()
    {
      if (is_null(self::$objects) || count(self::$objects) <= 0) 
      {
        self::all();
      }

      return self::$objects;
    }

    // Only allowed objects in the bundle requirements
    public static function allowedObjects()
    {
      $objects = self::objects();
      $allowed = [];
      foreach($objects as $object)
      {
        if($object->prizeType != self::kTypeRing)
        {
          $allowed[] = $object;
        }
      }

      return $allowed;
    }

    public static function furniture()
    {
      if (is_null(self::$furniture) || count(self::$furniture) <= 0) 
      {
        self::all();
      }

      return self::$furniture;
    }

    public static function craftables()
    {
      if (is_null(self::$craftables) || count(self::$craftables) <= 0) 
      {
        self::all();
      }

      return self::$craftables;
    }

    public static function all()
    {
      if (is_null(self::$items) || count(self::$items) <= 0)  
      {
        
        $getItems = function($filename, $category, $namePos = 0, 
                            $descriptionPos = 5, $typePos = 3)
        {
          $file = Yaml::get($filename);
          $data = $file['content'];
          $items = [];

          foreach ($data as $key => $value) 
          {
              $items[] = new Item($key, $value, $category, 
                                  $namePos, $descriptionPos, $typePos);
          }

          return $items;
        };
        
        $objects = $getItems('ObjectInformation', self::kCategoryObject);
        $furniture = $getItems('Furniture', self::kCategoryFurniture, 0, 1, 1);
        $craftables = $getItems('BigCraftablesInformation', self::kCategoryBigCraftable, 0, 4, 3);

        self::$items = array_merge($objects, $furniture, $craftables);

        self::$objects = $objects;
        self::$furniture = $furniture;
        self::$craftables = $craftables;

        usort(self::$items, function($item1, $item2)
        {
          if ($item1->id == $item2->id) 
          {
            return 0;
          }

          return ($item1->id > $item2->id) ? 1 : -1;
        });
      }

      return self::$items;
    }
}
