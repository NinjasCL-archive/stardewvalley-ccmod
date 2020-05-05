<?php 
namespace App;

class XNBNode
{
  static private function invoke($command, $sleep = 1, $log = ".xnbnode.log")
  {
    // Based on https://www.php.net/manual/es/function.shell-exec.php#123710
    if (substr(php_uname(), 0, 7) == "Windows")
    {
      $result = pclose(popen("start /B " . $command . " 1> $log 2>&1", "r"));
      // Give some time to execute the command
      sleep($sleep);
      return $result;
    }

    // Unix
    $result = shell_exec($command . " 1> $log 2>&1" );
    sleep($sleep);
    return $result;
  }
  
    static public function build($filepath)
    {
    $bin = base_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR;
    $appdir = $bin . "xnbnode" . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR; 

    $node = $appdir . "node.exe ";
    $xnbnode = $node . $appdir . "main.js ";

    $xnbfile = $filepath . ".xnb";
    $pack = $xnbnode . ' pack "' . $filepath . '" "' . $xnbfile . '"';

    $command = escapeshellcmd($pack);

    $result = XNBNode::invoke($command);
    
    if(!is_null($result))
    {
      return $xnbfile;
    }
    
    return null;
    }
}
