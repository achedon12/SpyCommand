<?php

namespace achedon\commandSpy\events;

use achedon\commandSpy\spy;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class  playerEvents implements Listener{

    public function onPlayerCommands(PlayerCommandPreprocessEvent $event){
        $cfg = spy::config();
        $prefix = $cfg->get("prefix");
        $messageToReplace = $cfg->get("MessageSpyMode");
        $message = $event->getMessage();
        $player = $event->getPlayer();
        if($cfg->get("ConsoleMessage") == "true"){
            if($message[0] == "/"){
                if(stripos($message,"login") || stripos($message, "log") || stripos($message, "reg") || stripos($message, "register")){
                    spy::getInstance()->getLogger()->info($player->getName()." : command hidden for security reasons");
                }else{
                    spy::getInstance()->getLogger()->info($player->getName()." : ".$message);
                }
            }
        }

        if(!empty(spy::$SPY)){
            foreach(spy::$SPY as $players) {
                if(stripos($message,"login") || stripos($message, "log") || stripos($message, "reg") || stripos($message, "register")){
                    $players->sendMessage($prefix." ".$player->getName()." : command hidden for security reasons");
                }else{
                    $players->sendMessage(str_replace(["{player}","{message}"],[$player->getName(),$message],$messageToReplace));
                }
            }
        }


    }
}