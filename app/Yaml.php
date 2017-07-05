<?php
namespace App;
use Symfony\Component\Yaml\Yaml as SYaml;
use Illuminate\Support\Facades\File;

class Yaml 
{
  public static function get($filename)
  {
      $file = resource_path() . "/yaml/{$filename}.yml";
      $yml  = SYaml::parse(File::get($file));
      return $yml;
  }
}