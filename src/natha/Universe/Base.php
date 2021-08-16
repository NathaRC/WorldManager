<?php

namespace natha\universe;

/*Class For PocketMine-MP 4.0.0*/

use natha\universe\commands\WorldManagerCommand;
use pocketmine\plugin\PluginBase;

/*Class For WorldManager*/
use natha\universe\world\CreateWorld;
use natha\universe\world\DeleteWorld;

class Base extends PluginBase {

  public function onEnable() : void {
    $this->getLogger()->info("§7[§dWorlManager§7] §aLoaded");
    new WorldManagerCommand();
  }

}
