<?php

namespace bboyyu51\channeltalk;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PlugunBase{
    public function onEnable(){
        new TalkManager(new Config($this->getDataFolder()."Data.yml", Config::YAML));
    }
    
    public function onDisable(){
        TalkManager::getInatance()->save();
    }
    
    /**
     * Get TalkManager instance
     * 
     * @return TalkManager
     */
    public function getManager(): TalkManager{
        return TalkManager::getInatance();
    }
}