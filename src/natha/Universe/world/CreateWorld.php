<?php

namespace natha\universe\world;

/*Class For PocketMine-MP 4.0.0*/
use pocketmine\world\WorldManager;
use pocketmine\world\WorldCreationOptions;
use pocketmine\Server;
use pocketmine\world\generator\normal\Normal;
use pocketmine\world\generator\Flat;

class CreateWorld {
  
 /* public static function getWorldManager():self{
    return new self;
  }*/
  
  public static function createWorld(String $world, string $seed, string $generator) {
    $worldOptions = new WorldCreationOptions();
    $worldOptions->setSeed($seed);
    if ($generator == "normal"){
      $worldOptions->setGeneratorClass(Normal::class);
    }elseif ($generator == "flat") {
      $worldOptions->setGeneratorClass(Flat::class);
    }
    Server::getInstance()->getWorldManager()->generateWorld($world, $worldOptions);
  }
}
?>