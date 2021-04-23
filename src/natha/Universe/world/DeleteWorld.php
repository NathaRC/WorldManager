<?php

namespace natha\universe\world;

/*Class For PocketMine-MP 4.0.0*/
use pocketmine\Server;

class DeleteWorld {
  
  public static function removeWorld(string $world){
    return self::removeFolder(Server::getInstance()->getDataPath().'/worlds/'.$world);
  }
  
  public static  function removeFolder(string $path) : int {
    $files = 1;
    if (basename($path) == '.' || basename($path) == '..' || !is_dir($path)){
      return 0;
    }
    foreach (scandir($path) as $world){
      if ($world !== '.' || $world !== '..') {
        if (is_dir($path.DIRECTORY_SEPARATOR.$world)){
          $files += self::removeFolder($path.DIRECTORY_SEPARATOR.$world);
        }
        if (is_file($path.DIRECTORY_SEPARATOR.$world)) {
          $files += self::removeFile($path.DIRECTORY_SEPARATOR.$world);
        }
      }
    }
    rmdir($path);
    return $files;
  }
  
  public static function removeFile(string $path) : int {
    return unlink($path);
  }
}