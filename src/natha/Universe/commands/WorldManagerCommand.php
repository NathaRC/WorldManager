<?php

/*
*      _           _   _   _               
*     | |  _   _  | | | | (_)  _   _   ___ 
*  _  | | | | | | | | | | | | | | | | / __|
* | |_| | | |_| | | | | | | | | |_| | \__ \
*  \___/   \__,_| |_| |_| |_|  \__,_| |___/                                          
*                              
*/

namespace natha\universe\commands;


use natha\universe\world\CreateWorld;
use natha\universe\world\DeleteWorld;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;

class WorldManagerCommand extends Command
{

    public function __construct()
    {
        parent::__construct('WorldManager', null, '/wm help', ['worldmanager','wm']);
        Server::getInstance()->getCommandMap()->register('wm',$this);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender->isOp())
        {
            $sender->sendMessage('§cYou don`t have permission!');
            return;
        }
        if ($args[0] == 'create')
        {
            CreateWorld::createWorld($args[1], $args[2], $args[3]);
            $sender->sendMessage("§7[§dWorldManager§7] §a The world was created §3$args[1]");
            Server::getInstance()->getLogger()->info('§aWorld create: '.$args[1]);
        }
         elseif ($args[0] = 'tp') {
             $world = Server::getInstance()->getLevelByName($args[1]);
             if ($world instanceof Level)
             {
                 if ($sender instanceof Player)
                 {
                     $sender->sendMessage("§7[§dWorldManager§7] §aTeleported §3$args[1]");
                     $sender->teleport($world->getSafeSpawn());
                 } else {
                     $sender->sendMessage('§cCommand run in-game!');
                 }
             } else {
                 $sender->sendMessage('§cWorld: '.$args[1].'don`t exist!');
             }
         } elseif($args[0] == 'list')
        {
            $worlds = [];
            $path = Server::getInstance()->getDataPath()."worlds";
            $generate = Server::getInstance()->getWorldManager();
            foreach (scandir($path) as $file){
                if($generate->isWorldGenerated($file)){
                    $worldLoad = $generate->isWorldLoaded($file);
                    $players = 0;
                    if ($worldLoad){
                        $world = $generate->getWorldByName($file)->getPlayers();
                        $players = count($world);
                    }
                    $worlds[$file] = [$worldLoad, $players];
                }
            }
            $levels = count($worlds);
            $sender->sendMessage("§7[§dWorldManager§7] §3List of Worlds §a{$levels}");
            foreach($worlds as $world => [$loaded, $players]){
                $loaded = $loaded ? "§aLoaded" : "§cUnloaded";
                $sender->sendMessage("§7[§dWorldManager§7] §3$world - $loaded §7Players §a$players");
            }
        }elseif ($args[0] == 'delete') {
            DeleteWorld::removeWorld($args[1]);
            $sender->sendMessage("§7[§dWorldManager§7] §aThe world {$args[1]} was successfully eliminated");
        }
        elseif ($args[0] == "help") {
            $sender->sendMessage("§3=======§7[§dWorldManager§7]§3=======");
            $sender->sendMessage("§7[§dWorldManager§7] §3/mw create [{name}, {seed} {normal : flat}]");
            $sender->sendMessage("§7[§dWorldManager§7] §3/mw tp name");
            $sender->sendMessage("§7[§dWorldManager§7] §3/mw list");
            $sender->sendMessage("§7[§dWorldManager§7] §3/mw help");
        }

        // TODO: Implement execute() method.
    }
}