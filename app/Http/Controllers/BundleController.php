<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Bundle;
use App\Item;
use App\Quality;
use App\Download;

class BundleController extends Controller
{
    public function index(Request $request)
    {
      $this->validate($request, [
        'lang' => [
          'bail',
          'required',
          Rule::in(Bundle::langs())
        ]
      ]);

      $language = $request->input('lang');
      $bundles = Bundle::getByLang($language);
      $items = Item::all();
      $objects = Item::allowedObjects();
      $qualities = Quality::all();

      // Animal Bundle have these weird ids after position 5
      // don't know why are they needed as they are empty items
      // $animal = $bundles[4];
      // 639 1 0 640 1 0 641 1 0 642 1 0 643 1 0
      // dd(Item::getById(639));

      return view('bundle.index', [
        'bundles' => $bundles,
        'bundles_json' => json_encode($bundles),
        'lang' => $language,
        'items' => $items,
        'items_json' => json_encode($items),
        'objects' => $objects,
        'objects_json' => json_encode($objects),
        'qualities' => $qualities
        ]);
    }

    public function create(Request $request)
    {
      $this->validate($request, [
        'lang' => [
          'bail',
          'required',
          Rule::in(Bundle::langs())
        ],
        'bundles' => [
          'bail',
          'required'
        ]
      ]);

      $bundles = json_decode($request->input('bundles'));
      $lang = trim($request->input('lang'));
      
      $filename = Bundle::getFileNameByLang($lang, 'yml');

      $params = [
        'bundles' => $bundles,
        'spring' => $bundles[0],
        'summer' => $bundles[1],
        'fall' => $bundles[2],
        'quality' => $bundles[3],
        'animal' => $bundles[4],
        'artisan' => $bundles[5],
        'river' => $bundles[6],
        'lake' => $bundles[7],
        'ocean' => $bundles[8],
        'night' => $bundles[9],
        'specialty' => $bundles[10],
        'crab' => $bundles[11],
        'springfo' => $bundles[12],
        'summerfo' => $bundles[13],
        'fallfo' => $bundles[14],
        'winterfo' => $bundles[15],
        'construction' => $bundles[16],
        'exotic' => $bundles[17],
        'blacksmith' => $bundles[18],
        'geologist' => $bundles[19],
        'adventurer' => $bundles[20],
        'vaultSmall' => $bundles[21],
        'vaultMedium' => $bundles[22],
        'vaultBig' => $bundles[23],
        'vaultLarge' => $bundles[24],
        'chef' => $bundles[25],
        'field' => $bundles[26],
        'enchanter' => $bundles[27],
        'dye' => $bundles[28],
        'fodder' => $bundles[29]
      ];

      $view = 'bundle.yaml';
      if($lang === Bundle::kLangEnglish)
      {
        $view .= '-eng';
      }

      $yaml = view($view, $params)->render();

      $filepath = storage_path() . DIRECTORY_SEPARATOR . md5(microtime()) . $filename;
      $file = fopen($filepath, 'w');
      fwrite($file, $yaml);
      fclose($file);

      return Download::file($filepath, $filename);
    }

}
