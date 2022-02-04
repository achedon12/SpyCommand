<?php

namespace achedon\commandSpy\commands;

use achedon\commandSpy\spy;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class spyCMD extends Command{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){

        $cfg = spy::config();
        $prefix = $cfg->get("prefix");
        $noPerm = $cfg->get("ErrorMessage");
        $stop = $cfg->get("StopSpy");
        $start = $cfg->get("ConfirmSpy");

        if(!$sender instanceof Player){
            $sender->sendMessage("please run this command in game");
        }else{
            if(!Server::getInstance()->isOp($sender->getName()) && !$sender->hasPermission("use.spy")){
                $sender->sendMessage($prefix.$noPerm);
            }else{
                if(empty($args)){
                    $sender->sendMessage($prefix." /spy <on | off>");
                }else{
                    if($args[0] == "on"){
                        spy::$SPY[$sender->getName()] = $sender;
                        $sender->sendMessage($prefix.$start);
                    }elseif($args[0] == "off"){
                        unset(spy::$SPY[$sender->getName()]);
                        $sender->sendMessage($prefix.$stop);
                    }else{
                        $sender->sendMessage($prefix." /spy <on | off>");
                    }
                }
            }
        }
    }
}
