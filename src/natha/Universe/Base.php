<?php

namespace natha\universe;

/*Class For PocketMine-MP 4.0.0*/
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

/*Class For WorldManager*/
use natha\universe\world\CreateWorld;
use natha\universe\world\DeleteWorld;

class Base extends PluginBase {
  
  public function onEnable() : void {
    $this->getLogger()->info("§7[§dWorlManager§7] §aLoaded");
  }
  
  public function onCommand(CommandSender $player, Command $cmd, string $label, array $args) : bool {
    if ($cmd->getName() == "wm") {
      if ($args[0] == "create") {
        //$worldManager = CreateWorld::getWorldManager();
        CreateWorld::createWorld($args[1], $args[2], $args[3]);
        $player->sendMessage("§7[§dWorldManager§7] §a The world was created §3$args[1]");
        $this->getLogger()->info("§ase creo el mundo $args[1]");
      }
      elseif ($args[0] == "tp") {
        $world = Server::getInstance()->getWorldManager()->getWorldByName($args[1]);
        $player->teleport($world->getSafeSpawn());
        $player->sendMessage("§7[§dWorldManager§7] §ateleported §3$args[1]");
      }
      elseif ($args[0] == "list"){
        $worlds = [];
        $path = Server::getInstance()->getDataPath()."worlds";
        $generate = Server::getInstance()->getWorldManager();
        foreach (scandir($path) as $file){
          if($generate->isWorldGenerated($file)){
            $worldload = $generate->isWorldLoaded($file);
            $players = 0;
            if ($worldload){
              $world = $generate->getWorldByName($file)->getPlayers();
              $players = count($world);
            }
            $worlds[$file] = [$worldload, $players];
            }
          }
          $levels = count($worlds);
          $player->sendMessage("§7[§dWorldManager§7] §3List of Worlds §a{$levels}");
          foreach($worlds as $world => [$loaded, $players]){
            $loaded = $loaded ? "§aLoaded" : "§cUnloaded";
            $player->sendMessage("§7[§dWorldManager§7] §3$world - $loaded §7Players §a$players");
        }
      }
      elseif ($args[0] == "help") {
        $player->sendMessage("§3=======§7[§dWorldManager§7]§3=======");
        $player->sendMessage("§7[§dWorldManager§7] §3/mw create [{name}, {seed} {normal : flat}]");
        $player->sendMessage("§7[§dWorldManager§7] §3/mw tp name");
        $player->sendMessage("§7[§dWorldManager§7] §3/mw list");
        $player->sendMessage("§7[§dWorldManager§7] §3/mw help");
      }
      elseif ($args[0] == 'delete') {
        DeleteWorld::removeWorld($args[1]);
        $player->sendMessage("§7[§dWorldManager§7] §aThe world {$args[1]} was successfully eliminated");
      }
    }
    return false;
  }
}
