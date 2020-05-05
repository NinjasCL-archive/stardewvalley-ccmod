# Stardew Valley Community Center Modifier

With this simple script you can modify the community center arc and
create your own requirements!.

![](https://user-images.githubusercontent.com/292738/27853965-e2071552-6132-11e7-99c6-3ef0eec9946d.png)

![](https://user-images.githubusercontent.com/292738/27927274-3dea9674-6259-11e7-9ada-4e5656c2968c.png)

**Compatible with Stardew Valley 1.4**

## Requirements

It's a simple script created in Laravel 5. Does not use databases. Run Using Mamp/Wamp/Xampp, Laravel's Valet or PHP's build in server.

- _Stardew Valley 1.4_ Bundle files.
- Chrome (recommended, other browsers may not work well).
- [https://github.com/draivin/XNBNode](https://github.com/draivin/XNBNode).
- Windows. (XNBNode requirement. XNB files are OS agnostic though.)
- PHP >= 7.0.

## What enables to do?

- Change Prizes and Quantities.
- Change Required Items, Quantity and Quality.
- Change Bundle Names.

## How to Install

1. [Download a PHP interpreter](https://www.php.net/downloads) and install inside the _bin/php/_ directory, (or modify _ccmod.cmd_ to use the interpreter in your _PATH_).
2. Download [https://github.com/draivin/XNBNode](https://github.com/draivin/XNBNode) (including _xcompress32.dll_) inside _bin/xnbnode_ directory.

## Quick Use

Use _ccmod.cmd_ on a _Windows Machine_.
Download the self contained zip file here
https://github.com/NinjasCL/stardewvalley-ccmod/releases

## How to Use

1. Select your Bundle's Language.
2. Change your desired settings.
3. Download the XNB file. (You can also download the _yaml_ file for keeping custom versions editable.)
4. Copy `Bundles.xnb` (or `Bundles.es-ES`, depending on your selected language) replacing the file in `Data/Bundles.xnb` (depens on the language) inside the _StarDew Valley files directory_ (Backup your files).
5. That's it!.

## How to Extend

Maybe you want to create a new community center using previous custom files. Or you want custom _Object Information_. You just need to replace the [https://yaml.org/](yaml) files inside `www/resources/yaml`.

## Note

Because the script generates a heavy webpage (50mb) it will took a little while
to load successfully.

## License

MIT.

Made with <i class="fa fa-heart">&#9829;</i> by <a href="http://ninjas.cl" target="_blank">Ninjas.cl</a>.
