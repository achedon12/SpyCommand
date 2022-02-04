<?php

namespace achedon\commandSpy;

use achedon\commandSpy\commands\spyCMD;
use achedon\commandSpy\events\playerEvents;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\Config;

class spy extends PluginBase implements PluginOwned {

    /**@var Player[] $SPY*/
    public static $SPY = [];
    /** @var spy $instance */
    private static $instance;

    protected function onEnable(): void{
        @mkdir($this->getDataFolder());
        self::$instance = $this;
        $this->getServer()->getCommandMap()->register('Commands',new spyCMD("spy","see all commands","/spy <on | off>"));
        $this->getServer()->getPluginManager()->registerEvents(new playerEvents(),$this);
        PermissionManager::getInstance()->addPermission(new Permission("use.spy"));
        $this->saveResource("config.yml");
    }

    protected function onDisable(): void{
        $this->saveResource("config.yml");
    }

    public static function config(): Config{
        return new Config(self::$instance->getDataFolder() . "config.yml", Config::YAML);
    }

    /** @return spy*/
    public static function getInstance(): spy{
        return self::$instance;
    }

    public function getOwningPlugin(): Plugin{
        return self::getInstance();
    }
}